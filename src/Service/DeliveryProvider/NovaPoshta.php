<?php

namespace App\Service\DeliveryProvider;

use App\DTO\RequestDTO;
use Psr\Log\LoggerInterface;

class NovaPoshta implements DeliveryProviderInterface
{
    public const SETTLEMENTS = [
        'e718a680-4b33-11e4-ab6d-005056801329' => 'Киев',
        'e71f8842-4b33-11e4-ab6d-005056801329' => 'Харьков',
        'e71abb60-4b33-11e4-ab6d-005056801329' => 'Львов',
        'e71c2a15-4b33-11e4-ab6d-005056801329' => 'Одесса',
        'e717110a-4b33-11e4-ab6d-005056801329' => 'Днепр',
    ];

    private const URL = 'https://api.novaposhta.ua/v2.0/json/';

    private RequestDTO $requestParameters;

    private LoggerInterface $logger;


    /**
     * @param string $apiKey
     */
    public function __construct(string $apiKey, LoggerInterface $logger)
    {
        $this->logger = $logger;

        $this->requestParameters = new RequestDTO();
        $this->requestParameters->setBaseUrl(self::URL);
        $this->requestParameters->setUrl(self::URL);
        $this->requestParameters->setFields([
            'apiKey' => $apiKey
        ]);
    }

    /**
     * @param string $name
     *
     * @return RequestDTO
     */
    public function getSettlementsByName(string $name): RequestDTO
    {
        $this->requestParameters->setMethod('post');
        $fields = $this->requestParameters->getFields();
        $fields['modelName'] = 'AddressGeneral';
        $fields['calledMethod'] = 'getSettlements';
        $fields['methodProperties'] = [
            'FindByString' => $name,
        ];

        $this->requestParameters->setFields($fields);

        return $this->requestParameters;
    }

    /**
     * @param array $data
     *
     * @return RequestDTO
     */
    public function getDeliveryTrackingRequestParameters(array $data): RequestDTO
    {
        $this->requestParameters->setMethod('post');
        $fields = $this->requestParameters->getFields();
        $fields['modelName'] = 'TrackingDocument';
        $fields['calledMethod'] = 'getStatusDocuments';
        $fields['methodProperties'] = [
            'Documents' => [
                [
                    'DocumentNumber' => $data['document_number']
                ]
            ]
        ];

        $this->requestParameters->setFields($fields);

        return $this->requestParameters;
    }

    /**
     * @param array $data
     *
     * @return RequestDTO
     */
    public function getDeliveryPriceRequestParameters(array $data): RequestDTO
    {
        $this->requestParameters->setMethod('post');
        $fields = $this->requestParameters->getFields();
        $fields['modelName'] = 'InternetDocument';
        $fields['calledMethod'] = 'getDocumentPrice';
        $fields['methodProperties'] = [
            'Weight' => $data['weight'],
            'ServiceType' => $data['service_type'],
            'CargoType' => $data['cargo_type'],
            'CitySender' => $data['from'],
            'CityRecipient' => $data['to'],
        ];

        $this->requestParameters->setFields($fields);

        return $this->requestParameters;
    }

    /**
     * @param array  $response
     * @param string $type
     *
     * @return mixed
     */
    public function handleResponse(array $response, string $type = '')
    {
        if (!$response['success']) {
            $this->logger->error(sprintf('Nova Poshta Api Error: %s', json_encode($response['errors'])));
            return null;
        }

        switch ($type) {
            case DeliveryProviderInterface::DELIVERY_PRICE_TYPE:
                return $response['data'][0]['Cost'];
            case DeliveryProviderInterface::DELIVERY_TRACKING_TYPE:
                return $response['data'][0]['Status'];
            default:
                return $response['data'];
        }
    }
}
