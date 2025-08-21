<?php
declare(strict_types=1);

namespace App\Domain\Discount;

use App\Application\Dto\OrderDto;

interface DiscountContract
{
    public function calculate(OrderDto $orderDto): float;

    public function getType(): string;
}
