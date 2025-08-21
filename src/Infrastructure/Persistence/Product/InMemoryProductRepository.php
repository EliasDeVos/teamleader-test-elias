<?php

namespace App\Infrastructure\Persistence\Product;

use App\Domain\Discount\Exception\ProductNotFoundException;
use App\Domain\Product\Product;
use App\Domain\Product\ProductRepository;

class InMemoryProductRepository implements ProductRepository
{
    private $products;

    public function __construct()
    {
        $this->products = [
            'A101' => new Product(
                'A101',
                'Screwdriver',
                (int) '1',
                (float) '9.75',
            ),
            'A102' => new Product(
                'A102',
                'Electric screwdriver',
                (int) '1',
                (float) '49.50',
            ),
            'B101' => new Product(
                'B101',
                'Basic on-off switch',
                (int) '2',
                (float) '4.99',
            ),
            'B102' => new Product(
                'B102',
                'Press button',
                (int) '2',
                (float) '4.99',
            ),
            'B103' => new Product(
                'B103',
                'Switch with motion detector',
                (int) '2',
                (float) '12.95',
            ),
        ];
    }

    public function find(string $id): Product
    {
        if (!isset($this->products[$id])) {
            throw new ProductNotFoundException();
        }

        return $this->products[$id];
    }
}
