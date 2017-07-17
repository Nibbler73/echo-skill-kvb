<?php

/**
 * Created by PhpStorm.
 * User: hhusic
 * Date: 14.07.2017
 * Time: 13:45
 */
class AlexaResponse
{
    /* @var AlexaRequest */
    private $request;
    private $responseArray = [
        'version' => '1.0',
        'response' => [
            'outputSpeech' => [
                'type' => 'SSML',
                'text' => null,
                'ssml' => '<speak><say-as interpret-as="interjection">ähm.</say-as> Offenbar bin ich kaputt, denn ich habe vergessen was Du gesagt hast.</speak>'
            ],
            'shouldEndSession' => true
        ]
    ];


    /*
     * Response Messages Names
     */
    const speechTypeSsml    = "SSML";
    const speechTypeText    = "PlainText";
    const cardTypeText      = "Simple";
    const GENERIC_OK=1;
    const GENERIC_WARNING=2;

    /*
     * Response Messages collection
     */
    private $responseMessages = [
        self::GENERIC_OK => "okey dokey",
        self::GENERIC_WARNING => "<say-as interpret-as=\"interjection\">au weia.</say-as> Da muss <sub alias=\"Herr Woje\">Hrvoje</sub> mal schauen was schief gegangen ist."
    ];

    public function __construct($request)
    {
        if($request instanceof AlexaRequest) {
            $this->request = $request;
        } else {
            throw new BadMethodCallException(__METHOD__.": invalid AlexaRequest object");
        }
    }

    public function setSsmlResponseText($ssml)
    {
        if(strpos('<speak>', $ssml) === false) {
            $ssml = '<speak>' . $ssml . '</speak>';
        }
        $this->responseArray['response']['outputSpeech']['type'] = self::speechTypeSsml;
        $this->responseArray['response']['outputSpeech']['text'] = null;
        $this->responseArray['response']['outputSpeech']['ssml'] = $ssml;
    }
    public function setTextResponseText($text)
    {
        $this->responseArray['response']['outputSpeech']['type'] = self::speechTypeText;
        $this->responseArray['response']['outputSpeech']['text'] = $text;
        $this->responseArray['response']['outputSpeech']['ssml'] = null;
    }
    public function setTextResponseCard($text)
    {
        $this->responseArray['response']['card']['type']	= self::cardTypeText;
        $this->responseArray['response']['card']['title']	= "Die nächsten Abfahrten";
        $this->responseArray['response']['card']['content']	= $text;
    }

    public function outputResponse()
    {
        header ( 'Content-Type: application/json; charset=utf-8' );
        echo json_encode ( $this->responseArray );
    }
}