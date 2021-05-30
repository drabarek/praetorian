<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Country;
use App\Exception\InvalidArgumentException;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CountryService
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

    public function add(string $name): void
    {
        $country = new Country();
        $country->setName($name);
        $country->setCanonicalName(CanonicalService::filter($name));

        $this->validate($country);
        $this->em->persist($country);
        $this->em->flush();
    }

    public function get(string $canonicalName): array
    {
        $result = [];
        $country = $this->countryRepository->findOneByCanonicalName(CanonicalService::filter($canonicalName));
        $cities = $country->getCities();
        foreach ($cities as $city) {
            $result[$country->getName()][] = $city->getName();
        }

        return $result;
    }

    private function validate(Country $country): void
    {
        $errors = $this->validator->validate($country);

        if (0 !== count($errors)) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[] = sprintf($error->getMessage() . ': `%s`', $country->getName());
            }
            throw new InvalidArgumentException(implode("; ", $messages));
        }
    }
}
