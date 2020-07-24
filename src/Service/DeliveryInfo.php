<?php

namespace App\Service;

use App\Service\DeliveryProvider\DeliveryProviderInterface;
use GuzzleHttp\Exception\GuzzleException;

class DeliveryInfo
{
    protected Sender $sender;

    protected DeliveryProviderInterface $deliveryProvider;

    /**
     * @param Sender                    $sender
     * @param DeliveryProviderInterface $deliveryProvider
     */
    public function __construct(Sender $sender, DeliveryProviderInterface $deliveryProvider)
    {
        $this->sender = $sender;
        $this->deliveryProvider = $deliveryProvider;
    }

    /**
     * @param array $data
     *
     * @return int|null
     *
     * @throws GuzzleException
     */
    public function getDeliveryPrice(array $data): ?int
    {
        return $this->deliveryProvider->handleResponse(
            $this->sender->send($this->deliveryProvider->getDeliveryPriceRequestParameters($data)),
            DeliveryProviderInterface::DELIVERY_PRICE_TYPE
        );
    }

    /**
     * @param array $data
     *
     * @return int|null
     *
     * @throws GuzzleException
     */
    public function getDeliveryTrackingStatus(array $data)
    {
        return $this->deliveryProvider->handleResponse(
            $this->sender->send($this->deliveryProvider->getDeliveryTrackingRequestParameters($data)),
            DeliveryProviderInterface::DELIVERY_TRACKING_TYPE
        );
    }

    /**
     * @param string $name
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function getSettlementsByName(string $name): array
    {
        return $this->deliveryProvider->handleResponse(
            $this->sender->send($this->deliveryProvider->getSettlementsByName($name))
        );
    }
}
