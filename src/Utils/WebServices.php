<?php

namespace Gateway\Utils;

/**
 * Class WebServices
 * @package Gateway\Utils
 */
class WebServices
{
    /**
     * @param $uri
     * @param null $ctx
     * @return false|string
     */
    public static function webServicesToJson($uri, $ctx = null)
    {
        $content = \file_get_contents($uri,false, $ctx);
        if ($content === FALSE) {
            return null;
        }
        return WebServices::xmlToJson($content);
    }

    /**
     * @param $xml
     * @return false|string     */
    public static function xmlToJson($xml)
    {
        return json_encode(simplexml_load_string($xml));
    }
    
}