<?php

namespace App\Domain\Product;

class Product
{
    public function __construct(
        public readonly string $id,
        public readonly string $description,
        public readonly int $category,
        public readonly float $price
    ) {
    }
}
