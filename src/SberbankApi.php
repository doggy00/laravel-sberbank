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

    public function __construct($username = null, $password = null, $test = false, HttpClient $httpClient = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->http = $httpClient;
        $this->is_test = $test;
    }

    protected function httpClient(): HttpClient
    {
        return $this->http ?? new HttpClient();
    }

    public function registerDo(array $params, string $interface): ?ResponseInterface
    {
        return $this->sendRequest('register.do', $params, $interface);
    }

    protected function sendRequest(string $endpoint, array $params, string $interface = 'rest', bool $multipart = false): ?ResponseInterface
    {
        if (blank($this->username)) {
            throw CouldNotSend::sberbankUserNotProvided('You must provide your sberbank user name');
        } elseif (blank($this->password)) {
            throw CouldNotSend::sberbankPasswordNotProvided('You must provide your sberbank password');
        }

        $url = new SberbankApiMode($this->is_test);

        $endPointUrl = $url->getUrl() . $interface . '/' . $endpoint;

        try {
            return $this->httpClient()->post($endPointUrl, [
                'headers' => [
                    'userName' => $this->username,
                    'password' => $this->password
                ],
                $multipart ? 'multipart' : 'form_params' => $params
            ]);
        } catch (ClientException $exception) {
            throw CouldNotSend::sberbankRespondedWithAnError($exception);
        } catch (Exception $exception) {
            throw CouldNotSend::couldNotCommunicateWithSberbank($exception);
        }
    }

}