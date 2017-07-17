<?php

/**
 * 
 */
class ListDeparturesIntent extends IntentBase
{
	private $messagePrefix;

    public function verifyIntent()
    {
        // TODO: Implement verifyIntent() method.
        return true;
    }

    public function executeIntent()
    {
        // TODO: Implement executeIntent() method.
        $kvb = new KvbDocumentParser();
        // VRS Info
        // https://www.vrsinfo.de/abfahrtsmonitor/anzeige/vrs_info/Departuremonitor/show/vrs_info-showid/7cd583ae1096addbd6ae70970eef54a1.html?L=0&cHash=caa0a0555485c7bf015af4cd0d5ec2b5
        // VRS Ajax Handler
        // https://www.vrsinfo.de/index.php?eID=tx_vrsinfo_ass2_departuremonitor&i=7cd583ae1096addbd6ae70970eef54a1
        // $kvb->loadHtmlData("https://skill-kvb.amazon-echo.husic.net/178.html");
        $kvb->loadHtmlData("http://www.kvb-koeln.de/german/hst/overview/178/");

        // Send Feedback to Echo
        $this->response->setSsmlResponseText($this->messagePrefix . $kvb->getDepartureText());
        if(strlen($this->messagePrefix) === 0) {
        	$user = new UserAttributesEntity();
        	$this->response->setTextResponseCard(
        		"Haltestelle: " . $user->getDefaultStationName() . "\n"
        	.	$kvb->getDepartureCard()
        	);
        }
    }


    /**
     * @param string $messagePrefix
     */
    public function setMessagePrefix($messagePrefix)
    {
        $this->messagePrefix = $messagePrefix;
    }
}