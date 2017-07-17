<?php

/**
 * 
 */
class KvbDocumentParser
{
    private $departureList;
    private $departureTextList;
    private $departureText;
    private $departureCard;
    private $userLines;


    public function __construct()
    {
        $this->departureList = $this->departureTextList = array();
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

    private function cmpMinutesLeft($a, $b)
    {
        return strcmp($a[3], $b[3]);
    }

    public function loadHtmlData($url)
    {
        // load KVB URL
        //$html = file_get_contents("http://www.kvb-koeln.de/german/hst/overview/178/");
        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "Accept-language: de\r\n" .
                    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36\r\n" .
                    "Cookie: foo=bar\r\n"
            ]
        ];
        $html = @file_get_contents($url, $pFlags=false, stream_context_create($opts));
        if(strlen($html) < 1) {
            throw new BadMethodCallException(__METHOD__.": cannot fetch data from URL");
        }

        // a new dom object
        $dom = new domDocument;

        // load the html into the object
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();

        // discard white space
        $dom->preserveWhiteSpace = false;

        // find all table-Elements
        //$tables = $dom->getElementsByTagName("table");
        $xpath = new \DOMXpath($dom);
        /* @var DOMNodeList */
        $tables = $xpath->query('//table[@class="mobile_table_100"]');
        // loop all tables to find the one we are looking for
        /* @var $table DOMElement */
        foreach ($tables as $table) {
            $trs = $table->getElementsByTagName("tr");
            /* @var $tr DOMElement */
            foreach ($trs as $tr) {
                /* @var DOMNodeList */
                $tds = $tr->childNodes;
                $departureRow = array();
                foreach ($tds as $td) {
                    /* @var $td DOMElement */
                    //$departureRow[] = trim( html_entity_decode( str_replace( '&nbsp;', ' ', $td->textContent ) ) );
                    $departureRow[] = $td->textContent;
                }
                /*
                 * 0: Line Number
                 * 1: Station to where Line is heading
                 * 2: How many minutes left
                 */
                // Add 3: just minutes
                $departureRow[0] = preg_replace("/[^0-9]/","", $departureRow[0]);
                $departureRow[3] = preg_replace("/[^0-9]/","", $departureRow[2]);
                $this->departureList[] = $departureRow;
            }
        }
        // Now sort the results by departure time ascending
        // convert to speakable text
        $counter = 0;
        $maxMessages = 5;
        foreach ($this->departureList as $departure) {
            // Keep an eye on the maximum entries
            $counter++;
            if($counter>$maxMessages) {
                break;
            }
            // Verify whether the Line number matches the user-prefs
            $line = $departure[0];
            if(is_null($this->userLines) || (is_array($this->userLines) && array_key_exists($line, $this->userLines))) {
                $this->departureTextList[] = $departure[0]." nach ".$departure[1]." in ".$departure[2];
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
}