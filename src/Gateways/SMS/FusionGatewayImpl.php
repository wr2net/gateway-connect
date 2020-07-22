<?php

namespace Gateway\Gateways\SMS;

use Gateway\Cache\Cache;
use Gateway\Utils\WebServices as WebServicesUtils;

/**
 * Class FusionGatewayImpl
 * @package Gateway\Gateways\SMS
 */
class FusionGatewayImpl implements FUSIONGateway
{
    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $token;

    /**
     * @var Cache
     */
    private $cacheService;

    /**
     * @var string
     */
    private $fusion_endpoint;

    /**
     * FusionGatewayImpl constructor.
     * @param Cache $cache
     * @param $user
     * @param $token
     */
    public function __construct(Cache $cache, $user, $token)
    {
        $this->cacheService = $cache;
        $this->user = $user;
        $this->token = $token;
        $this->fusion_endpoint = "http://swagger.focustel.com.br/api/sms/send?token=" . $this->token;
    }

    /**
     * @param string $number
     * @param string $message
     * @param int $type
     * @return mixed|string
     */
    public function fetchSmsSend($number, $message, $type)
    {
        return $this->getInfoFromFusionWebService($number, $message, $type);
    }

    /**
     * @param $number
     * @param $message
     * @param $type
     * @return bool|string
     */
    private function getInfoFromFusionWebService($number, $message, $type)
    {

        $toSend = [
            [
                'number' => '55' . $number,
                'message' => $message
            ]
        ];

        $envio = [
            'user' => $this->user,
            'contact' => $toSend,
            'type' => $type
        ];

        $values = json_encode($envio);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->fusion_endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $values);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json')
        );
        $dados = curl_exec($ch);
        curl_close($ch);

        $this->cacheService->putInKey($number . "-fusion", $dados);
        return $dados;
    }
}