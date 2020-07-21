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
    //fCadastrarAssociado
    public function createAssociate(CARE\Associate $associate): string;

    /**
     * @param string $cpf
     * @param int $productCode
     * @return string
     */
    //fRemoverProdutosAssociado
    public function removeAssociateProducts(string $cpf,int $productCode): string;

    /**
     * @return string
     */
    //fObtemAssociados
    public function getAssociates(): string;

    /**
     * @return string
     */
    //fObtemNegociacoes
    public function getProducts(): string;

    /**
     * @param string $cpf
     * @param int $productCode
     * @return string
     */
    //fConsultaSituacaoAssociado
    public function getAssociateSituation(string $cpf, int $productCode): string;

    /**
     * @param $cpf
     * @return string
     */
    //fConsultaProdutosAssociado
    public function getAssociateProducts($cpf): string;
}
