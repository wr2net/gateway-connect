<?php
declare(strict_types=1);


namespace Gateway\Gateways\SMS;


/**
 * Class FUSIONGateway
 * @package Gateway\Gateways\SMS
 */
interface FUSIONGateway
{
    public function fetchSmsSend(string $number, string $message, int $type) : string;
}