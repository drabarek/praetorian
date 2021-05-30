<?php

namespace App\Controller;

use App\Exception\AccessDeniedException;
use App\Message\CityAddMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class CityController extends AbstractController
{
    /**
     * @Route("/city", name="city_add", methods={"PUT"})
     */
    public function add(Request $request, MessageBusInterface $bus): JsonResponse
    {
        if (null === $this->getUser()) {
            throw new AccessDeniedException('Access Denied.');
        }

        $bus->dispatch(new CityAddMessage($request->toArray()));

        return $this->json(['success' => true]);
    }
}
