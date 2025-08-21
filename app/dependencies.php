<?php

use App\Application\Service\CalculateDiscountService;
use App\Domain\Customer\CustomerRepository;
use App\Domain\Discount\CategoryOneCheapestDiscount;
use App\Domain\Product\ProductRepository;
use App\Domain\Discount\CategoryTwoSixthFreeDiscount;
use App\Domain\Discount\LoyaltyDiscount;
use App\Infrastructure\Persistence\Customer\InMemoryCustomerRepository;
use App\Infrastructure\Persistence\Product\InMemoryProductRepository;
use DI\ContainerBuilder;
use function DI\autowire;
use function DI\create;
use function DI\get;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        CustomerRepository::class => autowire(InMemoryCustomerRepository::class),
        ProductRepository::class => autowire(InMemoryProductRepository::class),
        CalculateDiscountService::class => create()
            ->constructor([
                get(LoyaltyDiscount::class),
                get(CategoryTwoSixthFreeDiscount::class),
                get(CategoryOneCheapestDiscount::class),
            ])
    ]);
};
