<?php

namespace Samson\Bundle\ShowCaseBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Samson\Bundle\ShowCaseBundle\Entity\Company;
use Samson\Bundle\ShowCaseBundle\Entity\Person;

/**
 * @author Bart van den Burg <bart@samson-it.nl>
 */
class AddressBookData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $person1 = new Person();
        $person1->setId(1);
        $person1->setFirstName('test');
        $person1->setLastName('person');
        $manager->persist($person1);

        $person2 = new Person();
        $person2->setId(2);
        $person2->setFirstName('other');
        $person2->setLastName('someone');
        $manager->persist($person2);

        $person3 = new Person();
        $person3->setId(3);
        $person3->setFirstName('third');
        $person3->setLastName('person');
        $manager->persist($person3);

        $company1 = new Company();
        $company1->setId(1);
        $company1->setName('Samson IT');
        $company1->setEmployees(new ArrayCollection(array($person1, $person2)));
        $manager->persist($company1);

        $company2 = new Company();
        $company2->setId(2);
        $company2->setName('Burgov');
        $company2->setEmployees(new ArrayCollection(array($person3)));
        $manager->persist($company2);

        $manager->flush();
    }

}
