<?php

namespace Gateway\Gateways\Vehicle;

use Gateway\Cache\DiskCacheImpl;
use Gateway\Utils\WebServices as WebServicesUtils;

/**
 * Class SEAPEGatewayImpl
 * @package Gateway\Gateways\Vehicle
 */
class SEAPEGatewayImpl implements SEAPEGateway
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $passwd;

    /**
     * @var string
     */
    CONST SEAPE_ENDPOINT = "http://webservice.seape.com.br/Service-HttpGet/Veicular.aspx?";
    
    /**
     * @var string
     */
    private $vehicleRegisterQuery = "CodigoProduto=428&Placa=%s";
    
    /**
     * @var string
     */
    private $precifierAndDecoderQuery  = "CodigoProduto=505&Chassi=%s";

    /**
     * @var Cache
     */
    private $cacheService;

    /**
     * @var string
     */
    private $auth_param;

    /**
     * SEAPEGatewayImpl constructor.
     * @param $key
     * @param $user
     * @param $auth
     */
    public function __construct($key, $user, $auth)
    {
        $this->cacheService = new DiskCacheImpl("gateway", "/tmp/");;
        $this->key = $key;
        $this->user = $user;
        $this->passwd = $auth;
        $this->auth_param = "&ChaveAcesso={$this->key}&Usuario={$this->user}&Senha={$this->passwd}";
    }

    /**
     * @param string $plate
     * @return mixed|string
     */
    public function fetchVehicleRegisterByPlate($plate)
    {   
        $seapeInfo = $this->cacheService->hasKey($plate . "-seape-428") ? $this->cacheService->get($plate . "-seape-428") : $this->getPlateInfoFromSEAPEWebService($plate);
        return $seapeInfo;
    }

    /**
     * @param string $chassis
     * @return mixed|string
     */
    public function fetchVehicleDecoderWithChassis($chassis)
    {   
        $seapeInfo = $this->cacheService->hasKey($chassis . "-seape-505") ? $this->cacheService->get($chassis . "-seape-505") : $this->getChassisInfoFromSEAPEWebService($chassis);
        return $seapeInfo;
    }

    /**
     * @param $plate
     * @return mixed
     */
    private function getPlateInfoFromSEAPEWebService($plate)
    {
        $uri = sprintf(self::SEAPE_ENDPOINT . $this->vehicleRegisterQuery . $this->auth_param,$plate);
        $data = WebServicesUtils::webServicesToJson($uri);
        $this->cacheService->putInKey($plate . "-seape-428",$data);
        return $data;
    }

    /**
     * @param $chassis
     * @return mixed
     */
    private function getChassisInfoFromSEAPEWebService($chassis)
    {
        $uri = sprintf(self::SEAPE_ENDPOINT . $this->precifierAndDecoderQuery . $this->auth_param,$chassis);
        $data = WebServicesUtils::webServicesToJson($uri);
        $this->cacheService->putInKey($chassis . "-seape-505",$data);
        return $data;
    }
}