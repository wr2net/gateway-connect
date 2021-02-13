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
        $uri = sprintf(self::VIACEP_ENDPOINT,$cep);
        
        $ch = curl_init();  
        curl_setopt($ch,CURLOPT_URL,$uri);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_TIMEOUT, 30); 
 
        $output = curl_exec($ch);
        $toError = json_decode(curl_exec($ch));
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($info['http_code'] != 200 || $toError->erro) {
            $error =  [
                "code" => $info['http_code'],
                "message" => "Zip code reported nonstandard or incorrect.",
                "cep" => $cep
            ];
            return json_encode($error);
        }
        return $output;
    }
}