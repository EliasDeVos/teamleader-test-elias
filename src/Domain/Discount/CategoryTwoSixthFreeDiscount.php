<?php

namespace App\Domain\Discount;

use App\Application\Dto\ItemDto;
use App\Application\Dto\OrderDto;
use App\Domain\Product\ProductRepository;
use App\Domain\Discount\Exception\DiscountNotApplicableException;

class CategoryTwoSixthFreeDiscount implements DiscountContract
{
    const CATEGORY = 2;
    public function __construct(
        private ProductRepository $productRepository,
    ) {
    }
    public function calculate(OrderDto $orderDto): float
    {
        $total = 0;
        /** @var ItemDto $itemDto */
        foreach ($orderDto->items as $itemDto)
        {
            try {
                $total += $this->calculateItemDiscount($itemDto);
            } catch (DiscountNotApplicableException)
            {
                continue;
            }
        }

        if ($total === 0)
        {
            throw new DiscountNotApplicableException();
        }

        return $total;
    }

    public function calculateItemDiscount(ItemDto $itemDto): float
    {
        if ($itemDto->quantity <= 5)
        {
            //only applies to 6 or more products
            throw new DiscountNotApplicableException();
        }
        $product = $this->productRepository->find($itemDto->productId);

        if ($product->category !== self::CATEGORY)
        {
            throw new DiscountNotApplicableException();
        }

        $amountOfFiveItems = floor($itemDto->quantity / 5);

        return $itemDto->unitPrice * $amountOfFiveItems;
    }

    public function getType(): string
    {
        return 'Category 2: 5+1';
    }
}
