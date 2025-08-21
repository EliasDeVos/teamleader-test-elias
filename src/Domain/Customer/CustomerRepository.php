<?php

namespace App\Domain\Customer;

use App\Domain\Customer\Customer;

interface CustomerRepository
{
    public function find(string $id): Customer;
}
