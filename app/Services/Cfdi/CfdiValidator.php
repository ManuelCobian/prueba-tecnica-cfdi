<?php

namespace App\Services\Cfdi;

use DOMDocument;
use Throwable;

final class CfdiValidator
{
    public function validate(
        DOMDocument $document
    ): array {
        $previousInternalErrors =
            libxml_use_internal_errors(true);

        libxml_clear_errors();

        try {
            $xsdPath = config(
                'services.sat.xsd_local'
            );

            if (!$xsdPath) {
                return $this->failure(
                    'No se ha configurado la ruta local del XSD del SAT.'
                );
            }

            $absolutePath = base_path(
                $xsdPath
            );

            if (!is_file($absolutePath)) {
                return $this->failure(
                    "No se encontró el XSD en: {$absolutePath}"
                );
            }

            $valid = $document->schemaValidate(
                $absolutePath
            );

            $errors = [];

            foreach (
                libxml_get_errors()
                as $error
            ) {
                $errors[] = [
                    'level' =>
                        $this->getErrorLevel(
                            $error->level
                        ),

                    'code' =>
                        $error->code,

                    'line' =>
                        $error->line,

                    'column' =>
                        $error->column,

                    'message' =>
                        trim(
                            $error->message
                        ),
                ];
            }

            return [
                'valid' => $valid,
                'errors' => $errors,
            ];
        } catch (Throwable $exception) {
            return $this->failure(
                $exception->getMessage()
            );
        } finally {
            libxml_clear_errors();

            libxml_use_internal_errors(
                $previousInternalErrors
            );
        }
    }

    private function failure(
        string $message
    ): array {
        return [
            'valid' => false,

            'errors' => [
                [
                    'level' => 'error',
                    'code' => null,
                    'line' => null,
                    'column' => null,
                    'message' => $message,
                ],
            ],
        ];
    }

    private function getErrorLevel(
        int $level
    ): string {
        return match ($level) {
            LIBXML_ERR_WARNING =>
                'warning',

            LIBXML_ERR_ERROR =>
                'error',

            LIBXML_ERR_FATAL =>
                'fatal',

            default =>
                'unknown',
        };
    }
}