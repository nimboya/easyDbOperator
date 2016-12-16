<?php
/* 
Developer/Designer: Diagboya Ewere
Date Started: 18, July 2013, 1:01PM v0.1
Location: Edo Staff Training Centre
Date Updated: 01, July 2014, 6:43AM v0.2
Location: At Home
Date Updated: 09, Dec 2016, 9:27AM v0.3
Location: At Home
File Description: To Make Database Operation a Bit Easier to Write
General Database Operation
*/
// Class for DB Operations
class Db
{
	var $dbhost = "localhost";
	var $dbusername = "phincorp_wop";
	var $dbname = "phincorp_wop";
	var $dbpassword = "app@siteadmin#1";
	
	public function getdbname()
	{
		return $this->dbname;
	}
	
	public function dbconnect()
	{	
		$link = mysqli_connect($this->dbhost,$this->dbusername, $this->dbpassword, $this->getdbname());
		return $link;
	}
	
	// For Recording Database Error Logs
	public function ErrorLog($content)
	{
		$file = 'errorlog.txt';
		$current = file_get_contents($file);
		$current .= $content."\n";
		file_put_contents($file, $current);
	}
	
	// General Insert Method
	public function InsertOpt($tablename, $fields, $values)
	{	
		$status = "";
		$field = implode("`,`", $fields);
		$value = implode("','", $values);
		$instq = "INSERT INTO " . $tablename . "(`" . $field . "`) VALUES ('" . $value . "')";
		
		$runq = mysqli_query($this->dbconnect(),$instq);
		
		// Possible Scenarios
		# Inserted Successfully
		if ($runq == true)
		{
			$status = "OK";
		}
		// Specific Error
		else if ($runq == false)
		{
			$this->ErrorLog("ERROR: " . mysqli_error($this->dbconnect()));
			$status = "ERROR: " . mysqli_error($this->dbconnect());	
		}
		// Unknown Error
		else
		{
			$this->ErrorLog("ERROR: " . mysqli_error($this->dbconnect()));
			$status = mysqli_error($this->dbconnect());
		}
		
		return $status;
	}
	
	// Update Method
	public function Update($query, $tablename)
	{
		$status = "";
		$runq = mysqli_query($this->dbconnect(), "UPDATE $tablename ". $query) or die($this->ErrorLog("ERROR: ".mysqli_error($this->dbconnect())));
		// Possible Scenarios		
		if($runq === true) { $status = "OK"; }
    	// Specific Error
		else if ($runq === false) { $status = "ERROR: " . mysql_error(); }
		// Unknown Error
		else { $status = mysql_error(); }	
		return $status;
	}
	
	public function Retrieve($query)
	{
		$runq = mysqli_query($this->dbconnect(), $query) or die($this-ErrorLog("ERROR: ".mysqli_error($this->dbconnect())));
		while($getdata = mysqli_fetch_array($runq)) {
			$datarray[] = $getdata;
		}
		//echo json_encode($datarray);
		
		//die();
		return $datarray;
	}
	
	public function Delete($query, $tablename)
	{
		$status = "";
		$runq = mysqli_query($this->dbconnect(), "DELETE FROM $tablename WHERE ".$query) or die($this-ErrorLog("ERROR: ".mysqli_error($this->dbconnect())));
		// Possible Scenarios		
		if($runq == true) { $status = "OK"; }
    	// Specific Error
		else if ($runq == false) { $status = "ERROR: " . mysql_error(); }
		// Unknown Error
		else { $status = mysql_error(); }	
		return $status;
	}
	
	public function Login($username, $password) {
		$runq = "";
	}
}
?>
