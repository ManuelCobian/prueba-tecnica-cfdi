<?php

namespace App\Services\Cfdi;

use App\Data\Cfdi\CfdiTotals;
use DOMDocument;
use DOMElement;
use InvalidArgumentException;

final class CfdiXmlGenerator
{
    private const MONEY_SCALE = 2;
    private const TAX_SCALE = 6;

    public function generate(array $data, CfdiTotals $totals): DOMDocument
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
        $dom->preserveWhiteSpace = false;

        $cfdiNamespace = config('services.sat.namespace');
        $xsiNamespace = config('services.sat.xsi_namespace');
        $xsd = config('services.sat.xsd');

        $comprobante = $dom->createElementNS(
            $cfdiNamespace,
            'cfdi:Comprobante'
        );

        $dom->appendChild($comprobante);

        $comprobante->setAttributeNS(
            'http://www.w3.org/2000/xmlns/',
            'xmlns:xsi',
            $xsiNamespace
        );

        $comprobante->setAttributeNS(
            $xsiNamespace,
            'xsi:schemaLocation',
            $cfdiNamespace . ' ' . $xsd
        );

        $this->addComprobanteAttributes(
            $comprobante,
            $data,
            $totals
        );

        $this->addEmisor(
            $dom,
            $comprobante,
            $data['emisor'],
            $cfdiNamespace
        );

        $this->addReceptor(
            $dom,
            $comprobante,
            $data['receptor'],
            $cfdiNamespace
        );

        $this->addConceptos(
            $dom,
            $comprobante,
            $totals->concepts,
            $cfdiNamespace
        );

        $this->addGlobalTaxes(
            $dom,
            $comprobante,
            $totals,
            $cfdiNamespace
        );

        return $dom;
    }

    private function addComprobanteAttributes(
        DOMElement $comprobante,
        array $data,
        CfdiTotals $totals
    ): void {
        $comprobanteData = $data['comprobante'];

        $comprobante->setAttribute(
            'Version',
            $comprobanteData['version']
        );

        $comprobante->setAttribute(
            'Serie',
            $comprobanteData['serie']
        );

        $comprobante->setAttribute(
            'Folio',
            $comprobanteData['folio']
        );

        $comprobante->setAttribute(
            'Fecha',
            now()->format('Y-m-d\TH:i:s')
        );

        /*
         * Valores simulados únicamente para la prueba técnica.
         * No representan un certificado ni un sello fiscal real.
         */
        $comprobante->setAttribute(
            'Sello',
            $comprobanteData['sello']
                ?? 'SELLO_DE_PRUEBA'
        );

        $comprobante->setAttribute(
            'NoCertificado',
            $comprobanteData['noCertificado']
                ?? '00001000000500000000'
        );

        $comprobante->setAttribute(
            'Certificado',
            $comprobanteData['certificado']
                ?? 'CERTIFICADO_DE_PRUEBA'
        );

        $comprobante->setAttribute(
            'FormaPago',
            $comprobanteData['formaPago']
        );

        $comprobante->setAttribute(
            'SubTotal',
            $this->money($totals->subtotal)
        );

        $comprobante->setAttribute(
            'Moneda',
            $comprobanteData['moneda']
        );

        $comprobante->setAttribute(
            'TipoCambio',
            $comprobanteData['tipoCambio']
        );

        $comprobante->setAttribute(
            'Total',
            $this->money($totals->total)
        );

        $comprobante->setAttribute(
            'TipoDeComprobante',
            $comprobanteData['tipoDeComprobante']
        );

        $comprobante->setAttribute(
            'Exportacion',
            $comprobanteData['exportacion']
        );

        $comprobante->setAttribute(
            'MetodoPago',
            $comprobanteData['metodoPago']
        );

        $comprobante->setAttribute(
            'LugarExpedicion',
            $comprobanteData['lugarExpedicion']
        );
    }

    private function addEmisor(
        DOMDocument $dom,
        DOMElement $comprobante,
        array $data,
        string $cfdiNamespace
    ): void {
        $emisor = $dom->createElementNS(
            $cfdiNamespace,
            'cfdi:Emisor'
        );

        $emisor->setAttribute('Rfc', $data['rfc']);
        $emisor->setAttribute('Nombre', $data['nombre']);
        $emisor->setAttribute(
            'RegimenFiscal',
            $data['regimenFiscal']
        );

        $comprobante->appendChild($emisor);
    }

    private function addReceptor(
        DOMDocument $dom,
        DOMElement $comprobante,
        array $data,
        string $cfdiNamespace
    ): void {
        $receptor = $dom->createElementNS(
            $cfdiNamespace,
            'cfdi:Receptor'
        );

        $receptor->setAttribute('Rfc', $data['rfc']);
        $receptor->setAttribute('Nombre', $data['nombre']);

        $receptor->setAttribute(
            'DomicilioFiscalReceptor',
            $data['domicilioFiscalReceptor']
        );

        $receptor->setAttribute(
            'RegimenFiscalReceptor',
            $data['regimenFiscalReceptor']
        );

        $receptor->setAttribute(
            'UsoCFDI',
            $data['usoCFDI']
        );

        $comprobante->appendChild($receptor);
    }

    private function addConceptos(
        DOMDocument $dom,
        DOMElement $comprobante,
        array $conceptos,
        string $cfdiNamespace
    ): void {
        $conceptosNode = $dom->createElementNS(
            $cfdiNamespace,
            'cfdi:Conceptos'
        );

        foreach ($conceptos as $conceptoData) {
            $this->addConcepto(
                $dom,
                $conceptosNode,
                $conceptoData,
                $cfdiNamespace
            );
        }

        $comprobante->appendChild($conceptosNode);
    }

    private function addConcepto(
        DOMDocument $dom,
        DOMElement $conceptosNode,
        array $data,
        string $cfdiNamespace
    ): void {
        $concepto = $dom->createElementNS(
            $cfdiNamespace,
            'cfdi:Concepto'
        );

        $concepto->setAttribute(
            'ClaveProdServ',
            $data['claveProdServ']
        );

        $concepto->setAttribute(
            'Cantidad',
            $data['cantidad']
        );

        $concepto->setAttribute(
            'ClaveUnidad',
            $data['claveUnidad']
        );

        if (!empty($data['unidad'])) {
            $concepto->setAttribute(
                'Unidad',
                $data['unidad']
            );
        }

        $concepto->setAttribute(
            'Descripcion',
            $data['descripcion']
        );

        $concepto->setAttribute(
            'ValorUnitario',
            $this->money($data['valorUnitario'])
        );

        $concepto->setAttribute(
            'Importe',
            $this->money($data['importe'])
        );

        $concepto->setAttribute(
            'ObjetoImp',
            $data['objetoImp']
        );

        if ($data['objetoImp'] === '02') {
            $this->addConceptTaxes(
                $dom,
                $concepto,
                $data,
                $cfdiNamespace
            );
        }

        $conceptosNode->appendChild($concepto);
    }

    private function addConceptTaxes(
        DOMDocument $dom,
        DOMElement $concepto,
        array $data,
        string $cfdiNamespace
    ): void {
        $impuestos = $dom->createElementNS(
            $cfdiNamespace,
            'cfdi:Impuestos'
        );

        $traslados = $dom->createElementNS(
            $cfdiNamespace,
            'cfdi:Traslados'
        );

        $traslado = $dom->createElementNS(
            $cfdiNamespace,
            'cfdi:Traslado'
        );

        $traslado->setAttribute(
            'Base',
            $this->decimal(
                $data['base'],
                self::TAX_SCALE
            )
        );

        $traslado->setAttribute(
            'Impuesto',
            '002'
        );

        $traslado->setAttribute(
            'TipoFactor',
            'Tasa'
        );

        $traslado->setAttribute(
            'TasaOCuota',
            $this->rate($data['iva'])
        );

        $traslado->setAttribute(
            'Importe',
            $this->decimal(
                $data['importeIva'],
                self::TAX_SCALE
            )
        );

        $traslados->appendChild($traslado);
        $impuestos->appendChild($traslados);
        $concepto->appendChild($impuestos);
    }

    private function addGlobalTaxes(
        DOMDocument $dom,
        DOMElement $comprobante,
        CfdiTotals $totals,
        string $cfdiNamespace
    ): void {
        $taxGroups = $this->groupTransferredTaxes(
            $totals->concepts
        );

        if ($taxGroups === []) {
            return;
        }

        $impuestos = $dom->createElementNS(
            $cfdiNamespace,
            'cfdi:Impuestos'
        );

        $impuestos->setAttribute(
            'TotalImpuestosTrasladados',
            $this->money(
                $totals->transferredTaxes
            )
        );

        $traslados = $dom->createElementNS(
            $cfdiNamespace,
            'cfdi:Traslados'
        );

        foreach ($taxGroups as $taxGroup) {
            $traslado = $dom->createElementNS(
                $cfdiNamespace,
                'cfdi:Traslado'
            );

            $traslado->setAttribute(
                'Base',
                $this->money(
                    $taxGroup['base']
                )
            );

            $traslado->setAttribute(
                'Impuesto',
                '002'
            );

            $traslado->setAttribute(
                'TipoFactor',
                'Tasa'
            );

            $traslado->setAttribute(
                'TasaOCuota',
                $this->rate(
                    $taxGroup['rate']
                )
            );

            $traslado->setAttribute(
                'Importe',
                $this->money(
                    $taxGroup['tax']
                )
            );

            $traslados->appendChild($traslado);
        }

        $impuestos->appendChild($traslados);
        $comprobante->appendChild($impuestos);
    }

    private function groupTransferredTaxes(
        array $concepts
    ): array {
        $groups = [];

        foreach ($concepts as $concept) {
            if (
                ($concept['objetoImp'] ?? null)
                !== '02'
            ) {
                continue;
            }

            $rate = $this->rate(
                $concept['iva']
            );

            if (!isset($groups[$rate])) {
                $groups[$rate] = [
                    'rate' => $rate,
                    'base' => '0.000000',
                    'tax' => '0.000000',
                ];
            }

            $groups[$rate]['base'] = bcadd(
                $groups[$rate]['base'],
                (string) $concept['base'],
                self::TAX_SCALE
            );

            $groups[$rate]['tax'] = bcadd(
                $groups[$rate]['tax'],
                (string) $concept['importeIva'],
                self::TAX_SCALE
            );
        }

        return $groups;
    }

    private function money(
        string|int|float $value
    ): string {
        return $this->decimal(
            $value,
            self::MONEY_SCALE
        );
    }

    private function rate(
        string|int|float $value
    ): string {
        return $this->decimal(
            $value,
            self::TAX_SCALE
        );
    }

    private function decimal(
        string|int|float $value,
        int $scale
    ): string {
        $value = (string) $value;

        if (
            !preg_match(
                '/^-?\d+(?:\.\d+)?$/',
                $value
            )
        ) {
            throw new InvalidArgumentException(
                "El valor '{$value}' no es un decimal válido."
            );
        }

        $half = $scale === 0
            ? '0.5'
            : '0.'
                . str_repeat('0', $scale)
                . '5';

        if (str_starts_with($value, '-')) {
            $half = '-' . $half;
        }

        return bcadd(
            $value,
            $half,
            $scale
        );
    }
}