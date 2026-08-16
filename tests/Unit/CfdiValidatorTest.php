<?php

namespace Tests\Unit;

use App\Services\Cfdi\CfdiCalculator;
use App\Services\Cfdi\CfdiValidator;
use App\Services\Cfdi\CfdiXmlGenerator;
use DOMDocument;
use Tests\TestCase;

final class CfdiValidatorTest
    extends TestCase
{
    public function test_generated_cfdi_can_be_validated_against_sat_xsd(): void
    {
        $json =
            file_get_contents(
                resource_path(
                    'cfdi/input.json'
                )
            );

        $this->assertNotFalse(
            $json
        );

        $data =
            json_decode(
                $json,
                true,
                512,
                JSON_THROW_ON_ERROR
            );

        $totals =
            app(
                CfdiCalculator::class
            )->calculate(
                $data['conceptos']
            );

        $document =
            app(
                CfdiXmlGenerator::class
            )->generate(
                $data,
                $totals
            );

        $result =
            app(
                CfdiValidator::class
            )->validate(
                $document
            );

        $this->assertTrue(
            $result['valid'],
            $this->formatErrors(
                $result['errors']
            )
        );

        $this->assertSame(
            [],
            $result['errors']
        );
    }

    public function test_invalid_cfdi_returns_xsd_errors(): void
    {
        $document =
            new DOMDocument(
                '1.0',
                'UTF-8'
            );

        $document->loadXML(
            '<?xml version="1.0" encoding="UTF-8"?>'
            . '<cfdi:Comprobante '
            . 'xmlns:cfdi="http://www.sat.gob.mx/cfd/4" '
            . 'Version="4.0"/>'
        );

        $result =
            app(
                CfdiValidator::class
            )->validate(
                $document
            );

        $this->assertFalse(
            $result['valid']
        );

        $this->assertNotEmpty(
            $result['errors']
        );

        $this->assertArrayHasKey(
            'message',
            $result['errors'][0]
        );
    }

    private function formatErrors(
        array $errors
    ): string {
        if ($errors === []) {
            return 'El CFDI no pasó la validación XSD y libxml no devolvió detalle.';
        }

        return implode(
            PHP_EOL,
            array_map(
                static function (
                    array $error
                ): string {
                    return sprintf(
                        '[%s] Línea %s, columna %s: %s',
                        $error['level']
                            ?? 'error',
                        $error['line']
                            ?? '-',
                        $error['column']
                            ?? '-',
                        $error['message']
                            ?? 'Error sin detalle'
                    );
                },
                $errors
            )
        );
    }
}