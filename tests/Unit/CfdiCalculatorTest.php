<?php

namespace Tests\Unit;

use App\Services\Cfdi\CfdiCalculator;
use PHPUnit\Framework\TestCase;

final class CfdiCalculatorTest extends TestCase
{
    public function test_calculates_cfdi_totals_correctly(): void
    {
        $conceptos = [
            [
                'cantidad' => '1',
                'valorUnitario' => '2296.26',
                'iva' => '0.160000',
            ],
            [
                'cantidad' => '1',
                'valorUnitario' => '5567.40',
                'iva' => '0.160000',
            ],
            [
                'cantidad' => '1',
                'valorUnitario' => '162.80',
                'iva' => '0.160000',
            ],
        ];

        $calculator = new CfdiCalculator();

        $result = $calculator->calculate($conceptos);

        $this->assertSame(
            '8026.460000',
            $result->subtotal
        );

        $this->assertSame(
            '1284.233600',
            $result->transferredTaxes
        );

        $this->assertSame(
            '9310.693600',
            $result->total
        );

        $this->assertCount(
            3,
            $result->concepts
        );
    }
}