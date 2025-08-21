<?php
declare(strict_types=1);

namespace Tests\Application\Actions\Order;

use Fig\Http\Message\RequestMethodInterface;
use Slim\Psr7\Factory\ServerRequestFactory;
use Tests\TestCase;

class GetDiscountActionTest extends TestCase
{
    public function testOrder1()
    {
        $app = $this->getAppInstance();

        $request = (new ServerRequestFactory())
            ->createServerRequest(RequestMethodInterface::METHOD_GET, '/discounts')
            ->withQueryParams([
                'id' => '1',
                'customer-id' => '1',
                'items' => [
                    [
                        'product-id' => 'B102',
                        'quantity' => '10',
                        'unit-price' => '4.99',
                        'total' => '49.90',
                    ]
                ],
                'total' => '49.90',
            ]
        );

        $response = $app->handle($request);

        $payload = json_decode((string) $response->getBody(), true);

        $this->assertEquals(
            [
                'total_discount' => 9.98,
                'discounts' => [
                    [
                        'type' => 'Category 2: 5+1',
                        'total' => 9.98
                    ]
                ],
            ],
            $payload
        );
    }

    public function testOrder2()
    {
        $app = $this->getAppInstance();

        $request = (new ServerRequestFactory())
            ->createServerRequest(RequestMethodInterface::METHOD_GET, '/discounts')
            ->withQueryParams([
                'id' => '2',
                'customer-id' => '2',
                'items' => [
                    [
                        'product-id' => 'B102',
                        'quantity' => '5',
                        'unit-price' => '4.99',
                        'total' => '24.95',
                    ]
                ],
                'total' => '24.95',
            ]
        );

        $response = $app->handle($request);

        $payload = json_decode((string) $response->getBody(), true);

        $this->assertEquals(
            [
                'total_discount' => 2.495,
                'discounts' => [
                    [
                        'type' => 'Loyalty',
                        'total' => 2.495,
                    ],
                ],
            ],
            $payload
        );
    }

    public function testOrder3()
    {
        $app = $this->getAppInstance();

        $request = (new ServerRequestFactory())
            ->createServerRequest(RequestMethodInterface::METHOD_GET, '/discounts')
            ->withQueryParams([
                'id' => '3',
                'customer-id' => '3',
                'items' => [
                    [
                        'product-id' => 'A101',
                        'quantity' => '2',
                        'unit-price' => '9.75',
                        'total' => '19.50',
                    ],
                    [
                        'product-id' => 'A102',
                        'quantity' => '1',
                        'unit-price' => '49.50',
                        'total' => '49.50',
                    ]
                ],
                'total' => '69.00',
            ]
        );

        $response = $app->handle($request);

        $payload = json_decode((string) $response->getBody(), true);

        $this->assertEquals(
            [
                'total_discount' => 3.9,
                'discounts' => [
                    [
                        'type' => 'Category 1: cheapest product 10%',
                        'total' => 3.9,
                    ],
                ],
            ],
            $payload
        );
    }
}
