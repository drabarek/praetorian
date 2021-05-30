<?php

namespace App\Controller;

use App\Service\CountryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends AbstractController
{
    /**
     * @Route("/country/{name}", name="country_get", methods={"GET"}, requirements={"name"=".+"})
     */
    public function index(Request $request, CountryService $countryService, string $name): JsonResponse
    {
        return $this->json([
            'country' => $countryService->get($name)
        ]);
    }
}
