<?php
declare(strict_types=1);


namespace Gateway\Utils;


class WebServices
{
    public static function webServicesToJson(string $uri,$ctx=null) : string {
        $content = \file_get_contents($uri,false,$ctx);
        if($content === FALSE){
            return \json_encode([]);
        }
        return \json_encode(new \SimpleXMLElement($content));
    }
    
}