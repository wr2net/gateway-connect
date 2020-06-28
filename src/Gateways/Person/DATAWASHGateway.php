<?php
declare(strict_types=1);

namespace Gateway\Gateways\Person;


/**
 * Interface DATAWASHGateway
 * @package Gateway\Gateways\Person
 */
interface DATAWASHGateway
{
    public function fetchPersonInformation(string $cpf) : string;
}