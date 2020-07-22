<?php

namespace Gateway\Integrations\Models\CARE;

/**
 * Class Product
 * @package Gateway\Integrations\Models\CARE
 */
class Product {

    /**
     * @var int
     */
    private $productCode;

    /**
     * @var string
     */
    private $name;

    /**
     * Product constructor.
     * @param $productCode
     * @param $name
     */
    public function __construct($productCode, $name) {
        $this->productCode = $productCode;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->productCode;
    }
}
