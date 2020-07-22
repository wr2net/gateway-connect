<?php
declare(strict_types=1);

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
     * @return string
     */
    public function createAssociate(CARE\Associate $associate): string;

    /**
     * @param string $cpf
     * @param int $productCode
     * @return string
     */
    public function removeAssociateProducts(string $cpf,int $productCode): string;

    /**
     * @return string
     */
    public function getAssociates(): string;

    /**
     * @return string
     */
    public function getProducts(): string;

    /**
     * @param string $cpf
     * @param int $productCode
     * @return string
     */
    public function getAssociateSituation(string $cpf, int $productCode): string;

    /**
     * @param $cpf
     * @return string
     */
    public function getAssociateProducts($cpf): string;
}
