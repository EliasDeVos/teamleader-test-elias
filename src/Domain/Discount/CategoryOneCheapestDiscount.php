<?php

namespace App\Domain\Discount;

use App\Application\Dto\ItemDto;
use App\Application\Dto\OrderDto;
use App\Domain\Product\ProductRepository;
use App\Domain\Discount\Exception\DiscountNotApplicableException;

class CategoryOneCheapestDiscount implements DiscountContract
{
    const CATEGORY = 1;
    const DISCOUNT = 0.2;
    public function __construct(
        private ProductRepository $productRepository,
    ) {
    }
    public function calculate(OrderDto $orderDto): float
    {
        $cheapestProduct = null;
        /** @var ItemDto $itemDto */
        foreach ($orderDto->items as $itemDto)
        {
            $product = $this->productRepository->find($itemDto->productId);

            if ($product->category !== self::CATEGORY)
            {
                continue;
            }

            if ($cheapestProduct === null)
            {
                $cheapestProduct = $itemDto;
            }

            if ($cheapestProduct->unitPrice > $itemDto->unitPrice)
            {
                $cheapestProduct = $itemDto;
            }
        }

        if ($cheapestProduct === null)
        {
            throw new DiscountNotApplicableException();
        }

        return $cheapestProduct->total * self::DISCOUNT;
    }

    public function getType(): string
    {
        return 'Category 1: cheapest product 10%';
    }
}
