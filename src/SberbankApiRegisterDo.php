<?php


namespace SberbankApi;


use SberbankApi\Exceptions\CouldNotSend;
use SberbankApi\Traits\HasSharedLogic;

class SberbankApiRegisterDo
{
    use HasSharedLogic;

    public static function create(string $orderNumber, int $amount): self
    {
        return new self((string)$orderNumber, (int)$amount);
    }

    public function __construct(string $orderNumber, int $amount)
    {
        $this->content($orderNumber, $amount);
        $this->params['returnUrl'] = config('sberbank-api.returnurl');
    }

    protected function content(string $orderNumber, int $amount): self
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
        } elseif (empty($this->params['amount'])) {
            throw CouldNotSend::orderAmountNotProvided();
        } elseif (blank($this->params['returnUrl'])) {
            throw CouldNotSend::orderReturnUrlNotProvided();
        }

        return $this->apiClient()->send(new self($this->params['orderNumber'], $this->params['amount']));
    }
}