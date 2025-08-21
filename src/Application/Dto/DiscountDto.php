<?php
declare(strict_types=1);

namespace App\Application\Dto;

class DiscountDto
{
    public function __construct(
        public readonly string $type,
        public readonly float $total,
    ) {
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'total' => round($this->total, 3),
        ];
    }
}
