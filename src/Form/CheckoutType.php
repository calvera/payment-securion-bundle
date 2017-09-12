<?php

namespace Calvera\Payment\SecurionBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class CheckoutType extends SecurionType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('token', HiddenType::class, array(
            'required' => false
        ));
    }
}
