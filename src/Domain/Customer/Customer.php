<?php
declare(strict_types=1);

namespace App\Domain\Customer;

use DateTimeImmutable;
use DateTimeInterface;

class Customer
{
    public DateTimeInterface $since;
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        string $since,
        public readonly float $revenue
    ) {
        $this->since = new DateTimeImmutable($since);
    }

    public function getSince(): string
    {
        return $this->since->format(DATE_ATOM);
    }
}
