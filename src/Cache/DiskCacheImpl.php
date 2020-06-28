<?php
declare(strict_types=1);

namespace Gateway\Cache;

class DiskCacheImpl implements Cache
{

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $path;

    public function __construct(string $identifier,string $path)
    {
        $this->identifier = $identifier;
        $this->path = $path;
    }

    public function get(string $key)
    {
        return $this->hasKey($key) ? \file_get_contents($this->path.$key): null;
    }

    public function hasKey(string $key) : bool
    {
        return \file_exists($this->path.$key);
    }

    public function put($data) : string
    {
        do {
            $key = \uniqid($this->identifier,TRUE);
        } while ($this->hasKey($key));

        \file_put_contents($this->path.$key,$data);
        return $key;
    }

    public function putInKey(string $key, $data) : string
    {
        \file_put_contents($this->path.$key,$data);
        return $key;
    }
}