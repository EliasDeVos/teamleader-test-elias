<?php

namespace App\Application\Dto;

class ItemDto
{
    public function __construct(
        public readonly string $productId,
        public readonly int $quantity,
        public readonly float $unitPrice,
        public readonly float $total,
    ) {

    }
}
