<?php

namespace App\Controller;

use App\Form\Type\DeliveryInfoPriceType;
use App\Form\Type\DeliveryInfoTrackingType;
use App\Service\DeliveryInfo;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeliveryInfoController extends AbstractController
{
    protected DeliveryInfo $deliveryInfo;

    public function __construct(DeliveryInfo $deliveryInfo)
    {
        $this->deliveryInfo = $deliveryInfo;
    }

    /**
     * @Route("/delivery/info/price", name="delivery_info_price")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws GuzzleException
     */
    public function price(Request $request)
    {
        $price = null;

        $form = $this->createForm(DeliveryInfoPriceType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $data['cargo_type'] = 'Cargo';
            $data['service_type'] = 'DoorsDoors';
            $price = $this->deliveryInfo->getDeliveryPrice($data);
        }

        return $this->render('delivery/info/price.html.twig', [
            'form' => $form->createView(),
            'price' => $price
        ]);
    }

    /**
     * @Route("/delivery/info/tracking", name="delivery_info_tracking")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws GuzzleException
     */
    public function tracking(Request $request)
    {
        $trackingStatus = null;

        $form = $this->createForm(DeliveryInfoTrackingType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trackingStatus = $this->deliveryInfo->getDeliveryTrackingStatus($form->getData());
        }

        return $this->render('delivery/info/tracking.html.twig', [
            'form' => $form->createView(),
            'trackingStatus' => $trackingStatus
        ]);
    }
}
