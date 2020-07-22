<?php
declare(strict_types=1);

namespace Gateway\Gateways\Vehicle;

use Gateway\Cache\Cache;
use Gateway\Utils\WebServices as WebServicesUtils;

/**
 * Class UNICHECKGatewayImpl
 * @package Gateway\Gateways\Vehicle
 */
class UNICHECKGatewayImpl implements UNICHECKGateway
{
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
    private CONST UNICHECK_ENDPOINT = "http://ws.unicheck.com.br/unicheck-api/veiculo/agregados/%s";

    /**
     * @var string
     */
    private $auth;

    /**
     * @var Cache
     */
    private $cacheService;

    /**
     * UNICHECKGatewayImpl constructor.
     * @param Cache $cache
     * @param $user
     * @param $auth
     */
    public function __construct(Cache $cache, $user, $auth)
    {
        $this->cacheService = $cache;
        $this->user = $user;
        $this->passwd = $auth;
        $this->auth = \base64_encode($this->user. ':'. $this->passwd);
    }

    /**
     * @param string $plate
     * @return string
     */
    public function fetchVehicleInformation(string $plate) : string
    {   
        $unicheckInfo = $this->cacheService->hasKey($plate."-unicheck") ? $this->cacheService->get($plate."-unicheck") : $this->getInfoFromUNICHECKWebService($plate);
        return $unicheckInfo;
    }

    /**
     * @param string $plate
     * @return string
     */
    private function getInfoFromUNICHECKWebService(string $plate) : string {
     
        $uri = sprintf(self::UNICHECK_ENDPOINT,$plate);
        
        $ch = curl_init();  
        curl_setopt($ch,CURLOPT_URL,$uri);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_TIMEOUT, 30); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Basic ".$this->auth
        ));
 
        $output=curl_exec($ch);
        curl_close($ch);

        $this->cacheService->putInKey($plate."-unicheck",$output);
        return $output;
    }
}

