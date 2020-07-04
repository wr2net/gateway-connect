<?php

declare(strict_types=1);

namespace Gateway\Integrations\CARE;

use Gateway\Integrations\Models\CARE;
use SimpleXMLElement;

interface CAREClient
{

    //fCadastrarAssociado
    public function createAssociate(CARE\Associate $associate): string;
    
    //fRemoverProdutosAssociado
    public function removeAssociateProducts(string $cpf,int $productCode): string;

    //fObtemAssociados
    public function getAssociates(): string;

    //fObtemNegociacoes
    public function getProducts(): string;

    //fConsultaSituacaoAssociado
    public function getAssociateSituation(string $cpf, int $productCode): string;

    //fConsultaProdutosAssociado
    public function getAssociateProducts($cpf): string;
}
