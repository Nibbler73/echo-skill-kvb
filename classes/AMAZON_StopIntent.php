<?php

/**
 * Created by PhpStorm.
 * User: hhusic
 * Date: 14.07.2017
 */
class AMAZON_StopIntent extends IntentBase
{

    public function verifyIntent()
    {
        // TODO: Implement verifyIntent() method.
        return true;
    }

    public function executeIntent()
    {
        // TODO: Implement executeIntent() method.

		$helpText = '<say-as interpret-as="interjection">aha.</say-as>'
				 .  "Du weckst mich also, um mir zu sagen dass ich nichts tun soll?"
				 .  ""
				 .  "";

        // Send Feedback to Echo
        $this->response->setSsmlResponseText($helpText);
    }
}