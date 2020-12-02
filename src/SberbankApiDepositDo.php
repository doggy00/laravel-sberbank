<?php


namespace SberbankApi;


use SberbankApi\Exceptions\CouldNotSend;
use SberbankApi\Traits\HasSharedLogic;

class SberbankApiDepositDo
{
    use HasSharedLogic;

    public static function create(string $orderId, int $amount): self
    {
        return new self((string)$orderId, (int)$amount);
    }

    public function __construct(string $orderId, int $amount)
    {
        $this->content($orderId, $amount);
    }

    protected function content(string $orderId, int $amount): self
    {
        $this->params = [
            'orderId' => $orderId,
            'amount' => $amount
        ];

        return $this;
    }

    public function send()
    {
        if (blank($this->params['orderId'])) {
            throw CouldNotSend::sberbankOrderIdNotProvided('You must provide your sberbank order ID');
        } elseif (blank($this->params['amount'])) {
            throw CouldNotSend::orderAmountNotProvided();
        }

        return $this->apiClient()->send(new self($this->params['orderId'], $this->params['amount']));
    }
}