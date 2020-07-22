<?php

namespace Gateway\Gateways\Vehicle;

/**
 * Interface UNICHECKGateway
 * @package Gateway\Gateways\Vehicle
 */
interface UNICHECKGateway
{
    /**
     * @param string $plate
     * @return string
     */
    public function fetchVehicleInformation($plate);
}
  