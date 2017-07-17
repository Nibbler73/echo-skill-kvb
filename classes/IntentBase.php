<?php

/**
 * 
 */
abstract class IntentBase
{
    /* @var AlexaRequest */
    protected $request;
    /* @var AlexaResponse */
    protected $response;
    /* @var DatabaseController */
    protected $db;

    public function __construct($db, $request)
    {
        if($db instanceof DatabaseController) {
            $this->db = $db;
        } else {
            throw new BadMethodCallException(__METHOD__.": invalid Database object");
        }
        if($request instanceof AlexaRequest) {
            $this->request = $request;
        } else {
            throw new BadMethodCallException(__METHOD__.": invalid AlexaRequest object");
        }
        $this->response = new AlexaResponse($request);
    }
    public function getIntentSlots()
    {
        return $this->request->getIntentSlots();
    }

    /*
     * Activate Skill
     */
    abstract public function verifyIntent();
    abstract public function executeIntent();
    public function outputResponse()
    {
        $this->response->outputResponse();
    }

}