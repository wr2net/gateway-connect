<?php
declare(strict_types=1);

namespace Gateway\Gateways\Vehicle;


/**
 * Interface SEAPEGateway
 * @package Gateway\Gateways\Vehicle
 */
interface SEAPEGateway
{
    public function fetchVehicleRegisterByPlate(string $plate) : string;

    public function fetchVehicleDecoderWithChassis(string $chassis) : string;
}