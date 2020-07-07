# Gateways

This repository contains a Gateway pattern implemented as a library to be used in the MutualSoft projects.

Current available Gateways:
 - Vehicle
 - Person
 - Location

## Requirements
- PHP 7.3
- Composer

Otherwise, you can use the Docker Compose file to develop:
```bash
docker-compose up --build
```
This will require `docker` and `docker-compose` only.

## Usage

### SEAPE Gateway

Constructor Requirements:
- A Cache Implementation

Methods:

- **fetchVehicleRegisterByPlate(string $plate) :string**

    Takes a vehicle plate and fetches on SEAPE for vehicle register information, returns a JSON.

- **fetchVehicleDecoderWithChassis(string $chassis) : string**
    
    Takes a vehicle chassis number and fetches on SEAPE for vehicle precifier and decoder information, returns a JSON.

### UNICHECK Gateway

Constructor Requirements:
- A Cache Implementation

Methods:

- **fetchVehicleInformation(string $plate) :string**

    Takes a vehicle plate and fetches on UNICHECK for vehicle information, returns a JSON.

### DATAWASH Gateway

Constructor Requirements:
- A Cache Implementation

Methods:
- **fetchPersonInformation(string $cpf) : string**

    Gets the person information on UNICHECK with the provided CPF, returns a JSON.


### VIACEP Gateway

Methods:
- **fetchLocation(string $cep) : string**

    Gets public Location information on VIACEP with the provided CEP, returns a JSON.


### FUSION Gateway

Methods:
- **fetchSmsSend(string $number, string $message, int $type) : string**

    Sends Long (0) and Short (2) SMSs and returns a JSON.


### Cache (DiskCache Implementation)
Constructor Requirements:
- Identifier prefix
- Filesystem path for storage


## How to import in projects:

1. Add this repository to Composer
```bash
    php composer config repositories.gateway-connect vcs https://github.com/wr2net/gateway-connect.git
```

1. Require the desired versions:
```bash
    php composer require  wr2net/gateway-connect  master@dev
```

1. Use it in your code:
```php
    <?php
        declare(strict_types=1);

        require __DIR__ . '/../vendor/autoload.php';

        use Gateway\Gateways\Vehicle\SEAPEGatewayImpl as SEAPE;
        use Gateway\Gateways\Vehicle\UNICHECKGatewayImpl as UNICHECK;
        use Gateway\Gateways\Person\DATAWASHGatewayImpl as DATAWASH;
        use Gateway\Gateways\Location\VIACEPGatewayImpl as VIACEP;
        use Gateway\Gateways\SMS\FUSIONGatewayImpl as FUSION;
        use Gateway\Cache\DiskCacheImpl as Cache;
        use Gateway\Integrations\CARE\CAREClientImpl as CAREClient;
        use Gateway\Integrations\Models\CARE;


        $cache = new Cache("vehicles","/tmp/");

        $seape = new SEAPE($cache, $key, $user, $auth);

        $unicheck = new UNICHECK($cache, $user, $auth);

        $datawash = new DATAWASH($cache, $client, $user, $auth);

        $viacep = new VIACEP();

        $fusion = new FUSION($cache, $user, $token);

        $care = new CAREClient();


        // VEHICLE
        print_r($unicheck->fetchVehicleInformation("PLATE"));
        print_r($seape->fetchVehicleRegisterByPlate("PLATE"));
        print_r($seape->fetchVehicleDecoderWithChassis("CHASSIS"));

        // PERSON
        print_r($datawash->fetchPersonInformation("CPF"));

        // LOCATION
        print_r($viacep->fetchLocation("CEP"));

        // SEND SMS
        print_r($fusion->fetchSmsSend("NUMBER_PHONE", "MESSAGE", "TYPE"));

        //CARE
        $associate = new CARE\Associate(1,"TESTE USER","098766543210");
        $associate->addProduct(new CARE\Product(10, ""));
        print_r($care->createAssociate($associate));
        print_r($care->removeAssociateProducts("098766543210",10));
        print_r($care->getAssociates());
        print_r($care->getProducts());
        print_r($care->getAssociateSituation("098766543210", 10));
        print_r($care->getAssociateProducts("098766543210"));

```