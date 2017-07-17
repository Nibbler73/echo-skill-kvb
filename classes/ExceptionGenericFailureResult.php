<?php

/**
 * 
 */
class ExceptionGenericFailureResult
{
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
                    'ssml' => '<speak><say-as interpret-as="interjection">au weia.</say-as> Da ist aber gründlich was schief gegangen. Das muss <sub alias="Herr Woje">Hrvoje</sub> sich mal anschauen.</speak>'
                ],
                'shouldEndSession' => true
            ]
        ];
        header ( 'Content-Type: application/json; charset=utf-8' );
        echo json_encode ( $responseArray );
    }
}