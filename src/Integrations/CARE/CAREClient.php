<?php

namespace Gateway\Integrations\CARE;

use Gateway\Integrations\Models\CARE;

/**
 * Interface CAREClient
 * @package Gateway\Integrations\CARE
 */
interface CAREClient
{
    /**
     * @param CARE\Associate $associate
     * @return mixed
     */
    public function createAssociate(CARE\Associate $associate);

    /**
     * @param string $cpf
     * @param int $productCode
     * @return string
     */
    public function removeAssociateProducts($cpf, $productCode);

    /**
     * @return string
     */
    public function getAssociates();

    /**
     * @return string
     */
    public function getProducts();

    /**
     * @param string $cpf
     * @param int $productCode
     * @return string
     */
    public function getAssociateSituation($cpf, $productCode);

    /**
     * @param $cpf
     * @return string
     */
    public function getAssociateProducts($cpf);
}
