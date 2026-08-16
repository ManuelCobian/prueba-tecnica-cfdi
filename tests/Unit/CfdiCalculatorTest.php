<?php

namespace Tests\Unit;

use App\Services\Cfdi\CfdiCalculator;
use PHPUnit\Framework\TestCase;

final class CfdiCalculatorTest
    extends TestCase
{
    public function test_calculates_cfdi_totals_and_concept_taxes_correctly(): void
    {
        $conceptos = [
            [
                'cantidad' => '1',
                'valorUnitario' =>
                    '2296.26',
                'iva' => '0.160000',
            ],
            [
                'cantidad' => '1',
                'valorUnitario' =>
                    '5567.40',
                'iva' => '0.160000',
            ],
            [
                'cantidad' => '1',
                'valorUnitario' =>
                    '162.80',
                'iva' => '0.160000',
            ],
        ];

        $calculator =
            new CfdiCalculator();

        $result =
            $calculator->calculate(
                $conceptos
            );

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

        $this->assertSame(
            '2296.260000',
            $result->concepts[0]['importe']
        );

        $this->assertSame(
            '2296.260000',
            $result->concepts[0]['base']
        );

        $this->assertSame(
            '367.401600',
            $result
                ->concepts[0]
                ['importeIva']
        );

        $this->assertSame(
            '5567.400000',
            $result->concepts[1]['importe']
        );

        $this->assertSame(
            '890.784000',
            $result
                ->concepts[1]
                ['importeIva']
        );

        $this->assertSame(
            '162.800000',
            $result->concepts[2]['importe']
        );

        $this->assertSame(
            '26.048000',
            $result
                ->concepts[2]
                ['importeIva']
        );
    }
}