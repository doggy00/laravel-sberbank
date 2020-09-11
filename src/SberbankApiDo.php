<?php


namespace SberbankApi;


use SberbankApi\Traits\HasSharedLogic;

class SberbankApiDo
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

    public function content(int $orderNumber, int $amount): self
    {
        $this->params = [
            'orderNumber' => $orderNumber,
            'amount' => $amount
        ];

        return $this;
    }

    public function send()
    {
        return SberbankApiClient::send($this->params);
    }
}