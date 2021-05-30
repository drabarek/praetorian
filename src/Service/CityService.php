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

    public function add(City $city): void
    {
        $this->em->persist($city);
        $this->em->flush();
    }

    public function validate(City $city): void
    {
        $errors = $this->validator->validate($city);

        if (0 !== count($errors)) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[] = $error->getMessage();
            }
            throw new InvalidArgumentException(implode("; ", $messages));
        }
    }
}
