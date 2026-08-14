<?php

namespace App\Services\Cfdi;

use DOMDocument;

class CfdiValidator
{
    public function validate(DOMDocument $document): array
    {
        libxml_use_internal_errors(true);

        libxml_clear_errors();

        $xsdPath = config('services.sat.xsd_local');

        if (!$xsdPath) {
            return [
                'valid' => false,
                'errors' => [
                    [
                        'line' => null,
                        'column' => null,
                        'message' => 'No se ha configurado la ruta local del XSD del SAT.',
                    ],
                ],
            ];
        }

        $absolutePath = base_path($xsdPath);

        if (!file_exists($absolutePath)) {
            return [
                'valid' => false,
                'errors' => [
                    [
                        'line' => null,
                        'column' => null,
                        'message' => "No se encontró el XSD en: {$absolutePath}",
                    ],
                ],
            ];
        }

        try {
            $valid = $document->schemaValidate($absolutePath);

            $errors = [];

            foreach (libxml_get_errors() as $error) {
                $errors[] = [
                    'level' => $this->getErrorLevel($error->level),
                    'code' => $error->code,
                    'line' => $error->line,
                    'column' => $error->column,
                    'message' => trim($error->message),
                ];
            }

            libxml_clear_errors();

            return [
                'valid' => $valid,
                'errors' => $errors,
            ];

        } catch (\Throwable $e) {

            libxml_clear_errors();

            return [
                'valid' => false,
                'errors' => [
                    [
                        'line' => null,
                        'column' => null,
                        'message' => $e->getMessage(),
                    ],
                ],
            ];
        }
    }
    private function getErrorLevel(int $level): string
    {
        return match ($level) {
            LIBXML_ERR_WARNING => 'warning',
            LIBXML_ERR_ERROR => 'error',
            LIBXML_ERR_FATAL => 'fatal',
            default => 'unknown',
        };
    }
}