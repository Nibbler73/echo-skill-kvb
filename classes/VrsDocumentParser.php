<?php

/**
 *
 */
class VrsDocumentParser
{
    private $departureList;
    private $departureTextList;
    private $departureText;
    private $departureCardList;
    private $departureCard;
    private $userLines;


    public function __construct()
    {
        $this->departureList = $this->departureTextList = array();
    }

    public function loadHtmlData($url)
    {
        // load VRS URL
        //$html = file_get_contents("https://www.vrsinfo.de/index.php?eID=tx_vrsinfo_ass2_departuremonitor&i=7cd583ae1096addbd6ae70970eef54a1");
        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "Accept-language: de\r\n" .
                    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36\r\n" .
                    "Cookie: foo=bar\r\n"
            ]
        ];
        $json = @file_get_contents($url, $pFlags=false, stream_context_create($opts));
        if(strlen($json) < 1) {
            throw new BadMethodCallException(__METHOD__.": cannot fetch data from URL", 42001);
        }

        $vrsObj = json_decode($json, $pAssoc=true);
        if(! is_array($vrsObj) || ! array_key_exists('events', $vrsObj)) {
            throw new BadMethodCallException(__METHOD__.": cannot interpret data from URL", 42002);
        }

        $updated    = DateTime::createFromFormat('d.m. H:i:s', $vrsObj['updated']);

        $events     = $vrsObj['events'];
        foreach ($events as $event) {
            $stopPointObj   = $event['stopPoint'];
            $departureObj   = $event['departure'];
            $lineObj        = $event['line'];

            $line           = $lineObj['number'];
            $direction      = $lineObj['direction'];
            $etaTime        = DateTime::createFromFormat('U', $departureObj['timestamp']);
            $minutesLeftObj = $updated->diff($etaTime);
            $minutesLeft    = $minutesLeftObj->format('i');

            // Verify whether the Line number matches the user-prefs
            if(is_null($this->userLines) || (is_array($this->userLines) && array_key_exists($line, $this->userLines))) {
                $this->departureTextList[]  = $line . " nach " . $direction . ($minutesLeft >= 1 ? " in {$minutesLeft} Min.":" kommt sofort");
                $this->departureCardList[]  = $etaTime->format('H:i') . " ({$minutesLeft} Min.): Linie " . $line . " nach " . $direction;
            }
        }

        // merge single texts to one announcement
        $this->departureText = "Linie " . implode(', ', $this->departureTextList) . '.';
        $this->departureCard = "Linie:\n" . implode(",\n", $this->departureTextList) . '.';
    }

    /**
     * @return array
     */
    public function getDepartureList()
    {
        return $this->departureList;
    }
    /**
     * @param mixed $userLines
     */
    public function setUserLines($userLines)
    {
        $this->userLines = $userLines;
    }

    /**
     * @return mixed
     */
    public function getDepartureText()
    {
        return $this->departureText;
    }
    public function getDepartureCard()
    {
        return $this->departureCard;
    }
}