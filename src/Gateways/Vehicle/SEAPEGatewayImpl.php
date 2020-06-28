<?php
declare(strict_types=1);

namespace Gateway\Gateways\Vehicle;


use Gateway\Cache\Cache;
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
     * SEAPEGatewayImpl constructor.
     * @param Cache $cache
     * @param $key
     * @param $user
     * @param $auth
     */
    public function __construct(Cache $cache, $key, $user, $auth)
    {
        $this->cacheService = $cache;
        $this->key = $key;
        $this->user = $user;
        $this->passwd = $auth;
        define(AUTH_PARAM, "&ChaveAcesso={$this->key}&Usuario={$this->user}&Senha={$this->passwd}");
    }

    /**
     * @param string $plate
     * @return string
     */
    public function fetchVehicleRegisterByPlate(string $plate) : string
    {   
        $seapeInfo = $this->cacheService->hasKey($plate."-seape-428") ? $this->cacheService->get($plate."-seape-428") : $this->getPlateInfoFromSEAPEWebService($plate);
        return $seapeInfo;
    }

    /**
     * @param string $chassis
     * @return string
     */
    public function fetchVehicleDecoderWithChassis(string $chassis) : string
    {   
        $seapeInfo = $this->cacheService->hasKey($plate."-seape-505") ? $this->cacheService->get($plate."-seape-505") : $this->getChassisInfoFromSEAPEWebService($chassis);
        return $seapeInfo;
    }

    /**
     * @param string $plate
     * @return string
     */
    private function getPlateInfoFromSEAPEWebService(string $plate) : string  {
        $uri = sprintf(self::SEAPE_ENDPOINT.$this->vehicleRegisterQuery.AUTH_PARAM,$plate);
        $data = WebServicesUtils::webServicesToJson($uri);
        $this->cacheService->putInKey($plate."-seape-428",$data);
        return $data;
    }

    /**
     * @param string $chassis
     * @return string
     */
    private function getChassisInfoFromSEAPEWebService(string $chassis) : string  {
        $uri = sprintf(self::SEAPE_ENDPOINT.$this->precifierAndDecoderQuery.AUTH_PARAM,$chassis);
        $data = WebServicesUtils::webServicesToJson($uri);
        $this->cacheService->putInKey($chassis."-seape-505",$data);
        return $data;
    }
}