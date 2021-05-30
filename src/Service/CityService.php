<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\City;
use App\Exception\InvalidArgumentException;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CityService
{
    protected ValidatorInterface $validator;
    private EntityManagerInterface $em;
    private CountryRepository $countryRepository;

    public function __construct(
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        CountryRepository $countryRepository
    ) {
        $this->em = $em;
        $this->validator = $validator;
        $this->countryRepository = $countryRepository;
    }

    public function add(array $content): void
    {
        $city = new City();
        $city->setName($content['name']);

        $country = $this->countryRepository->findOneByCanonicalName($content['country']);
        if (null === $country) {
            throw new InvalidArgumentException('Country not found');
        }

        $city->setCountry($country);

        $this->validate($city);
        $this->em->persist($city);
        $this->em->flush();
    }

    private function validate(City $city): void
    {
        $errors = $this->validator->validate($city);

        if (0 !== count($errors)) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[] = sprintf($error->getMessage() . ': `%s`', $city->getName());
            }
            throw new InvalidArgumentException(implode("; ", $messages));
        }
    }
}
