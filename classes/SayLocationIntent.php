<?php

/**
 * 
 */
class SayLocationIntent extends IntentBase
{

    public function verifyIntent()
    {
        // TODO: Implement verifyIntent() method.
        return true;
    }

    public function executeIntent()
    {
        // TODO: Implement executeIntent() method.
        $user = $this->getUser();

        // Send Feedback to Echo
        $this->response->setSsmlResponseText("Die Haltestelle lautet " . $user->getDefaultStationName());
    }
}