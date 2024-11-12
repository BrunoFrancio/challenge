
<?php
namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface {

    public function all() {
        return Product::all();
    }

    public function find($id) {
        return Product::findOrFail($id);
    }

    public function update(array $data, $id) {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function delete($id) {
        $product = Product::findOrFail($id);
        $product->status = 'trash';
        $product->save();
    }
}
