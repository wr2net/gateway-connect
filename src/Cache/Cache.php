<?php
declare(strict_types=1);

namespace Gateway\Cache;

/**
 * Interface Cache
 * @package Gateway\Cache
 */
interface Cache
{
    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key);

    /**
     * @param $data
     * @return string
     */
    public function put($data) : string;

    /**
     * @param string $key
     * @param $data
     * @return string
     */
    public function putInKey(string $key, $data) : string;

    /**
     * @param string $key
     * @return bool
     */
    public function hasKey(string $key) : bool;
}