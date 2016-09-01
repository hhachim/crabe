<?php
class Log
{
	const ERROR_STATUS = "ERROR";
	public static function info($message) {
		self::message($message);
	}
	
	public static function error($errorMessage) {
		self::message($errorMessage,self::ERROR_STATUS);
	}
	
	private static function message($message,$status="INFO") {
		$dateTime = date("Y-m-d H:i:s");
		echo "\n$dateTime\t$status\t$message";
	}
}