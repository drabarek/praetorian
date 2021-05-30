<?php

declare(strict_types=1);

namespace App\Handler;

use App\Message\CountryAddMessage;
use App\Service\CountryService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CountryAddMessageHandler implements MessageHandlerInterface
{
    private CountryService $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function __invoke(CountryAddMessage $message)
    {
        $this->countryService->add($message->getContent());
    }
}
