<?php
declare(strict_types=1);

namespace Gateway\Gateways\Vehicle;

/**
 * Interface SEAPEGateway
 * @package Gateway\Gateways\Vehicle
 */
interface SEAPEGateway
{
    /**
     * @param string $plate
     * @return string
     */
    public function fetchVehicleRegisterByPlate(string $plate) : string;

    /**
     * @param string $chassis
     * @return string
     */
    public function fetchVehicleDecoderWithChassis(string $chassis) : string;
}