<?php


namespace SberbankApi;


use SberbankApi\Exceptions\CouldNotSend;
use SberbankApi\Traits\HasSharedLogic;

class SberbankApiDeclineDo
{
    use HasSharedLogic;

    public static function create(string $orderId): self
    {
        return new static((string)$orderId);
    }

    public function __construct(string $orderId)
    {
        $this->content($orderId);
        $this->params['merchantLogin'] = config('sberbank-api.username');
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
        } elseif (blank($this->params['merchantLogin'])) {
            throw CouldNotSend::sberbankUserNotProvided('You must provide your sberbank user name');
        }

        return $this->apiClient()->send(new self($this->params['orderId']));
    }
}