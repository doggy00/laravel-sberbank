<?php


namespace SberbankApi;


use SberbankApi\Exceptions\CouldNotSend;
use SberbankApi\Traits\HasSharedLogic;

class SberbankApiRegisterDo
{
    use HasSharedLogic;

    public static function create(int $orderNumber, int $amount): self
    {
        return new self($orderNumber, $amount);
    }

    public function __construct(int $orderNumber, int $amount)
    {
        $this->content($orderNumber, $amount);
        $this->params['returnUrl'] = config('sberbank-api.returnurl');
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
        if (blank($this->params['orderNumber'])) {
            throw CouldNotSend::orderNumberNotProvided();
        } elseif (blank($this->params['amount'])) {
            throw CouldNotSend::orderAmountNotProvided();
        } elseif (blank($this->params['returnUrl'])) {
            throw CouldNotSend::orderReturnUrlNotProvided();
        }

        return $this->apiClient()->send($this->params);
    }
}