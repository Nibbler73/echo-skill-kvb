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
        $user = new UserAttributesEntity();

        // Send Feedback to Echo
        $this->response->setSsmlResponseText("Die Haltestelle lautet " . $user->getDefaultStationName());
    }
}