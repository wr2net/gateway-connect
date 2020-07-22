<?php

namespace Gateway\Gateways\Person;

/**
 * Interface DATAWASHGateway
 * @package Gateway\Gateways\Person
 */
interface DATAWASHGateway
{
    /**
     * @param string $cpf
     * @return string
     */
    public function fetchPersonInformation($cpf);
}