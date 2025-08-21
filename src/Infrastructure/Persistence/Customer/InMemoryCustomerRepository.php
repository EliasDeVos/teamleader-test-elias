<?php

namespace App\Infrastructure\Persistence\Customer;

use App\Domain\Customer\Customer;
use App\Domain\Customer\CustomerRepository;
use App\Domain\Discount\Exception\CustomerNotFoundException;

class InMemoryCustomerRepository implements CustomerRepository
{
    private $customers;

    public function __construct()
    {
        $this->customers = [
            1 => new Customer(
                (int) '1',
                'Coca Cola',
                '2014-06-28',
                (float) '492.12',
            ),
            2 => new Customer(
                (int) '1',
                'Teamleader',
                '2015-01-15',
                (float) '1505.95',
            ),
            3 => new Customer(
                (int) '3',
                'Jeroen De Wit',
                '2016-02-11',
                (float) '0.00'
            ),
        ];
    }

    public function find(string $id): Customer
    {
        if (!isset($this->customers[(int) $id])) {
            throw new CustomerNotFoundException();
        }

        return $this->customers[(int) $id];
    }
}
