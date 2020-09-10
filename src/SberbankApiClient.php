<?php


namespace SberbankApi;


class SberbankApiClient
{
    protected $sberbank;

    public function __construct(SberbankApi $sberbank)
    {
        $this->sberbank = $sberbank;
    }

    public function send($params) {

        $response = $this->sberbank->registerDo($params);
        return json_decode($response->getBody()->getContents(), true);
    }
}