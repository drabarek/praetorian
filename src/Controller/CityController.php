<?php

namespace App\Controller;

use App\Entity\City;
use App\Exception\AccessDeniedException;
use App\Form\CityType;
use App\Service\CityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CityController extends AbstractController
{
    /**
     * @Route("/city", name="city_add", methods={"PUT"})
     */
    public function add(Request $request, CityService $cityService): JsonResponse
    {
        if (null === $this->getUser()) {
            throw new AccessDeniedException('Access Denied.');
        }

        $city = new City();
        $form = $this->createForm(CityType::class, $city, ['csrf_protection' => false]);

        $form->submit(json_decode($request->getContent(), true));
        if ($form->isSubmitted() && $form->isValid()) {
            $cityService->add($city);
        }
        $cityService->validate($city);

        return $this->json(['success' => true]);
    }
}
