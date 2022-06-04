<?php
declare(strict_types=1);

namespace App\Core\Http;

use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

/**
 * Result
 */
class Result implements JsonSerializable
{
    public static int $CODE_SUCCESS = 1;

    public static int $CODE_ERROR = 0;

    /**
     * @var int
     */
    private int $code;
    /**
     * @var string|array|object|null
     */
    private string|array|object|null $data;
    /**
     * @var string
     */
    private string $message;

    public function __construct(int $code = 1, string|object|array|null $data = '', string $message = 'SUCCESS')
    {
        $this->code = $code;
        $this->data = $data;
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string|array|object|null
     */
    public function getData(): string|array|null|object
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    #[ArrayShape(['status' => "int", 'message' => "string", 'data' => "mixed"])]
    public function jsonSerialize(): array
    {
        $payload = [
            'code' => $this->code,
            'message' => $this->message,
        ];
        if ($this->data !== null) {
            $payload['data'] = $this->data;
        }
        return $payload;
    }

}
