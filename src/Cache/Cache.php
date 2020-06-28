<?php
declare(strict_types=1);

namespace Gateway\Cache;


interface Cache
{

    public function get(string $key);

    public function put($data) : string;

    public function putInKey(string $key, $data) : string;

    public function hasKey(string $key) : bool;
}