<?php


namespace SberbankApi\Traits;

trait HasSharedLogic
{
    protected $params = [];

    public function options(array $options): self
    {
        $this->params = array_merge($this->params, $options);

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