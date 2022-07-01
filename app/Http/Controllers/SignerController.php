<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpCfdi\Credentials\Certificate;
use PhpCfdi\Credentials\Credential;
use PhpCfdi\Credentials\PrivateKey;
use PhpCfdi\Finkok\FinkokEnvironment;
use PhpCfdi\Finkok\FinkokSettings;
use PhpCfdi\Finkok\QuickFinkok;
use PhpCfdi\Finkok\Services\Manifest\GetContractsCommand;
use PhpCfdi\Finkok\Services\Manifest\GetContractsService;

class SignerController extends Controller
{
    /** @var FinkokSettings $_finkokSettings */
    private $_finkokSettings;

    public function __construct()
    {
        if ((bool) env('FINKOK_WS_IS_SANDBOX')) {
            $this->_finkokSettings = new FinkokSettings(
                env('FINKOK_WS_SANDBOX_USERNAME'),
                env('FINKOK_WS_SANDBOX_SECRET'),
                FinkokEnvironment::makeDevelopment()
            );
        } else {
            $this->_finkokSettings = new FinkokSettings(
                env('FINKOK_WS_PRODUCTION_USERNAME'),
                env('FINKOK_WS_PRODUCTION_SECRET'),
                FinkokEnvironment::makeProduction()
            );
        }
    }

    /**
     * It obtains the contracts for the given RFC, name, address and email
     * @param Request request The HTTP request object.
     * @return The response is a JSON object with two properties:
     * - contract: The contract in PDF format.
     * - privacy: The privacy policy in PDF format.
     */
    public function obtainContracts(Request $request)
    {
        $rfc = $request->post('rfc');
        $name = $request->post('name');
        $address = $request->post('address');
        $email = $request->post('email');

        $service = new GetContractsService($this->_finkokSettings);
        $command = new GetContractsCommand($rfc, $name, $address, $email);
        $result = $service->obtainContracts($command);

        return response()->json([
            'contract' => $result->contract(),
            'privacy' => $result->privacy()
        ], 201);
    }

    /**
     * It signs and sends the contracts to the customer
     *
     * @param Request request The request object.
     *
     * @return \Illuminate\Http\JsonResponse response
     * is a json object with the following structure:
     * ```json
     * {
     *     "status": "success",
     *     "message": "",
     *     "data": {
     *         "uuid": "",
     *         "date": "",
     *         "total": "",
     *         "xml": "",
     *         "pdf": "",
     *         "cadena": ""
     *     }
     * }
     */
    public function signAndSend(Request $request)
    {
        $this->validate($request, [
            'passPhrase' => 'required|string',
            'snid' => 'required|string',
            'email' => 'required|string|email',
            'cer' => 'required',
            'key' => 'required',
        ]);

        $passPhrase = $request->post('passPhrase');
        $snid = $request->post('snid');
        $address = $request->post('address') ?? '';
        $email = $request->post('email');
        $certificateContents = $request->file('cer')->getContent();
        $keySource = $request->file('key')->getContent();

        $certificate = new Certificate($certificateContents);
        $key = new PrivateKey($keySource, $passPhrase);
        $fiel = new Credential(
            $certificate,
            $key,
        );

        $quickFinkok = new QuickFinkok($this->_finkokSettings);
        $result = $quickFinkok->customerSignAndSendContracts(
            $fiel,
            $snid,
            $address,
            $email
        );

        return response()->json([
            'success' => $result->success(),
            'message' => $result->message(),
            'data' => $result->rawData(),
        ]);
    }
}
