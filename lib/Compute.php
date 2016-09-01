<?php
class Compute
{
	public function run(InputData $inData) {
		$inData->printInputData();
		$diffX = $inData->getXcrabe() - $inData->getXAlgue();
		$diffY = $inData->getYCrabe() - $inData->getYAlgue();
		$result = abs($diffX) + abs($diffY);
		
		return $result;
	}
}