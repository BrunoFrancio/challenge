
<?php
namespace App\Infrastructure\Services;

use App\Domain\Repositories\ProductRepositoryInterface;
use App\Domain\Services\ProductServiceInterface;

class ProductService implements ProductServiceInterface {

    protected $repository;

    public function __construct(ProductRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function listProducts() {
        return $this->repository->all();
    }

    public function getProductById($id) {
        return $this->repository->find($id);
    }

    public function updateProduct(array $data, $id) {
        return $this->repository->update($data, $id);
    }

    public function deleteProduct($id) {
        return $this->repository->delete($id);
    }
}
