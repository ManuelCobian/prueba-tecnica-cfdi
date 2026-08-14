<?php

namespace App\Services\Cfdi;

class CfdiCalculator
{
    public function calculate(array $conceptos): array
    {
        $subtotal = 0;
        $totalImpuestos = 0;
        $calculatedConcepts = [];

        foreach ($conceptos as $concepto) {

            $cantidad = (float) $concepto['cantidad'];
            $valorUnitario = (float) $concepto['valorUnitario'];
            $tasaIva = (float) $concepto['iva'];

            $importe = $cantidad * $valorUnitario;

            $base = $importe;

            $iva = $base * $tasaIva;

            $subtotal += $importe;
            $totalImpuestos += $iva;

            $calculatedConcepts[] = array_merge(
                $concepto,
                [
                    'importe' => $importe,
                    'base' => $base,
                    'importeIva' => $iva,
                ]
            );
        }

        $total = $subtotal + $totalImpuestos;

        return [
            'conceptos' => $calculatedConcepts,
            'subtotal' => $subtotal,
            'totalImpuestos' => $totalImpuestos,
            'total' => $total,
        ];
    }
}