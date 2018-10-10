<?php

namespace app\helpers;

use Yii;
use app\helpers\GoogleApi;
use yii\helpers\Url;

class GmailApi extends GoogleApi
{
    const GMAIL_FULL_ACCESS = 'https://mail.google.com/';
    const CREDENTIALS_PATH = '~/.crm_credentials/vlcrm_gmail.json';

    public function __construct($scope = [self::GMAIL_FULL_ACCESS])
    {
        parent::__construct();

        $this->client->addScope(implode(',', $scope));

        $this->service = new \Google_Service_Gmail($this->client);
    }

    /**
     * Perform full synchronization.
     * Use when the first time your application connects to Gmail
     *
     */
    public function fullSynchronization()
    {
        
    }

    /**
     * Perform partial synchronization
     *
     */
    public function partialSynchronization($historyId)
    {

    }
}