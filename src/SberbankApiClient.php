<?php


namespace SberbankApi;


use SberbankApi\Exceptions\CouldNotSend;

class SberbankApiClient
{
    protected $sberbank;

    public function __construct()
    {
        $this->sberbank = new SberbankApi();
    }

    public function send($params) {

        if (!is_array($params)) {
            throw CouldNotSend::invalidType();
        }

        if ($params instanceof SberbankApiRegisterDo) {
            $response = $this->sberbank->registerDo($params);
        } elseif ($params instanceof SberbankApiDepositDo) {
            $response = $this->sberbank->depositDo($params);
        } elseif ($params instanceof SberbankApiReverseDo) {
            $response = $this->sberbank->reverseDo($params);
        } elseif ($params instanceof SberbankApiGetOrderStatusExtendedDo) {
            $response = $this->sberbank->getOrderStatusExtendedDo($params);
        } elseif ($params instanceof SberbankApiDeclineDo) {
            $response = $this->sberbank->declineDo($params);
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}