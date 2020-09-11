<?php


namespace SberbankApi\Traits;


use SberbankApi\SberbankApi;

trait HasSharedLogic
{
    protected $params = [];
    protected $sberbank;

    public function __construct()
    {
        $this->sberbank = new SberbankApi();
    }

    public function options(array $options): self
    {
        $this->params = array_merge($this->params, $options);

        return $this;
    }

    public function returnUrl(): self
    {
        $this->params['returnUrl'] = config('sberbank-api.returnurl');

        return $this;
    }

    public function failUrl(): self
    {
        $this->params['failUrl'] = config('sberbank-api.failurl');

        return $this;
    }

    public function toArray(): array
    {
        return $this->params;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

}