<?php

namespace App\Application\Dto;

class DiscountOrderDto
{
    private array $discounts = [];
    public function __construct(
    ) {

    }

    public function addDiscount(DiscountDto $discountDto): void
    {
        $this->discounts[] = $discountDto;
    }

    public function getTotal(): float
    {
        return 0.0;
    }

    public function toArray(): array
    {
        return [
            'total_discount' => round(array_reduce($this->discounts, fn($carry, DiscountDto $discountDto) => $carry + $discountDto->total, 0), 3),
            'discounts' => array_map(fn(DiscountDto $discountDto) => $discountDto->toArray(), $this->discounts),
        ];
    }
}
