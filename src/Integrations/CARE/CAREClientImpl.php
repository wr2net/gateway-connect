<?php

declare(strict_types=1);


namespace Gateway\Integrations\CARE;

use Gateway\Utils\WebServices as WebServicesUtils;
use Gateway\Integrations\Models\CARE;

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


  public function __construct(
    string $wsURL = "https://aid.hinova.com.br/aid/ambiente_testes/ws/webservice.php?wsdl",
    string $user = "10816486786",
    string $password = "1"
  ) {
    $this->client = new \SoapClient($wsURL);
    $this->user = $user;
    $this->pass = $password;
  }


  //fCadastrarAssociado
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

  //fRemoverProdutosAssociado
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

  //fObtemAssociados
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

  //fObtemNegociacoes
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


  //fConsultaSituacaoAssociado
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

  //fConsultaProdutosAssociado
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
