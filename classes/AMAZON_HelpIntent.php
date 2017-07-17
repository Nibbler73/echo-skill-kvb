<?php

/**
 * Created by PhpStorm.
 * User: hhusic
 * Date: 14.07.2017
 */
class AMAZON_HelpIntent extends IntentBase
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
        $defaultStation = $user->getDefaultStationName();

		$helpText = "Du kannst mich fragen, wann die Bahnen an Deiner Haltestelle ankommen."
				 .  "Sage dazu etwa: <emphasis>Frage Haltestelle, wann die Bahn kommt.</emphasis>"
				 .  "Ich sage Dir dann die Bahnen, die von der Haltestelle {$defaultStation} abfahren."
				 .  "";

        // Send Feedback to Echo
        $this->response->setSsmlResponseText($helpText);
    }
}