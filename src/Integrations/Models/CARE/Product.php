<?php

declare(strict_types=1);

namespace Gateway\Integrations\Models\CARE;


class Product {

    /**
     * @var int
     */
    private $productCode;

    /**
     * @var string
     */
    private $name;

    public function __construct(int $productCode,string $name) {
        $this->productCode = $productCode;
        $this->name = $name;
    }

    public function getCode() : int 
    {
        return $this->productCode;
    }

}
