<?php

namespace App\Services\Cfdi;

use App\Data\Cfdi\CfdiTotals;

final class CfdiCalculator
{
    private const SCALE = 6;

    public function calculate(array $conceptos): CfdiTotals
    {
        $subtotal = '0.000000';
        $totalImpuestos = '0.000000';
        $conceptosCalculados = [];

        foreach ($conceptos as $concepto) {

            $importe = bcmul(
                (string) $concepto['cantidad'],
                (string) $concepto['valorUnitario'],
                self::SCALE
            );

            $base = $importe;

            $importeIva = bcmul(
                $base,
                (string) $concepto['iva'],
                self::SCALE
            );

            $subtotal = bcadd(
                $subtotal,
                $importe,
                self::SCALE
            );

            $totalImpuestos = bcadd(
                $totalImpuestos,
                $importeIva,
                self::SCALE
            );

            $conceptosCalculados[] = array_merge(
                $concepto,
                [
                    'importe' => $importe,
                    'base' => $base,
                    'importeIva' => $importeIva,
                ]
            );
        }

        $total = bcadd(
            $subtotal,
            $totalImpuestos,
            self::SCALE
        );

        return new CfdiTotals(
            subtotal: $subtotal,
            transferredTaxes: $totalImpuestos,
            total: $total,
            concepts: $conceptosCalculados
        );
    }
}