<?php


namespace SberbankApi;


use SberbankApi\Exceptions\CouldNotSend;
use SberbankApi\Traits\HasSharedLogic;

class SberbankApiDepositDo
{
    use HasSharedLogic;

    public static function create(int $orderNumber, int $amount): self
    {
        return new self($orderNumber, $amount);
    }

    public function __construct(int $orderNumber, int $amount)
    {
        $this->content($orderNumber, $amount);
    }

    protected function content(int $orderNumber, int $amount): self
    {
        $this->params = [
            'orderNumber' => $orderNumber,
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

        return $this->apiClient()->send($this->params);
    }
}