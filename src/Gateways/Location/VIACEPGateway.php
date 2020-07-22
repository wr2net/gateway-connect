<?php

namespace Gateway\Gateways\Location;

/**
 * Interface VIACEPGateway
 * @package Gateway\Gateways\Location
 */
interface VIACEPGateway
{
    /**
     * @param string $cep
     * @return string
     */
    public function fetchLocation($cep);
}