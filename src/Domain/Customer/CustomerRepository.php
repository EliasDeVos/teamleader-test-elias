<?php
declare(strict_types=1);

namespace App\Domain\Customer;

use App\Domain\Customer\Customer;

interface CustomerRepository
{
    public function find(string $id): Customer;
}
