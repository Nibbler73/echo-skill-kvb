<?php

/**
 * Created by PhpStorm.
 * User: hhusic
 * Date: 14.07.2017
 * Time: 15:36
 */
class ConfigureHaltestelleIntent extends IntentBase
{
    private $usersStationName;
    private $lookupStationName;
    private $lookupStationId;

    /*
     * Response Messages Names
     */
    const CONFIGURATION_STATION_SET=3;
    const CONFIGURATION_STATION_FAILED=4;
    /*
     * Response Messages collection
     */
    private $responseMessages = [
        self::CONFIGURATION_STATION_SET => '<say-as interpret-as="interjection">okey dokey.</say-as> Deine Haltestelle ist ab jetzt {Haltestelle}',
        self::CONFIGURATION_STATION_FAILED => '<say-as interpret-as="interjection">au weia.</say-as> Die Haltestelle zu ändern hat leider nicht geklappt.',
    ];


    public function verifyIntent()
    {
        // Verify that we have a station name
        // Lookup and see if we can use the station name
        $slots = $this->getIntentSlots();
        $slotHaltestelle = $slots['Haltestelle'];
        if(is_array($slotHaltestelle) && count($slotHaltestelle) > 0) {
            $this->usersStationName     = $slotHaltestelle['value'];
            $this->lookupStationId      = $slotHaltestelle['id'];
            $this->lookupStationName    = "Aachener Str./Gürtel, Köln-Braunsfeld";
            return $slotHaltestelle['name'] === 'Haltestelle' && strlen($slotHaltestelle['value']) > 0;
        }
        return false;
    }

    public function executeIntent()
    {
        // Store station Name in Database
        $user = $this->db->getUserAttributes();
        // TODO: Actually look up the Station Name and ID from the user's text
        $stationName = $user->getDefaultStationName();
        // Claim everything is ok
        $responseTemplate = $this->responseMessages[self::CONFIGURATION_STATION_SET];
        $responseText = str_replace('{Haltestelle}', $stationName, $responseTemplate);
        if($user->isAdmin() && strlen($this->usersStationName) > 0) {
            $responseText .= " Gehörter Name der Haltestelle: ".$this->usersStationName;
        }
        if($user->isAdmin() && strlen($this->lookupStationId) > 0) {
            $responseText .= " Id der Haltestelle: ".$this->lookupStationId;
        }
        $this->response->setSsmlResponseText($responseText);
    }
}