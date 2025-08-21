<?php

namespace App\Application\Service;

use App\Application\Dto\DiscountDto;
use App\Application\Dto\DiscountOrderDto;
use App\Application\Dto\OrderDto;
use App\Domain\Discount\DiscountContract;
use App\Domain\Discount\Exception\DiscountNotApplicableException;

class CalculateDiscountService
{
    public function __construct(
        private array $discounts,
    ) {

    }
    public function calculateDiscount(OrderDto $orderDto): DiscountOrderDto
    {
        $discountOrderDto = new DiscountOrderDto($orderDto);
        /** @var DiscountContract $discount */
        foreach ($this->discounts as $discount)
        {
            try
            {
                $discountPrice = $discount->calculate($orderDto);
                $discountOrderDto->addDiscount(
                    new DiscountDto(
                        $discount->getType(),
                        $discountPrice,
                    )
            );
            } catch (DiscountNotApplicableException)
            {
                //discount not applicable for this order
            }
        }

        return $discountOrderDto;
    }
}
