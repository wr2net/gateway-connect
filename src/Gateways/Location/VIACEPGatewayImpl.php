<?php

namespace Gateway\Gateways\Location;

/**
 * Class VIACEPGatewayImpl
 * @package Gateway\Gateways\Location
 */
class VIACEPGatewayImpl implements VIACEPGateway
{

    /**
     * @var string
     */
    CONST VIACEP_ENDPOINT = "http://viacep.com.br/ws/%s/json/";

    /**
     * @param string $cep
     * @return string
     */
    public function fetchLocation($cep)
    {
        if (strlen($cep) != 8) {
            return null;
        }
        $uri = sprintf(self::VIACEP_ENDPOINT,$cep);
        
        $ch = curl_init();  
        curl_setopt($ch,CURLOPT_URL,$uri);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_TIMEOUT, 30); 
 
        $output=curl_exec($ch);
        curl_close($ch);
        
        return $output;
    }
}