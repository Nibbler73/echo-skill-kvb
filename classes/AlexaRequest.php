<?php

/**
 * Created by PhpStorm.
 * User: hhusic
 * Date: 14.07.2017
 * Time: 13:44
 */
class AlexaRequest
{
    private $entityBody;

    public function __construct()
    {
        // Fetch data from Request
        $entityBody = file_get_contents ( 'php://input' );
        if(!is_string($entityBody) || strlen($entityBody) < 1) {
            if(array_key_exists('debug', $_REQUEST)) {
                $testString = new TestIntentListDepartures();
                $entityBody = $testString->requestString;
            } else {
                throw new BadMethodCallException(__METHOD__.": no request data was sent");
            }
        }
        $this->entityBody = json_decode( $entityBody, $assoc = true );
        if(! is_array($this->entityBody)) {
            throw new BadMethodCallException(__METHOD__.": cannot read amazon echo request");
        }
    }

    public function getUserId()
    {
        $userId = $this->entityBody['session']['user']['userId'];
        if(!is_string($userId) || strlen($userId) < 1) {
            throw new BadMethodCallException(__METHOD__.": no userId");
        }
        return $userId;
    }

    public function getIntent()
    {
        $intentName = $this->entityBody['request']['intent']['name'];
        if(!is_string($intentName) || strlen($intentName) < 1) {
            throw new BadMethodCallException(__METHOD__.": no intent");
        }
        // Sanitize Amazon-Internal names
        $intentName = str_replace('.', '_', $intentName);
        return $intentName;
    }
    public function getIntentSlots()
    {
        $intentSlotsList = $this->entityBody['request']['intent']['slots'];
        if(!is_array($intentSlotsList) || count($intentSlotsList) < 1) {
            throw new BadMethodCallException(__METHOD__.": no intent slots");
        }
        return $intentSlotsList;
    }

    /**
     * @return mixed
     */
    public function getEntityBody()
    {
        return $this->entityBody;
    }
}