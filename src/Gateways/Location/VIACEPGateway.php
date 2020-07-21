<?php
declare(strict_types=1);

namespace Gateway\Gateways\Location;

/**
 * Interface VIACEPGateway
 * @package Gateway\Gateways\Location
 */
interface VIACEPGateway
{
    public function fetchLocation(string $cep) : string;
}