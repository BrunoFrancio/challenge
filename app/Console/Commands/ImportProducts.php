<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Domain\Models\Product;
use Illuminate\Support\Facades\Http;
use App\Notifications\SyncFailedNotification;
use Illuminate\Support\Facades\Notification;

class ImportProducts extends Command
{
    protected $signature = 'products:import';
    protected $description = 'Importa dados dos produtos do Open Food Facts';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        ini_set('memory_limit', '512M');
        $this->info('Iniciando a importação dos produtos...');
        
        try {
            $url = 'https://challenges.coode.sh/food/data/json/products_01.json.gz';
            $response = Http::get($url);

            if ($response->ok()) {
                $gzPath = storage_path('app/products_01.json.gz');
                file_put_contents($gzPath, $response->body());

                $json = gzopen($gzPath, 'rb');
                $counter = 0;

                while (!gzeof($json) && $counter < 100) {
                    $line = gzgets($json);
                    $productData = json_decode($line, true);

                    if (is_array($productData) && isset($productData['code'])) {
                        $cleanCode = trim($productData['code'], '"');

                        Product::updateOrCreate(
                            ['code' => $cleanCode],
                            [
                                'status' => 'draft',
                                'imported_t' => now(),
                                'url' => $productData['url'] ?? null,
                            ]
                        );
                        $counter++;
                    }
                }

                gzclose($json);
                unlink($gzPath);

                $this->info('Produtos importados com sucesso.');
            } else {
                throw new \Exception('Falha ao baixar o arquivo: ' . $response->status());
            }

        } catch (\Exception $e) {
            $errorDetails = $e->getMessage();
            Notification::route('mail', 'brunofrancio@gmail.com')
                ->notify(new SyncFailedNotification($errorDetails));
            $this->error('Erro durante a sincronização: ' . $errorDetails);
        }
    }
}
