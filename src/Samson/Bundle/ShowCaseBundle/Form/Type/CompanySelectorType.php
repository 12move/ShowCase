<?php

namespace Samson\Bundle\ShowCaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompanySelectorType extends AbstractType
{

    public function getName()
    {
        return 'company_selector';
    }

    public function getParent()
    {
        return 'autocomplete';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'class' => 'SamsonShowCaseBundle:Company',
            'search_fields' => array('autocomplete.name'),
            'template' => 'SamsonShowCaseBundle:Autocomplete:company_autocomplete.html.twig',
        ));
    }
}
