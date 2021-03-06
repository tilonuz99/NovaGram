<?php

namespace skrtdev\Telegram;

class Exception extends \Exception{

    public function __construct(string $method, array $response, array $data, Exception $previous = null) {

        $this->method = $method;
        $this->data = $data;

        parent::__construct($response['description'], $response['error_code'], $previous);
    }

    public function __toString() {
        return get_class($this) . ": {$this->code} {$this->message} (caused by {$this->method}) in {$this->file}:{$this->line}\nStack trace:\n".$this->getTraceAsString();
    }

    public static function create(string $method, array $response, array $data, Exception $previous = null) {
        $args = func_get_args();
        switch ($response['error_code']) {
            case 400:
                return new BadRequestException(...$args);
                break;

            case 401:
                return new UnauthorizedException(...$args);
                break;

            case 403:
                return new ForbiddenException(...$args);
                break;

            case 409:
                return new ConflictException(...$args);
                break;

            case 429:
                return new TooManyRequestsException(...$args);
                break;

            case 502:
                return new BadGatewayException(...$args);
                break;

            default:
                return new self(...$args);
                break;
        }
    }
}

?>
