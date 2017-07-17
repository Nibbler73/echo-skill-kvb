<?php

/**
 * Created by PhpStorm.
 * User: hhusic
 * Date: 14.07.2017
 */
class AMAZON_RepeatIntent extends ListDeparturesIntent
{
	private $previousIntent;

	public function __construct($db, $request)
    {
    	parent::__construct($db, $request);
    	$this->setMessagePrefix('<say-as interpret-as="interjection">alles klar.</say-as>');
    }
}