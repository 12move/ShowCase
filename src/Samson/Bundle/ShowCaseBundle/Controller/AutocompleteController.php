<?php

namespace Samson\Bundle\ShowCaseBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Tools\SchemaTool;
use Samson\Bundle\ShowCaseBundle\Entity\Company;
use Samson\Bundle\ShowCaseBundle\Entity\Person;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/autocomplete")
 */
class AutocompleteController extends Controller
{
    /**
     * @Route("", name="autocomplete")
     * @Template()
     */
    public function indexAction()
    {
        $this->initializeEntityManager();

        $companyForm = $this->createForm(
            'company_selector',
            $this->getDoctrine()->getEntityManager()->find('SamsonShowCaseBundle:Company', 1),
            array(
                'validation_constraint' => new \Symfony\Component\Validator\Constraints\NotNull()
            )
        );
        $personForm = $this->createForm(
            'person_selector',
            null,
            array(
                'validation_constraint' => new \Symfony\Component\Validator\Constraints\NotNull()
            )
        );

        if ($this->getRequest()->isMethod('POST')) {
            foreach(array($companyForm, $personForm) as $form) {
                if ($this->getRequest()->request->has($form->getName())) {
                    $form->bind($this->getRequest());
                    if ($form->isValid()) {
                        $this->getRequest()->getSession()->getFlashBag()->add('notice', sprintf('You selected %s(%s): %s', get_class($form->getData()), $form->getData()->getId(), $form->getData()));
                        return $this->redirect($this->generateUrl('autocomplete'));
                    }
                }
            }
        }

        return array('company_form' => $companyForm->createView(), 'person_form' => $personForm->createView());
    }

    private function initializeEntityManager()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $tool = new SchemaTool($em);
        $tool->createSchema($em->getMetadataFactory()->getAllMetadata());

        $person1 = new Person();
        $person1->setId(1);
        $person1->setFirstName('test');
        $person1->setLastName('person');
        $em->persist($person1);

        $person2 = new Person();
        $person2->setId(2);
        $person2->setFirstName('other');
        $person2->setLastName('someone');
        $em->persist($person2);

        $person3 = new Person();
        $person3->setId(3);
        $person3->setFirstName('third');
        $person3->setLastName('person');
        $em->persist($person3);

        $company1 = new Company();
        $company1->setId(1);
        $company1->setName('Samson IT');
        $company1->setEmployees(new ArrayCollection(array($person1, $person2)));
        $em->persist($company1);

        $company2 = new Company();
        $company2->setId(2);
        $company2->setName('Burgov');
        $company2->setEmployees(new ArrayCollection(array($person3)));
        $em->persist($company2);

        $em->flush();
    }
}
