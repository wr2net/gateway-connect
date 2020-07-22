<?php

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
    public function fetchVehicleRegisterByPlate($plate);

    /**
     * @param string $chassis
     * @return string
     */
    public function fetchVehicleDecoderWithChassis($chassis);
}