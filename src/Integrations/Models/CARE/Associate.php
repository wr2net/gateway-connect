<?php
declare(strict_types=1);

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
     * @param int $id
     * @param string $name
     * @param string $cpf
     */
    public function __construct(int $id, string $name,string $cpf) {
        $this->id = $id;
        $this->name = $name;
        $this->cpf = $cpf;
        $this->products =  new \ArrayObject();
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCPF() : string
    {
        return $this->cpf;
    }

    /**
     * @return \ArrayObject
     */
    public function getProducts() : \ArrayObject 
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
