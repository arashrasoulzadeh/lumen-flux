<?php

namespace App\Actions;

use App\Action;

class AgeAction extends Action
{

	protected $should_cache = true;
	
	public function logic()
	{
		return 'im '.$this->getParam( 'age' ).' years old.';
	}

	public function method()
	{
		return self::METHOD_POST;
	}

	public function validation()
	{
		return [
			'age'	=>	'required|integer'
		];
	}

}