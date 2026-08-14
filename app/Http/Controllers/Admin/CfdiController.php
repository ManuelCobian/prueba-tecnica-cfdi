<?php

namespace App\Http\Controllers\Admin;

use App\Services\Cfdi\CfdiCalculator;
use App\Services\Cfdi\CfdiXmlGenerator;
use App\Services\Cfdi\CfdiValidator;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use JsonException;
use Throwable;

class CfdiController extends BaseController
{
    public function generate(
        CfdiCalculator $calculator,
        CfdiXmlGenerator $generator,
        CfdiValidator $validator
    ): Response|JsonResponse {

        try {

            $jsonPath = resource_path('cfdi/input.json');

            if (!file_exists($jsonPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró el archivo JSON de entrada.',
                ], 404);
            }

            $json = file_get_contents($jsonPath);

            if ($json === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'No fue posible leer el archivo JSON.',
                ], 500);
            }

            $data = json_decode(
                $json,
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            if (
                !isset($data['comprobante']) ||
                !isset($data['emisor']) ||
                !isset($data['receptor']) ||
                !isset($data['conceptos'])
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'El JSON no contiene la estructura requerida.',
                ], 422);
            }

            $calculated = $calculator->calculate(
                $data['conceptos']
            );

            $document = $generator->generate(
                $data,
                $calculated
            );

            $validation = $validator->validate(
                $document
            );

            if (!$validation['valid']) {

                return response()->json([
                    'success' => false,
                    'message' => 'El XML generado no es válido contra el XSD del SAT.',
                    'validation' => $validation,
                    'xml' => $document->saveXML(),
                ], 422);
            }

            $serie = $data['comprobante']['serie'];

            $folio = $data['comprobante']['folio'];

            $filename = sprintf(
                'CFDI-%s-%s.xml',
                $serie,
                $folio
            );

            $xml = $document->saveXML();

            Storage::disk('local')->put(
                'cfdi/'.$filename,
                $xml
            );

            return response(
                $xml,
                200,
                [
                    'Content-Type' => 'application/xml; charset=UTF-8',

                    'Content-Disposition' =>
                        'attachment; filename="'.$filename.'"',
                ]
            );

        } catch (JsonException $e) {

            return response()->json([
                'success' => false,
                'message' => 'El JSON de entrada no tiene un formato válido.',
                'error' => $e->getMessage(),
            ], 422);

        } catch (Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al generar el CFDI.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
