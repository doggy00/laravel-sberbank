<?php


namespace SberbankApi;

class SberbankApiClient
{
    protected $sberbank;

    public function __construct()
    {
        $this->sberbank = new SberbankApi();
    }

    public function send($params) {

        $data = $params->toArray();

        if ($params instanceof SberbankApiRegisterDo) {
            $response = $this->sberbank->registerDo($data);
        } elseif ($params instanceof SberbankApiDepositDo) {
            $response = $this->sberbank->depositDo($data);
        } elseif ($params instanceof SberbankApiReverseDo) {
            $response = $this->sberbank->reverseDo($data);
        } elseif ($params instanceof SberbankApiGetOrderStatusExtendedDo) {
            $response = $this->sberbank->getOrderStatusExtendedDo($data);
        } elseif ($params instanceof SberbankApiDeclineDo) {
            $response = $this->sberbank->declineDo($data);
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}