<?php
declare(strict_types=1);

namespace App\Application\Actions\Order;

use App\Application\Dto\ItemDto;
use App\Application\Dto\OrderDto;
use App\Application\Service\CalculateDiscountService;
use App\Domain\Customer\CustomerRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DiscountAction
{
    public function __construct(
        private CalculateDiscountService $calculateDiscountService,
    ) {

    }
    public function action(Request $request, Response $response, array $args): Response
    {
        $params = $request->getQueryParams();

        $orderDto = new OrderDto(
            $params['id'],
            $params['customer-id'],
            array_map(
                fn($item) => new ItemDto(
                    $item['product-id'],
                    (int) $item['quantity'],
                    (float) $item['unit-price'],
                    (float) $item['total'],
                ),
                $params['items']
            ),
            (float) $params['total'],
        );

        $discountOrderDto = $this->calculateDiscountService->calculateDiscount($orderDto);

        $response->getBody()->write(json_encode($discountOrderDto->toArray()));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
