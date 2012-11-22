<?php

namespace Samson\Bundle\ShowCaseBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonSelectorType extends AbstractType
{

    public function getName()
    {
        return 'person_selector';
    }

    public function getParent()
    {
        return 'autocomplete';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'class' => 'SamsonShowCaseBundle:Person',
            'search_fields' => array('p.firstName', 'p.lastName', 'c.name'),
            'template' => 'SamsonShowCaseBundle:Autocomplete:person_autocomplete.html.twig',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('p')
                    ->leftJoin('p.company', 'c')
                    ->addSelect('c')
                ;
            }
        ));
    }
}
