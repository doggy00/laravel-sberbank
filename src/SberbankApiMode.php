<?php


namespace SberbankApi;


class SberbankApiMode
{
    protected $is_test;
    protected $url;

    public function __construct($test)
    {
        $this->is_test = $test;
    }

    public function getUrl(): string
    {
        return $this->is_test ? $this->getTestUrl() : $this->getProdUrl();
    }

    protected function getTestUrl(): string
    {
        return config('sberbank-api.testurl');
    }

    protected function getProdUrl(): string
    {
        return config('sberbank-api.produrl');
    }
}