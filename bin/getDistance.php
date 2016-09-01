<?php
require_once __DIR__ . '/../lib/InputData.php';
require_once __DIR__ . '/../lib/Compute.php';
require_once __DIR__ . '/../lib/Log.php';

$inData = new InputData();  

if($inData->hasInputFile()) {

	$compute = new Compute();
	$distance = $compute->run($inData);
	Log::info("\n\nDistance : $distance !!\n");
	
}