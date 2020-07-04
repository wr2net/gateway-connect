<?php

declare(strict_types=1);

namespace Gateway\Integrations\Models\CARE;

class Associate {

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

    public function __construct(int $id, string $name,string $cpf) {
        $this->id = $id;
        $this->name = $name;
        $this->cpf = $cpf;
        $this->products =  new \ArrayObject();
    }

    public function getId() : int 
    {
        return $this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getCPF() : string
    {
        return $this->cpf;
    }
    
    public function getProducts() : \ArrayObject 
    {
        return $this->products;
    }

    public function addProduct(Product $product)
    {
        $this->products->append($product);
    }
}
