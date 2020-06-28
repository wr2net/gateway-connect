<?php
declare(strict_types=1);

namespace Gateway\Gateways\Vehicle;


/**
 * Interface UNICHECKGateway
 * @package Gateway\Gateways\Vehicle
 */
interface UNICHECKGateway
{
    public function fetchVehicleInformation(string $plate) : string;
}
  