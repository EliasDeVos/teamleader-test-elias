<?php
declare(strict_types=1);

namespace App\Domain\Discount;

use App\Application\Dto\OrderDto;
use App\Domain\Customer\CustomerRepository;
use App\Domain\Discount\Exception\DiscountNotApplicableException;
use DateTimeImmutable;
use DateTimeInterface;

class LoyaltyDiscount implements DiscountContract
{
    const LOYALTY_TRESHHOLD = 1000;
    const LOYALTY_DISCOUNT = 0.10;
    public function __construct(
        private CustomerRepository $customerRepository,
    ) {
    }
    public function calculate(OrderDto $orderDto): float
    {
        $customer = $this->customerRepository->find($orderDto->customerId);

        if ($customer->revenue < self::LOYALTY_TRESHHOLD)
        {
            throw new DiscountNotApplicableException();
        }

        return $orderDto->total * self::LOYALTY_DISCOUNT;
    }

    public function getType(): string
    {
        return 'Loyalty';
    }
}
