<?php

namespace App\EventListener;

use App\Dto\ErrorDto;
use App\Exception\AccessDeniedException;
use App\Exception\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionListener implements EventSubscriberInterface
{
    private LoggerInterface $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // the priority must be greater than the Security HTTP
            // ExceptionListener, to make sure it's called before
            // the default exception listener
            KernelEvents::EXCEPTION => ['onKernelException', 2],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = new JsonResponse();
        $response->setStatusCode(500);

        $dto = new ErrorDto();
        $dto->setErrorTraceText($exception->getTraceAsString());
        $dto->setErrorText($exception->getMessage());

        if ($this->getInstance($exception)) {
            $response->setStatusCode(400);
        }

        $dto->setErrorId($response->getStatusCode());

        $this->logger->error("Exception", $this->getResponseErrorLog($exception));
        $event->setResponse($response->setContent($dto));
    }

    private function getInstance($exception): bool
    {
        return ($exception instanceof AccessDeniedException
            || $exception instanceof InvalidArgumentException
            || $exception instanceof \Symfony\Component\Messenger\Exception\HandlerFailedException
        );
    }

    private function getResponseErrorLog($exception): array {
        return [
            'error' => [
                'message' => $exception->getMessage(),
                'messageTrace' => $exception->getTraceAsString()
            ]
        ];
    }
}
