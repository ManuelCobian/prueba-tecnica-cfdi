<?php

namespace App\Services\Cfdi;

use DOMDocument;
use DOMElement;

class CfdiXmlGenerator
{
    public function generate(array $data, array $calculated): DOMDocument
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
            $calculated
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
            $calculated['conceptos'],
            $cfdiNamespace
        );

        $this->addGlobalTaxes(
            $dom,
            $comprobante,
            $calculated,
            $cfdiNamespace
        );

        return $dom;
    }

    private function addComprobanteAttributes(
        DOMElement $comprobante,
        array $data,
        array $calculated
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
            $this->money(
                $calculated['subtotal']
            )
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
            $this->money(
                $calculated['total']
            )
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

        $emisor->setAttribute(
            'Rfc',
            $data['rfc']
        );

        $emisor->setAttribute(
            'Nombre',
            $data['nombre']
        );

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

        $receptor->setAttribute(
            'Rfc',
            $data['rfc']
        );

        $receptor->setAttribute(
            'Nombre',
            $data['nombre']
        );

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
            $this->money(
                $data['valorUnitario']
            )
        );

        $concepto->setAttribute(
            'Importe',
            $this->money(
                $data['importe']
            )
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
            $this->money(
                $data['base']
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
            number_format(
                (float) $data['iva'],
                6,
                '.',
                ''
            )
        );

        $traslado->setAttribute(
            'Importe',
            $this->money(
                $data['importeIva']
            )
        );

        $traslados->appendChild(
            $traslado
        );

        $impuestos->appendChild(
            $traslados
        );

        $concepto->appendChild(
            $impuestos
        );
    }

    private function addGlobalTaxes(
        DOMDocument $dom,
        DOMElement $comprobante,
        array $calculated,
        string $cfdiNamespace
    ): void {
        $impuestos = $dom->createElementNS(
            $cfdiNamespace,
            'cfdi:Impuestos'
        );

        $impuestos->setAttribute(
            'TotalImpuestosTrasladados',
            $this->money(
                $calculated['totalImpuestos']
            )
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
            $this->money(
                $calculated['subtotal']
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
            '0.160000'
        );

        $traslado->setAttribute(
            'Importe',
            $this->money(
                $calculated['totalImpuestos']
            )
        );

        $traslados->appendChild(
            $traslado
        );

        $impuestos->appendChild(
            $traslados
        );

        $comprobante->appendChild(
            $impuestos
        );
    }

    private function money(
        float|int|string $value
    ): string {
        return number_format(
            (float) $value,
            2,
            '.',
            ''
        );
    }
}