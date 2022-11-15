<?php 
namespace core\ExecutionTime;
class ExecutionTime
{
	private $startTime;
	
	private $endTime;

	public function start(){
		$this->startTime = getrusage();
	}

	public function end(){
		$this->endTime = getrusage();
	}

	private function runTime($ru, $rus, $index) {
		return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
	-  ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
	}    

	public function __toString(){
		return "This process used " . $this->runTime($this->endTime, $this->startTime, "utime") .
	" ms for its computations\nIt spent " . $this->runTime($this->endTime, $this->startTime, "stime") .
	" ms in system calls\n";
	}

	public static function go()
	{
		$start_time = microtime(true); 
		$a=1; 
		// Start loop 
		for($i = 1; $i <=1000; $i++) 
		{ 
			$a++; 
		}  
		// End clock time in seconds 
		$end_time = microtime(true); 
		
		// Calculate script execution time 
		$execution_time =($end_time - $start_time) /60;
		
		echo " Script execution time: ".$execution_time." sec";

		
	}

	

}