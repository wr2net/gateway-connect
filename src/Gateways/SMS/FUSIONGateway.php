<?php

namespace Gateway\Gateways\SMS;

/**
 * Class FUSIONGateway
 * @package Gateway\Gateways\SMS
 */
interface FUSIONGateway
{
    /**
     * @param string $number
     * @param string $message
     * @param int $type
     * @return string
     */
    public function fetchSmsSend($number, $message, $type);
}