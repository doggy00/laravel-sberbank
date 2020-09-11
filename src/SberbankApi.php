<?php

namespace SberbankApi;

use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use SberbankApi\Exceptions\CouldNotSend;

class SberbankApi
{
    protected $http;
    protected $username;
    protected $password;
    protected $is_test;

    public function __construct()
    {
        $this->username = config('sberbank-api.username');
        $this->password = config('sberbank-api.password');
        $this->is_test = config('sberbank-api.test');
    }

    protected function httpClient(): HttpClient
    {
        return new HttpClient();
    }

    public function registerDo(array $params, string $interface = 'rest'): ?ResponseInterface
    {
        return $this->sendRequest('register.do', $params, $interface);
    }

    public function depositDo(array $params, string $interface = 'rest'): ?ResponseInterface
    {
        return $this->sendRequest('deposit.do', $params, $interface);
    }

    public function reverseDo(array $params, string $interface = 'rest'): ?ResponseInterface
    {
        return $this->sendRequest('reverse.do', $params, $interface);
    }

    public function getOrderStatusExtendedDo(array $params, string $interface = 'rest'): ?ResponseInterface
    {
        return $this->sendRequest('getOrderStatusExtended.do', $params, $interface);
    }

    public function declineDo(array $params, string $interface = 'rest'): ?ResponseInterface
    {
        return $this->sendRequest('decline.do', $params, $interface);
    }

    protected function sendRequest(string $endpoint, array $params, string $interface): ?ResponseInterface
    {
        if (blank($this->username)) {
            throw CouldNotSend::sberbankUserNotProvided('You must provide your sberbank user name');
        } elseif (blank($this->password)) {
            throw CouldNotSend::sberbankPasswordNotProvided('You must provide your sberbank password');
        }

        $register = [
            'userName' => $this->username,
            'password' => $this->password
        ];

        $params = array_merge($params, $register);

        $url = new SberbankApiMode($this->is_test);

        $endPointUrl = $url->getUrl() . $interface . '/' . $endpoint;

        try {
            return $this->httpClient()->post($endPointUrl, [
                'form_params' => $params
            ]);
        } catch (ClientException $exception) {
            throw CouldNotSend::sberbankRespondedWithAnError($exception);
        } catch (Exception $exception) {
            throw CouldNotSend::couldNotCommunicateWithSberbank($exception);
        }
    }
}