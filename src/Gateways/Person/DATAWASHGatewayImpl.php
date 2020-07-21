<?php
declare(strict_types=1);

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
        define('AUTH_PARAM', "&Cliente={$this->client}&Usuario={$this->user}&Senha={$this->passwd}");
    }

    /**
     * @param string $cpf
     * @return string
     */
    public function fetchPersonInformation(string $cpf): string
    {   
        $datawashInfo = $this->cacheService->hasKey($cpf."-datawash") ? $this->cacheService->get($cpf."-datawash") : $this->getInfoFromDATAWASHWebService($cpf);
        return $datawashInfo;
    }

    /**
     * @param string $cpf
     * @return string
     */
    private function getInfoFromDATAWASHWebService(string $cpf)
    {
        $uri = sprintf(self::DATAWASH_ENDPOINT.AUTH_PARAM,$cpf);
        $data = WebServicesUtils::webServicesToJson($uri);
        $this->cacheService->putInKey($cpf."-datawash",$data);
        return $data;
    }
}