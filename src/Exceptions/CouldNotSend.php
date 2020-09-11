<?php


namespace SberbankApi\Exceptions;

use Exception;
use GuzzleHttp\Exception\ClientException;

class CouldNotSend extends Exception
{
    public static function sberbankUserNotProvided($message): self
    {
        return new static($message);
    }

    public static function sberbankPasswordNotProvided($message): self
    {
        return new static($message);
    }

    public static function sberbankOrderIdNotProvided($message): self
    {
        return new static($message);
    }

    public static function sberbankRespondedWithAnError(ClientException $exception): self
    {
        if (! $exception->hasResponse()) {
            return new static('Sberbank responded with an error but no response body found');
        }

        $statusCode = $exception->getResponse()->getStatusCode();

        $result = json_decode($exception->getResponse()->getBody(), false);
        $description = $result->description ?? 'no description given';

        return new static("Sberbank responded with an error `{$statusCode} - {$description}`");
    }

    public static function couldNotCommunicateWithSberbank($message): self
    {
        return new static("The communication with Sberbank failed. `{$message}`");
    }

    public static function orderNumberNotProvided(): self
    {
        return new static("Order number was not provided");
    }

    public static function orderAmountNotProvided(): self
    {
        return new static("Order amount was not provided");
    }

    public static function orderReturnUrlNotProvided(): self
    {
        return new static("Order return url was not provided. Please edit config file sberbank-api");
    }

    public static function invalidType(): self
    {
        return new static('Invalid type');
    }
}