<?php

/**
 * 
 */
class ExceptionGenericFailureResult
{
    /*
     * Predefined error messages
     * Can be referenced by placing their ID as the exception error-code
     */
    private $errorMessages = array(
        // Parsing Echo Input
        11000   => "Ein technischer Fehler ist aufgetreten, beim Auswerten der A.W.S. Anfrage an das V.R.S. System.",
        11001   => "Ich kann Deinen Amazon Echo nicht erkennen und somit auch nicht Deiner Haltestelle zuordnen. Bitte versuche es später erneut.",
        11002   => "Amazon Echo kann Deine Absicht nicht erkennen. Bitte versuche es mit einer anderen Formulierung.",
        11003   => "Amazno Echo kann den gesprochenen Wert nicht erkennen. Das ist ein technischer Fehler, vielleicht hilft es aber auch eine andere Formulierung zu verwenden.",
    );
    /*
     * Ranges of error messages
     */
    private $errorMessagesRangeDefinitions = array();


    public function __construct()
    {
        set_exception_handler(array($this, 'generic_exception_handler'));
    }

    public function generic_exception_handler($e)
    {
        $responseArray = [
            'version' => '1.0',
            'response' => [
                'outputSpeech' => [
                    'type' => 'SSML',
                    'text' => null,
                    'ssml' => '<speak><say-as interpret-as="interjection">au weia.</say-as> Da ist aber etwas gründlich schief gegangen.</speak>'
                ],
                'shouldEndSession' => true
            ]
        ];
        if($e instanceof Exception) {
            $code = $e->getCode();
            if(array_key_exists($code, $this->errorMessages)) {
                $responseArray['response']['outputSpeech']['ssml'] = '<speak><say-as interpret-as="interjection">au weia.</say-as> '.$this->errorMessages[$code].'</speak>';
            }
        }
        header ( 'Content-Type: application/json; charset=utf-8' );
        echo json_encode ( $responseArray );
    }
}