<?php

namespace Gateway\Integrations\Models\CARE;

/**
 * Class Associate
 * @package Gateway\Integrations\Models\CARE
 */
class Associate
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $cpf;
    
    /**
     * @var \ArrayObject
     */
    private $products;

    /**
     * Associate constructor.
     * @param $id
     * @param $name
     * @param $cpf
     */
    public function __construct($id, $name, $cpf)
    {
        $this->id = $id;
        $this->name = $name;
        $this->cpf = $cpf;
        $this->products =  new \ArrayObject();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCPF()
    {
        return $this->cpf;
    }

    /**
     * @return \ArrayObject
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        $this->products->append($product);
    }
}
