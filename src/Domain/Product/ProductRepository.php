<?php
declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\Product\Product;

interface ProductRepository
{
    public function find(string $id): Product;
}
