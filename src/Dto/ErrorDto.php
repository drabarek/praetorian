<?php

declare(strict_types=1);

namespace App\Dto;

class ErrorDto {

    protected int $errorId;

    protected string $errorText;

    protected string $errorTraceText;

    public function __toString(): string {
        $result = [];
        foreach (\get_object_vars($this) as $property => $value) {
            $result[$property] = $value;
        }

        return \json_encode($result);
    }

    public function getErrorId(): int {
        return $this->errorId;
    }

    public function setErrorId(int $errorId): void {
        $this->errorId = $errorId;
    }

    public function getErrorText(): string {
        return $this->errorText;
    }

    public function setErrorText(string $errorText): void {
        $this->errorText = $errorText;
    }

    public function getErrorTraceText(): string {
        return $this->errorTraceText;
    }

    public function setErrorTraceText(string $errorTraceText): void {
        $this->errorTraceText = $errorTraceText;
    }
}
