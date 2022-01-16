<?php
namespace App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

abstract class Action
{
	const METHOD_GET    = 'GET';
	const METHOD_POST   = 'POST';
	const METHOD_PATCH  = 'PATCH';
	const METHOD_DELETE = 'DELETE';

	protected $should_cache = 	false;
	protected $cache_key	=	null;
	protected $cache_ttl	=	10;

	public function method()
	{
		return self::METHOD_GET;
	}

	public function logic()
	{
		return 'Not Implemented.';
	}

	public function logicRender()
	{
		$logic = $this->logic();
		return $logic;
	}

	public function render()
	{
		if ( !$this->should_cache )
		{
			return $this->logicRender();
		}
		else
		{
			if ( is_null( $this->cache_key ) )
			{
				$class_name         =	get_class( $this );
				$params		        =	json_encode(Request::capture()->all());
				$this->cache_key 	=	md5( $class_name.$params );
			}
			return Cache::remember( $this->cache_key, $this->cache_ttl, function(){
				return $this->logicRender();
			});
		}
	}

	protected function getParam( $name, $default=null )
	{
		$request = Request::capture();
		return $request->input( $name, $default );
	}

	public function validation()
	{
		return [];
	}
}