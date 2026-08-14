<?php

namespace App\Data\Cfdi;

final readonly class CfdiTotals
{
    public function __construct(
        public string $subtotal,
        public string $transferredTaxes,
        public string $total,
        public array $concepts,
    ) {
    }
}