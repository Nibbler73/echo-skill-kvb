<?php
/**
 * 
 */

// Load Configuration
require_once "configuration.php";

// Load standard libryries
require_once "../classes/autoload.php";

// Register Exception handler
$e = new ExceptionGenericFailureResult();

// Fetch Request
$request = new AlexaRequest();

// Connect to Database
$db = new DatabaseController($request);

// Get Name of Intent
$intentName = $request->getIntent();

// Verify we have that Intent
if(class_exists($intentName)) {
    $intent = new $intentName($db, $request);
    if (!$intent instanceof IntentBase) {
        throw new BadMethodCallException("Unknown Intent: " . $intentName, 99001);
    }
} else {
    throw new BadMethodCallException("Unknown Intent: " . $intentName, 99001);
}

// Trigger Intent and let it do the work
if($intent->verifyIntent()) {
    $intent->executeIntent();
}
$intent->outputResponse();

