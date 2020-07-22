<?php
declare(strict_types=1);

namespace Gateway\Integrations\CARE;

use Gateway\Utils\WebServices as WebServicesUtils;
use Gateway\Integrations\Models\CARE;

/**
 * Class CAREClientImpl
 * @package Gateway\Integrations\CARE
 */
class CAREClientImpl implements CAREClient
{
    /**
    * @var SOAPClient
    */
    private $client;

    /**
    *  @var string
    */
    private $user;

    /**
    *  @var string
    */
    private $pass;

    /**
     * CAREClientImpl constructor.
     * @param string $wsURL
     * @param string $user
     * @param string $password
     * @throws \SoapFault
     */
    public function __construct(string $wsURL, string $user, string $password)
    {
        $this->client = new \SoapClient($wsURL);
        $this->user = $user;
        $this->pass = $password;
    }

    /**
     * @param CARE\Associate $associate
     * @return string
     */
    public function createAssociate(CARE\Associate $associate): string
    {
        $root = new \SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-1"?><xml></xml>');
        $dadosAssociado = $root->addChild("item")->addChild("dadosAssociado");
        $dadosAssociado->telefone->telefoneItem->tipoTelefone = 1;
        $dadosAssociado->idExternoAssociado = $associate->getId();
        $dadosAssociado->nomeAssociado = $associate->getName();
        $dadosAssociado->cpf = $associate->getCPF();
        $associateProducts = $dadosAssociado->addChild("produtos_associado");

        foreach ($associate->getProducts() as $product) {
            $associateProducts->addChild("productoItem")->codigoProduto = $product->getCode();
        }

        $params = [
          "intervenienteCnpj" => $this->user,
          "idInterveniente" => $this->pass,
          "xmlOriginal" => $root->asXML(),
        ];
        $response = $this->client->__soapCall("fCadastrarAssociado", $params);

        return WebServicesUtils::webServicesToJson($response);
    }

    /**
     * @param string $cpf
     * @param int $productCode
     * @return string
     */
    public function removeAssociateProducts(string $cpf, int $productCode): string
    {
        $root = new \SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-1"?><xml></xml>');
        $dadosAssociado = $root->addChild("item")->addChild("dadosAssociado");
        $dadosAssociado->cpf = $cpf;
        $dadosAssociado->produtos_associado->produtoItem->codigoProduto = $productCode;
        $params = array(
          "intervenienteCnpj" => $this->user,
          "idInterveniente" => $this->pass,
          "xmlOriginal" => $root->asXML()
        );
        $response = $this->client->__soapCall("fRemoverProdutosAssociado", $params);

        return WebServicesUtils::webServicesToJson($response);
    }

    /**
     * @return string
     */
    public function getAssociates(): string
    {
        $params = array(
          "intervenienteCnpj" => $this->user,
          "idInterveniente" => $this->pass,
          "formato" => "xml"
        );
        $response = $this->client->__soapCall("fObtemAssociados", $params);
        $associates = \json_decode(WebServicesUtils::webServicesToJson($response))->associados->associado;
        return \json_encode($associates);
    }

    /**
     * @return string
     */
    public function getProducts(): string
    {
        $params = array(
          "intervenienteCnpj" => $this->user,
          "formato" => "xml"
        );
        $response = $this->client->__soapCall("fObtemNegociacoes", $params);
        $products = \json_decode(WebServicesUtils::webServicesToJson($response))->negociacoes->negociacao;
        return \json_encode($products);
    }

    /**
     * @param string $cpf
     * @param int $productCode
     * @return string
     */
    public function getAssociateSituation(string $cpf, int $productCode): string
    {
        $params = array(
          "intervenienteCnpj" => $this->user,
          "idInterveniente" => $this->pass,
          "cpf" => $cpf,
          "producto" => $productCode
        );
        $response = $this->client->__soapCall("fConsultaSituacaoAssociado", $params);
        return \json_encode(["status" => $response]);
    }

    /**
     * @param $cpf
     * @return string
     */
    public function getAssociateProducts($cpf): string
    {
        $params = array(
          "intervenienteCnpj" => "ambiente_testes",
          "idInterveniente" => "ambiente_testes",
          "cpf" => $cpf
        );
        $response = $this->client->__soapCall("fConsultaProdutosAssociado", $params);

        return WebServicesUtils::xmlToJson($response);
    }
}
