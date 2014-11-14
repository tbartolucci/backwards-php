<?php
if( !function_exists('session_register') ){

	$GLOBALS['registered_session_variables'] = array();
	/**
	 * Implementation of session_register for backwards compatibility.
	 *
	 * @return bool
	*/
	function session_register(/*  mixed $name [, mixed $... ] */)
	{
		foreach( func_get_args() as $arg ){
			$GLOBALS['registered_session_variables'][] = $arg;
			$_SESSION[$arg] = isset($GLOBALS[$arg]) ? $GLOBALS[$arg] : null;
		}
	}

	register_shutdown_function(function(){
		foreach($GLOBALS['registered_session_variables'] as $arg){
			$_SESSION[$arg] = isset($GLOBALS[$arg]) ? $GLOBALS[$arg] : null;
		}
	});
}