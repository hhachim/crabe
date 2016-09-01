<?php
require_once __DIR__ . "/Log.php";
class InputData {
	protected $xCrabe;
	protected $yCrabe;
	protected $xAlgue;
	protected $yAlgue;
	protected $inputFile;
	protected $nbLines;
	protected $nbCols;
	const CRABE = "{";
	const ALGUE = "$";
	
	public function getXcrabe() {
		return $this->xCrabe;
	}
	
	public function getYCrabe() {
		return $this->yCrabe;
	}
	
	public function getXAlgue() {
		return $this->xAlgue;
	}
	
	public function getYAlgue() {
		return $this->yAlgue;
	}
	
	public function hasInputFile() {
		return is_file ( $this->inputFile );
	}
	
	public function getNbLines() {
		return $this->nbLines;
	}
	
	public function getNbCols() {
		return $this->nbCols;
	}
	
	public function __construct() {
		$this->inputFile = __DIR__ . "/../inputDir/inputFile.txt";
		
		if (! $this->hasInputFile ()) {
			echo "\nFile inputFile.txt is not found in " . __DIR__ . "\n";
			exit ();
		}
		
		$this->setData();
	}
	
	public function printInputData() {
		$data = array("xCrabe" => $this->xCrabe,
					  "yCrabe" => $this->yCrabe,
					  "xAlgue" => $this->xAlgue,
					  "yAlgue" => $this->yAlgue,
					  "nbLines" => $this->nbLines,
					  "nbCols" => $this->nbCols
		);
		
		//Log::info(json_encode($data));
		echo "\n\nInput data : \n";
		print_r($data);
		echo "\n";
	}
	private function setData() {
		$this->setNbColsAndAnbLines();
		$this->setXYcrabe();
		$this->setXYalgue();
	}
	
	private function setXYcrabe() {
		$result = $this->findLineFor(self::CRABE,true);
		
		if(!$result['lineData']) {
			Log::error("no crabe found!");
		}
		$this->xCrabe = strpos ( $result['lineData'], self::CRABE );
		$this->yCrabe = $result['lineNumber'] -1;//-1 for the first row containing m and n
	}
	
	private function setXYalgue() {
		$result = $this->findLineFor(self::ALGUE,true);
	
		if(!$result['lineData']) {
			Log::error("no algue found!");
		}
		$this->xAlgue = strpos ( $result['lineData'], self::ALGUE );
		$this->yAlgue = $result['lineNumber'] -1;//-1 for the first row containing m and n
	}
	
	private function setNbColsAndAnbLines() {
		$f = fopen ( $this->inputFile, 'r' );
		$line = fgets ( $f );
		fclose ( $f );
		$parts = explode(" ", trim($line));
		
		if(!isset($parts[0]) || !is_numeric($parts[0])) {
			Log::error("invalide fata : number of lines is missing\n");	
			exit;
		}
		
		if(!isset($parts[1]) || !is_numeric($parts[1])) {
			Log::error("invalide fata : number of cols is missing\n");
			exit;
		}
		$this->nbLines = $parts[0];
		$this->nbCols = $parts[1];
	}
	
	/**
	 * use less ram when searching the line number containing a word in the inputFile
	 */
	private function findLineFor($searchfor, $returnData=false) {
		$lineNumber = 0;
		
		$handle = @fopen ( $this->inputFile, "r" );
		
		$i = 0;
		if ($handle) {
			while ( ! feof ( $handle ) ) {
				$buffer = fgets ( $handle );
				$i++;
				if (strpos ( $buffer, $searchfor ) !== FALSE) {
					$lineNumber = $i;
					break;
				}
			}
			fclose ( $handle );
		}
		
		if(!$lineNumber) {
			return false;
		}
		
		if($returnData) {
			return array("lineData" => $buffer, "lineNumber" => $lineNumber);
		}
		
		return $lineNumber;
	}
}

?>