<?php
/* 
Developer/Designer: Diagboya Ewere
Date Started: 18, July 2013, 1:01PM v0.1
Location: Edo Staff Training Centre
Date Updated: 01, July 2014, 6:43AM v0.2
Location: At Home
File Description: To Make Database Operation a Bit Easier to Write
General Database Operation
*/
// Class for DB Operations
class Db
{
	var $dbhost = "localhost";
	var $dbusername = "root";
	var $dbname = "your-db-name";
	var $dbpassword = "";
	
	private function getdbname()
	{
		return $this->dbname;
	}
	
	private function dbconnect()
	{	
	mysql_connect($this->dbhost,$this->dbusername, $this->dbpassword);
	mysql_select_db(getdbname());
	}
	
	// For Recording Database Error Logs
	public static function ErrorLog($content)
	{
	$file = 'errorlog.txt';
	$current = file_get_contents($file);
	$current .= $content."\n";
	file_put_contents($file, $current);
	}
	
	// General Insert Method
	public static function InsertOpt($tablename, $fields, $values)
	{	
		$status = "";
		$field = implode("`,`", $fields);
		$value = implode("','", $values);
		$instq = "INSERT INTO " . $tablename . "(`" . $field . "`) VALUES ('" . $value . "')";
		$this->dbconnect();
		$runq = mysql_query($instq) or die("<center><span class='alert alert-error'>Error Occured: " . mysql_error() . "</span></center>");
		// Possible Scenarios
		# Inserted Successfully
		if ($runq === true)
		{
			$status = "OK";
		}
		// Specific Error
		else if ($runq === false)
		{
			$this->ErrorLog("ERROR: " . mysql_error());
			$status = "ERROR: " . mysql_error();	
		}
		// Unknown Error
		else
		{
			$this->ErrorLog("ERROR: " . mysql_error());
			$status = mysql_error();
		}
		
		return $status;
	}
	
	// Update Method
	public static function Update($query, $tablename)
	{
		$status = "";
		$this->dbconnect();
		$runq = mysql_query("UPDATE $tablename". $query) or die($this-ErrorLog("ERROR: ".mysql_error()));
		// Possible Scenarios		
		if($runq === true) { $status = "OK"; }
    	// Specific Error
		else if ($runq === false) { $status = "ERROR: " . mysql_error(); }
		// Unknown Error
		else { $status = mysql_error(); }	
		return $status;
	}
	
	public static function Retrieve($query)
	{
		//$status = "";
		$this->dbconnect();
		$runq = mysql_query($query) or die($this-ErrorLog("ERROR: ".mysql_error()));
		$getdata = mysql_fetch_object($runq);
		return $getdata;
	}
	
	public static function Delete($query, $tablename)
	{
		$status = "";
		$this->dbconnect();
		$runq = mysql_query("DELETE FROM".$query) or die($this-ErrorLog("ERROR: ".mysql_error()));
		// Possible Scenarios		
		if($runq === true) { $status = "OK"; }
    	// Specific Error
		else if ($runq === false) { $status = "ERROR: " . mysql_error(); }
		// Unknown Error
		else { $status = mysql_error(); }	
		return $status;
	}
}
?>
