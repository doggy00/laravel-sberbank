<?php


namespace SberbankApi;


use SberbankApi\Exceptions\CouldNotSend;
use SberbankApi\Traits\HasSharedLogic;

class SberbankApiReverseDo
{
    use HasSharedLogic;

    public static function create(string $orderId): self
    {
        return new static($orderId);
    }

    public function __construct(string $orderId)
    {
        $this->content($orderId);
    }

    protected function content(string $orderId): self
    {
        $this->params = [
            'orderId' => $orderId
        ];

        return $this;
    }

    public function send()
    {
        if (blank($this->params['orderId'])) {
            throw CouldNotSend::sberbankOrderIdNotProvided('You must provide your sberbank order ID');
        }

        return $this->apiClient()->send(new self($this->params['orderId']));
    }
}