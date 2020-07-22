<?php
declare(strict_types=1);

namespace Gateway\Utils;

/**
 * Class WebServices
 * @package Gateway\Utils
 */
class WebServices
{
    /**
     * @param string $uri
     * @param null $ctx
     * @return string
     */
    public static function webServicesToJson(string $uri, $ctx=null) : string {
        $content = \file_get_contents($uri,false, $ctx);
        if ($content === FALSE) {
            return \json_encode([]);
        }
        return WebServices::xmlToJson($content);
    }

    /**
     * @param $xml
     * @return string
     */
    public static function xmlToJson($xml) : string {
        return \json_encode(new \SimpleXMLElement($xml));
    }
    
}