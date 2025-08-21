<?php

namespace App\Application\Dto;

class OrderDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $customerId,
        public readonly array $items,
        public readonly float $total,
    ) {

    }
}
