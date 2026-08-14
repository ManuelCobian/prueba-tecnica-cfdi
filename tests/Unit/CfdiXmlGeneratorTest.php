<?php

namespace Tests\Unit;

use App\Data\Cfdi\CfdiTotals;
use App\Services\Cfdi\CfdiXmlGenerator;
use DOMXPath;
use Tests\TestCase;

final class CfdiXmlGeneratorTest extends TestCase
{
    public function test_generates_required_cfdi_structure(): void
    {
        $data = [
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
                'rfc' => 'EKU9003173C9',
                'nombre' => 'ESCUELA KEMPER URGATE',
                'regimenFiscal' => '601',
            ],

            'receptor' => [
                'rfc' => 'CNC140828PQ4',
                'nombre' => 'CENTRO NACIONAL DE CONTROL DE ENERGIA',
                'regimenFiscalReceptor' => '603',
                'domicilioFiscalReceptor' => '01010',
                'usoCFDI' => 'G01',
            ],
        ];

        $concepts = [
            [
                'cantidad' => '1',
                'claveUnidad' => 'ZZ',
                'unidad' => 'Mutuamente definido',
                'valorUnitario' => '2296.26',
                'claveProdServ' => '83101800',
                'descripcion' => 'Concepto 1',
                'objetoImp' => '02',
                'iva' => '0.160000',
                'importe' => '2296.260000',
                'base' => '2296.260000',
                'importeIva' => '367.401600',
            ],
            [
                'cantidad' => '1',
                'claveUnidad' => 'ZZ',
                'unidad' => 'Mutuamente definido',
                'valorUnitario' => '5567.40',
                'claveProdServ' => '83101800',
                'descripcion' => 'Concepto 2',
                'objetoImp' => '02',
                'iva' => '0.160000',
                'importe' => '5567.400000',
                'base' => '5567.400000',
                'importeIva' => '890.784000',
            ],
            [
                'cantidad' => '1',
                'claveUnidad' => 'ZZ',
                'unidad' => 'Mutuamente definido',
                'valorUnitario' => '162.80',
                'claveProdServ' => '83101800',
                'descripcion' => 'Concepto 3',
                'objetoImp' => '02',
                'iva' => '0.160000',
                'importe' => '162.800000',
                'base' => '162.800000',
                'importeIva' => '26.048000',
            ],
        ];

        $totals = new CfdiTotals(
            subtotal: '8026.460000',
            transferredTaxes: '1284.233600',
            total: '9310.693600',
            concepts: $concepts
        );

        $generator = app(CfdiXmlGenerator::class);

        $document = $generator->generate(
            $data,
            $totals
        );

        $xpath = new DOMXPath($document);

        $xpath->registerNamespace(
            'cfdi',
            'http://www.sat.gob.mx/cfd/4'
        );

        $comprobante = $document->documentElement;

        $this->assertSame(
            '4.0',
            $comprobante->getAttribute('Version')
        );

        $this->assertSame(
            '8026.46',
            $comprobante->getAttribute('SubTotal')
        );

        $this->assertSame(
            '9310.69',
            $comprobante->getAttribute('Total')
        );

        $this->assertSame(
            1,
            $xpath->query('//cfdi:Emisor')->length
        );

        $this->assertSame(
            1,
            $xpath->query('//cfdi:Receptor')->length
        );

        $this->assertSame(
            3,
            $xpath->query('//cfdi:Concepto')->length
        );

        $this->assertSame(
            3,
            $xpath->query(
                '//cfdi:Concepto/cfdi:Impuestos/cfdi:Traslados/cfdi:Traslado'
            )->length
        );

        $globalTaxes = $xpath->query(
            '/cfdi:Comprobante/cfdi:Impuestos'
        )->item(0);

        $this->assertNotNull($globalTaxes);

        $this->assertSame(
            '1284.23',
            $globalTaxes->getAttribute(
                'TotalImpuestosTrasladados'
            )
        );
    }
}