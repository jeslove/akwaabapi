<?php 
namespace core\Utils;

class Utils
{
	public function __construct() {}
 
	public static $UtilsDtStart = [];
	public static $UtilsDtStats = [];
 
	public static function dt()
	{
	   global $UtilsDtStart, $UtilsDtStats;
	   $obj = new \stdClass();
	   $obj->start = function(int $ndx = 0) use (&$UtilsDtStart)
	   {
		  $UtilsDtStart[$ndx] = \microtime(true) * 1000;
	   };
	   $obj->codeStart = function(int $ndx = 0) use (&$UtilsDtStart) {
		  $use = \getrusage();
		  $UtilsDtStart[$ndx] = ($use["ru_utime.tv_sec"] * 1000) + ($use["ru_utime.tv_usec"] / 1000);
	   };
	   $obj->resourceStart = function(int $ndx = 0) use (&$UtilsDtStart) {
		  $use = \getrusage();
		  $UtilsDtStart[$ndx] = $use["ru_stime.tv_usec"] / 1000;
	   };
	   $obj->end = function(int $ndx = 0) use (&$UtilsDtStart, &$UtilsDtStats) {
		  $t = @$UtilsDtStart[$ndx];
		  if($t === null)
			 return false;
		  $end = \microtime(true) * 1000;
		  $dt = $end - $t;
		  $UtilsDtStats[$ndx][] = $dt;
		  return $dt;
	   };
	   $obj->codeEnd = function(int $ndx = 0) use (&$UtilsDtStart, &$UtilsDtStats) {
		  $t = @$UtilsDtStart[$ndx];
		  if($t === null)
			 return false;
		  $use = \getrusage();
		  $dt = ($use["ru_utime.tv_sec"] * 1000) + ($use["ru_utime.tv_usec"] / 1000) - $t;
		  $UtilsDtStats[$ndx][] = $dt;
		  return $dt;
	   };
	   $obj->resourceEnd = function(int $ndx = 0) use (&$UtilsDtStart, &$UtilsDtStats) {
		  $t = @$UtilsDtStart[$ndx];
		  if($t === null)
			 return false;
		  $use = \getrusage();
		  $dt = ($use["ru_stime.tv_usec"] / 1000) - $t;
		  $UtilsDtStats[$ndx][] = $dt;
		  return $dt;
	   };
	   $obj->stats = function(int $ndx = 0) use (&$UtilsDtStats) {
		  $s = @$UtilsDtStats[$ndx];
		  if($s !== null)
			 $s = \array_slice($s, 0);
		  else
			 $s = false;
		  return $s;
	   };
	   $obj->statsLength = function() use (&$UtilsDtStats) {
		  return \count($UtilsDtStats);
	   };
	   return $obj;
	}

	
 }