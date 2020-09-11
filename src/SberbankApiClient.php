<?php


namespace SberbankApi;


use SberbankApi\Exceptions\CouldNotSend;

class SberbankApiClient
{
    protected $sberbank;

    public function __construct(SberbankApi $sberbank)
    {
        $this->sberbank = $sberbank;
    }

    public function send($params) {

        if (!is_array($params)) {
            throw CouldNotSend::invalidType();
        }

        if (blank($params['orderNumber'])) {
            throw CouldNotSend::orderNumberNotProvided();
        } elseif (blank($params['amount'])) {
            throw CouldNotSend::orderAmountNotProvided();
        } elseif (blank($params['returnUrl'])) {
            throw CouldNotSend::orderReturnUrlNotProvided();
        }

        $params = SberbankApiDo::create($params['orderNumber'], $params['amount']);

        $data = $params->toArray();

        if ($params instanceof SberbankApiDo) {
            $response = $this->sberbank->registerDo($data);
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}