<?php
declare(strict_types=1);

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
        define(FUSION_ENDPOINT, "http://swagger.focustel.com.br/api/sms/send?token=" . $this->token);
    }

    /**
     * @param string $number
     * @param string $message
     * @param int $type
     * @return mixed
     */
    public function fetchSmsSend(string $number, string $message, int $type)
    {
        return $this->getInfoFromFusionWebService($number, $message, $type);
    }

    /**
     * @param string $number
     * @param string $message
     * @param int $type
     * @return mixed
     */
    private function getInfoFromFusionWebService(string $number, string $message, int $type)
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
        curl_setopt($ch, CURLOPT_URL, FUSION_ENDPOINT);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $values);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json')
        );
        $dados = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($dados);

        $this->cacheService->putInKey($number."-fusion",$data);
        return $data;
    }
}