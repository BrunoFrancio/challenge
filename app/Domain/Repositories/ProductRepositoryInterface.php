
<?php
namespace App\Domain\Repositories;

interface ProductRepositoryInterface {
    public function all();
    public function find($id);
    public function update(array $data, $id);
    public function delete($id);
}
