<?php

namespace app\helpers;

use Yii;

class GoogleApi
{
    /**
     * @var Google_Client $client
     */
    protected $client;

    /**
     * Define crediential path store access token
     * @var [type]
     */
    protected $credentialsPath;

    protected $service;

    /**
     * Application's name
     */
    const APPLICATION_NAME = 'VLCRM';

    const CREDENTIALS_PATH = '~/.crm_credentials/vlcrm.json';

    /**
     * Path of secret file of application
     */
    const CLIENT_SECRET_PATH =  __DIR__ . '/../client_secret.json';

    public function __construct()
    {
        $homeDirectory = getenv('HOME');

        if (empty($homeDirectory)) {
            $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
        }

        $this->credentialsPath = str_replace('~', realpath($homeDirectory), static::CREDENTIALS_PATH);

        $client = new \Google_Client();
        $client->setAuthConfig(self::CLIENT_SECRET_PATH);
        $client->setApplicationName(self::APPLICATION_NAME);
        $client->setAccessType('offline');
        $client->setRedirectUri('http://crm.dev/crm/search/test');

        if (file_exists($this->credentialsPath)) {
            $accessToken = json_decode(file_get_contents($this->credentialsPath), true);
            $client->setAccessToken($accessToken);

            // Refresh the token if it's expired.
            if ($client->isAccessTokenExpired()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                file_put_contents($this->credentialsPath, json_encode($client->getAccessToken()));
            }
        }

        $this->client = $client;
    }

    /**
     * Authorize app with code return from goole
     * @param  string $code
     * @return boolean
     */
    public function authenticate($code)
    {
        if ($this->client->authenticate($code)) {
            // Store the credentials to disk.
            if(!file_exists(dirname($this->credentialsPath))) {
                mkdir(dirname($this->credentialsPath), 0700, true);
            }
            file_put_contents($this->credentialsPath, json_encode($this->client->getAccessToken()));

            return true;
        }

        return false;
    }

    /**
     * Check app is authorized
     * @return boolean
     */
    public function isAuthorization()
    {
        return file_exists($this->credentialsPath);
    }

    /**
     * Converting to standard RFC 4648 base64-encoding
     * @param  string $data Encoded data
     * @return string
     */
    public function decodeBase64($data)
    {
        return base64_decode(strtr($data, array('-' => '+', '_' => '/')));
    }

    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    public function getService()
    {
        return $this->service;
    }
}