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
}
