<?php

namespace Tests\Unit;

use App\Services\Cfdi\CfdiCalculator;
use App\Services\Cfdi\CfdiXmlGenerator;
use DOMXPath;
use Tests\TestCase;

final class CfdiXmlGeneratorTest
    extends TestCase
{
    public function test_generates_required_cfdi_structure_and_values(): void
    {
        $data = $this->cfdiData();

        $calculator =
            new CfdiCalculator();

        $totals =
            $calculator->calculate(
                $data['conceptos']
            );

        $generator =
            app(
                CfdiXmlGenerator::class
            );

        $document =
            $generator->generate(
                $data,
                $totals
            );

        $xpath =
            new DOMXPath(
                $document
            );

        $xpath->registerNamespace(
            'cfdi',
            'http://www.sat.gob.mx/cfd/4'
        );

        $comprobante =
            $document->documentElement;

        $this->assertNotNull(
            $comprobante
        );

        $this->assertSame(
            '4.0',
            $comprobante->getAttribute(
                'Version'
            )
        );

        $this->assertSame(
            'I',
            $comprobante->getAttribute(
                'TipoDeComprobante'
            )
        );

        $this->assertSame(
            '8026.46',
            $comprobante->getAttribute(
                'SubTotal'
            )
        );

        $this->assertSame(
            '9310.69',
            $comprobante->getAttribute(
                'Total'
            )
        );

        $emisor =
            $xpath->query(
                '//cfdi:Emisor'
            )->item(0);

        $receptor =
            $xpath->query(
                '//cfdi:Receptor'
            )->item(0);

        $this->assertNotNull(
            $emisor
        );

        $this->assertNotNull(
            $receptor
        );

        $this->assertSame(
            'EKU9003173C9',
            $emisor->getAttribute(
                'Rfc'
            )
        );

        $this->assertSame(
            'CNC140828PQ4',
            $receptor->getAttribute(
                'Rfc'
            )
        );

        $conceptos =
            $xpath->query(
                '//cfdi:Concepto'
            );

        $this->assertSame(
            3,
            $conceptos->length
        );

        $firstConcept =
            $conceptos->item(0);

        $this->assertSame(
            '2296.26',
            $firstConcept->getAttribute(
                'Importe'
            )
        );

        $conceptTaxes =
            $xpath->query(
                '//cfdi:Concepto/cfdi:Impuestos/cfdi:Traslados/cfdi:Traslado'
            );

        $this->assertSame(
            3,
            $conceptTaxes->length
        );

        $firstTax =
            $conceptTaxes->item(0);

        $this->assertSame(
            '2296.260000',
            $firstTax->getAttribute(
                'Base'
            )
        );

        $this->assertSame(
            '0.160000',
            $firstTax->getAttribute(
                'TasaOCuota'
            )
        );

        $this->assertSame(
            '367.401600',
            $firstTax->getAttribute(
                'Importe'
            )
        );

        $globalTaxes =
            $xpath->query(
                '/cfdi:Comprobante/cfdi:Impuestos'
            )->item(0);

        $this->assertNotNull(
            $globalTaxes
        );

        $this->assertSame(
            '1284.23',
            $globalTaxes->getAttribute(
                'TotalImpuestosTrasladados'
            )
        );

        $globalTransfer =
            $xpath->query(
                '/cfdi:Comprobante/cfdi:Impuestos/cfdi:Traslados/cfdi:Traslado'
            )->item(0);

        $this->assertNotNull(
            $globalTransfer
        );

        $this->assertSame(
            '8026.46',
            $globalTransfer->getAttribute(
                'Base'
            )
        );

        $this->assertSame(
            '0.160000',
            $globalTransfer->getAttribute(
                'TasaOCuota'
            )
        );

        $this->assertSame(
            '1284.23',
            $globalTransfer->getAttribute(
                'Importe'
            )
        );
    }

    public function test_groups_global_transferred_taxes_by_rate(): void
    {
        $data =
            $this->cfdiData();

        $data['conceptos'][1]['iva'] =
            '0.080000';

        $calculator =
            new CfdiCalculator();

        $totals =
            $calculator->calculate(
                $data['conceptos']
            );

        $document =
            app(
                CfdiXmlGenerator::class
            )->generate(
                $data,
                $totals
            );

        $xpath =
            new DOMXPath(
                $document
            );

        $xpath->registerNamespace(
            'cfdi',
            'http://www.sat.gob.mx/cfd/4'
        );

        $globalTransfers =
            $xpath->query(
                '/cfdi:Comprobante/cfdi:Impuestos/cfdi:Traslados/cfdi:Traslado'
            );

        $this->assertSame(
            2,
            $globalTransfers->length
        );
    }

    private function cfdiData(): array
    {
        return [
            'comprobante' => [
                'version' => '4.0',
                'tipoDeComprobante' => 'I',
                'exportacion' => '01',
                'formaPago' => '99',
                'metodoPago' => 'PPD',
                'tipoCambio' => '1',
                'moneda' => 'MXN',
                'lugarExpedicion' => '05120',
                'serie' => 'KUAF',
                'folio' => '7189',
            ],

            'emisor' => [
                'rfc' =>
                    'EKU9003173C9',

                'nombre' =>
                    'ESCUELA KEMPER URGATE',

                'regimenFiscal' =>
                    '601',
            ],

            'receptor' => [
                'rfc' =>
                    'CNC140828PQ4',

                'nombre' =>
                    'CENTRO NACIONAL DE CONTROL DE ENERGIA',

                'regimenFiscalReceptor' =>
                    '603',

                'domicilioFiscalReceptor' =>
                    '01010',

                'usoCFDI' =>
                    'G01',
            ],

            'conceptos' => [
                [
                    'cantidad' => '1',
                    'claveUnidad' => 'ZZ',
                    'unidad' =>
                        'Mutuamente definido',
                    'valorUnitario' =>
                        '2296.26',
                    'claveProdServ' =>
                        '83101800',
                    'descripcion' =>
                        'Concepto 1',
                    'objetoImp' =>
                        '02',
                    'iva' =>
                        '0.160000',
                ],
                [
                    'cantidad' => '1',
                    'claveUnidad' => 'ZZ',
                    'unidad' =>
                        'Mutuamente definido',
                    'valorUnitario' =>
                        '5567.40',
                    'claveProdServ' =>
                        '83101800',
                    'descripcion' =>
                        'Concepto 2',
                    'objetoImp' =>
                        '02',
                    'iva' =>
                        '0.160000',
                ],
                [
                    'cantidad' => '1',
                    'claveUnidad' => 'ZZ',
                    'unidad' =>
                        'Mutuamente definido',
                    'valorUnitario' =>
                        '162.80',
                    'claveProdServ' =>
                        '83101800',
                    'descripcion' =>
                        'Concepto 3',
                    'objetoImp' =>
                        '02',
                    'iva' =>
                        '0.160000',
                ],
            ],
        ];
    }
}