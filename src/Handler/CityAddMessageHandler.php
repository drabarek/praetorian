<?php

declare(strict_types=1);

namespace App\Handler;

use App\Message\CityAddMessage;
use App\Service\CityService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CityAddMessageHandler implements MessageHandlerInterface
{
    private CityService $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    public function __invoke(CityAddMessage $message)
    {
        $this->cityService->add($message->getContent());
    }
}
