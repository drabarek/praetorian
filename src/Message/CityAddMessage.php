<?php

declare(strict_types=1);

namespace App\Message;

class CityAddMessage
{
    private array $content;

    public function __construct(array $content)
    {
        $this->content = $content;
    }

    public function getContent(): array
    {
        return $this->content;
    }
}
