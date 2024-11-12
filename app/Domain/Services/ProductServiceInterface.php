
<?php

namespace App\Domain\Services;

interface ProductServiceInterface {
    public function listProducts();
    public function getProductById($id);
    public function updateProduct(array $data, $id);
    public function deleteProduct($id);
}
