<?php

namespace App\Form\Type;

use App\Service\DeliveryProvider\NovaPoshta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class DeliveryInfoPriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from', ChoiceType::class, ['choices'  => array_flip(NovaPoshta::SETTLEMENTS)])
            ->add('to', ChoiceType::class, ['choices'  => array_flip(NovaPoshta::SETTLEMENTS)])
            ->add('weight', NumberType::class, ['data' => 1, 'html5' => true, 'attr' => ['min' => 0, 'step' => 0.1]])
            ->add('get', SubmitType::class, ['label' => 'form.delivery.info.price.submit'])
        ;
    }
}
