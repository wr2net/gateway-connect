<?php

namespace Gateway\Gateways\Person;

use Gateway\Cache\Cache;
use Gateway\Utils\WebServices as WebServicesUtils;

/**
 * Class DATAWASHGatewayImpl
 * @package Gateway\Gateways\Person
 */
class DATAWASHGatewayImpl implements DATAWASHGateway
{
    /**
     * @var string
     */
    private $client;

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
    CONST DATAWASH_ENDPOINT = "http://webservice.datawash.com.br/localizacao.asmx/ConsultaCPFCompleta?CPF=%s";

    /**
     * @var Cache
     */
    private $cacheService;

    /**
     * @var string
     */
    private $auth_param;

    /**
     * DATAWASHGatewayImpl constructor.
     * @param Cache $cache
     * @param $client
     * @param $user
     * @param $auth
     */
    public function __construct(Cache $cache, $client, $user, $auth )
    {
        $this->cacheService = $cache;
        $this->client = $client;
        $this->user = $user;
        $this->passwd = $auth;
        $this->auth_param = "&Cliente={$this->client}&Usuario={$this->user}&Senha={$this->passwd}";
    }

    /**
     * @param string $cpf
     * @return mixed|string
     */
    public function fetchPersonInformation($cpf)
    {   
        $datawashInfo = $this->cacheService->hasKey($cpf . "-datawash") ? $this->cacheService->get($cpf . "-datawash") : $this->getInfoFromDATAWASHWebService($cpf);
        return $datawashInfo;
    }

    /**
     * @param $cpf
     * @return mixed
     */
    private function getInfoFromDATAWASHWebService($cpf)
    {
        $uri = sprintf(self::DATAWASH_ENDPOINT . $this->auth_param,$cpf);
        $data = WebServicesUtils::webServicesToJson($uri);
        $this->cacheService->putInKey($cpf . "-datawash", $data);
        return $data;
    }
}