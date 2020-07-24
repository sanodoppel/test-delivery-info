<?php

namespace App\Service\DeliveryProvider;

use App\DTO\RequestDTO;

interface DeliveryProviderInterface
{
    public const DELIVERY_PRICE_TYPE = 'delivery-price';
    public const DELIVERY_TRACKING_TYPE = 'delivery-tracking';

    /**
     * @param array $data
     *
     * @return RequestDTO
     */
    public function getDeliveryPriceRequestParameters(array $data): RequestDTO;

    /**
     * @param string $name
     *
     * @return RequestDTO
     */
    public function getSettlementsByName(string $name): RequestDTO;

    /**
     * @param array  $response
     * @param string $type
     *
     * @return mixed
     */
    public function handleResponse(array $response, string $type = '');
}
