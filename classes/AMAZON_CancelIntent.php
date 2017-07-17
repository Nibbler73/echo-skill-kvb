<?php

/**
 * Created by PhpStorm.
 * User: hhusic
 * Date: 14.07.2017
 */
class AMAZON_CancelIntent extends IntentBase
{

    public function verifyIntent()
    {
        // TODO: Implement verifyIntent() method.
        return true;
    }

    public function executeIntent()
    {
        // TODO: Implement executeIntent() method.

		$helpText = '<say-as interpret-as="interjection">ist nicht dein ernst.</say-as>'
				 .  "Ich kann doch nicht abbrechen, was ich noch nicht begonnen habe."
				 .  ""
				 .  "";

        // Send Feedback to Echo
        $this->response->setSsmlResponseText($helpText);
    }
}