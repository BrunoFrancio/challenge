<?php

namespace Tests\Feature;

use App\Domain\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdutoControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa o endpoint GET /products para listar produtos com paginação.
     */
    public function testGetProductsEndpoint()
    {
        // Cria produtos para teste
        Product::factory()->count(15)->create();

        // Faz a requisição GET para /api/products
        $response = $this->getJson('/api/products');

        // Valida se o status da resposta é 200 e se a estrutura da resposta está correta
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'code',
                        'product_name',
                        'status',
                        'quantity',
                        'brands',
                        'categories',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    /**
     * Testa o endpoint GET /products/{codigo} para obter os detalhes de um produto específico.
     */
    public function testGetProductByCodeEndpoint()
    {
        $product = Product::factory()->create(['code' => '12345']);

        $response = $this->getJson('/api/products/' . $product->code);

        $response->assertStatus(200)
            ->assertJson([
                'code' => $product->code,
                'product_name' => $product->product_name,
                'status' => $product->status,
            ]);
    }

    /**
     * Testa o endpoint PUT /products/{codigo} para atualizar um produto.
     */
    public function testUpdateProductEndpoint()
    {
        $product = Product::factory()->create(['code' => '12345']);

        $updateData = [
            'product_name' => 'Nome atualizado',
            'quantity' => '500ml',
            'brands' => 'Marca Teste',
            'categories' => 'Categoria Teste',
        ];

        $response = $this->putJson('/api/products/' . $product->code, $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'mensagem' => 'Produto atualizado com sucesso',
                'produto' => [
                    'product_name' => 'Nome atualizado',
                    'quantity' => '500ml',
                    'brands' => 'Marca Teste',
                    'categories' => 'Categoria Teste',
                ],
            ]);

        $this->assertDatabaseHas('products', $updateData);
    }

    /**
     * Testa o endpoint PUT /products/{codigo} com um código de produto inexistente.
     */
    public function testUpdateNonExistentProduct()
    {
        $updateData = [
            'product_name' => 'Nome inexistente',
            'quantity' => '500ml',
            'brands' => 'Marca Teste',
        ];

        $response = $this->putJson('/api/products/99999', $updateData);

        $response->assertStatus(404)
            ->assertJson([
                'mensagem' => 'Produto não encontrado',
            ]);
    }
}
