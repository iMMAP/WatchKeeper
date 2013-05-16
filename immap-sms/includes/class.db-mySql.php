<?php
class DBConnect
{	
	var $DB_Server;
	var $DB_Username;
	var $DB_Password;
	var $DB_DBName;
	var $success;
	var $pin;
	var $error = "Error :: " ;
	var $sqlQry;
	
	//Database Connection Method
	function DBConnect()
	{
	
		$this->DB_Server = DB_SERVER;
		$this->DB_Username = DB_USERNAME;
		$this->DB_Password = DB_PASSWORD;
		$this->DB_DBName = DB_DBNAME;
		
		$this->success = mysql_pconnect($this->DB_Server, $this->DB_Username, $this->DB_Password);
		mysql_select_db($this->DB_DBName);
		if(!$this->success)
			echo mysql_errno() . ": " . mysql_error() . "<BR>";
			//else
			//echo yes;
	}
	
	//Data Insertion Method
	function Insert($strTable, $arrValue)
	{
		$strQuery = "	insert into $strTable (";
		
		reset($arrValue);
		while(list ($strKey, $strVal) = each($arrValue))
		{
			$strQuery .= $strKey . ",";
		}

		$strQuery = substr($strQuery, 0, strlen($strQuery) - 1);
		$strQuery .= ") values (";

		reset($arrValue);
		while(list ($strKey, $strVal) = each($arrValue))
		{
			$strQuery .= "'" . $this->FixString($strVal) . "',";
		}

		$strQuery = substr($strQuery, 0, strlen($strQuery) - 1);
		 $strQuery .= ");";
	
		//exit($strQuery);
		$this->MySQLQuery($strQuery);
		return mysql_insert_id();
	}
		
	//Method To FIX Quotes
	function FixString($strString)
	{
		/*$strString = str_replace("'", "''", $strString);
		$strString = str_replace("\'", "'", $strString);
		return $strString;*/
		// Stripslashes
	if (get_magic_quotes_gpc())
	  {
	   $strString = stripslashes($strString);
	  }
	// Quote if not a number
	if (!is_numeric($strString))
	  {
	   $strString = "" . mysql_real_escape_string($strString) . "";
	  }
	return $strString;
	}
	
	
	
	//RUNS MySql Query
	function MySQLQuery($strQuery)
	{
		//$this->success = mysql_db_query($this->DB_DBName, $strQuery);
		$this->success = mysql_query($strQuery);
		if(!$this->success)
		{
			//Nothing
			echo mysql_error();
		}
		return $this->success;
	}	
	
	//Data Updatation Method
	function UpdateRec($strTable, $strWhere, $arrValue)
	{
		$strQuery = "	update $strTable set ";

		reset($arrValue);

		while (list ($strKey, $strVal) = each ($arrValue))
		{
			$strQuery .= $strKey . "='" . $this->FixString($strVal) . "',";
		}

		$strQuery = substr($strQuery, 0, strlen($strQuery) - 1);
		$strQuery .= " where $strWhere;";
		
		$this->sqlQry = $strQuery;
	
		//exit($strQuery);
		return $this->MySQLQuery($strQuery);
	}
	
	
	//Data Updatation Method
	function UpdateRec_all($strTable, $strWhere, $arrValue)
	{
		$strQuery = "	update $strTable set ";

		reset($arrValue);

		while (list ($strKey, $strVal) = each ($arrValue))
		{
			$strQuery .= $strKey . "='" . $this->FixString($strVal) . "',";
		}

		$strQuery = substr($strQuery, 0, strlen($strQuery) - 1);
		//$strQuery .= " where $strWhere;";
		
		
		
		//exit($strQuery);
		return $this->MySQLQuery($strQuery);
	}
	
	
	
	
	//Pass Query To Get Records
	function GetRecordByQuery($strQuery)
	{
		$nResult = $this->MySQLQuery($strQuery);
		return mysql_fetch_assoc($nResult);
	}
	
	//run all query
	function RunQuery($strQry)
	{
		$arr = "";
		$rsQry = mysql_query($strQry);
		if(!empty($rsQry))
		{
			if(mysql_num_rows($rsQry) > 0)
			{
				while($rowsQry = mysql_fetch_array($rsQry))
				{
					$arr[] = $rowsQry;
				}
			}
			else
				$this->error .= " Table empty.";
		}
		else
			echo $this->error .= mysql_error();
	return $arr;
	}
	
	
	//run all query
	function RunQueryObj($strQry)
	{
		$arr = "";
		$rsQry = mysql_query($strQry);
		if(!empty($rsQry))
		{
			if(mysql_num_rows($rsQry) > 0)
			{
				while($rowsQry = mysql_fetch_object($rsQry))
				{
					$arr[] = $rowsQry;
				}
			}
			else
				$this->error .= " Table empty.";
		}
		else
			echo $this->error .= mysql_error();
	return $arr;
	}
	
	//run single query
	function RunQuerySingle($strQry)
	{
		$arr = "";
		$rsQry = mysql_query($strQry);
		if(!empty($rsQry))
		{
			if(mysql_num_rows($rsQry) > 0)
			{
				$rowsQry = mysql_fetch_array($rsQry);
					$arr = $rowsQry;
			}
			else
				$this->error .= " Table empty.";
		}
		else
			echo $this->error .= mysql_error();
	return $arr;
	}
	
	//run single query
	function RunQuerySingleObj($strQry)
	{
		$arr = "";
		$rsQry = mysql_query($strQry);
		if(!empty($rsQry))
		{
			if(mysql_num_rows($rsQry) > 0)
			{
				$rowsQry = mysql_fetch_object($rsQry);
					$arr = $rowsQry;
			}
			else
				$this->error .= " Table empty.";
		}
		else
			echo $this->error .= mysql_error();
	return $arr;
	}
	
	//run query fetch rows
	function RunQueryRow($strQry)
	{
		$arr = 0;
		$rsQry = mysql_query($strQry);
		if(!empty($rsQry))
			$arr =mysql_num_rows($rsQry);
		else
			$this->error .= mysql_error();
	return $arr;
	}
	
	
	//Delete Record
	function deleteRecord($tbl,$field_id,$id)
	{
		$msg = 0;
		$sql = "DELETE FROM $tbl where $field_id = $id";
		
		if(mysql_query($sql))
			$msg = 1;
		else
			$this->error .= mysql_error();
		return $msg;
	}
	
	
//ACTIVATE USER(S)
   function ActivateUser($arr,$tbl)
	{
		if($arr != "" && !empty($arr) )
		{
			foreach($arr as $id)
			{
				
				$sql = mysql_query("UPDATE ".$tbl." SET status=1 WHERE id=".$id);
			}
		}
		else
		{
			echo '<script language="JavaScript">';
			echo ' alert("Please select values first then press Activate");';
			echo '</script>';
		}
		
	}
	
	//DEACTIVATE USER(S)
	function DeActivateUser($arr,$tbl)
	{
		
		if($arr != "" && !empty($arr) )
		{
			foreach($arr as $id)
			{
				//echo $S = "UPDATE $tbl SET status=0 WHERE id=$id";
				//exit;
				$sql = mysql_query("UPDATE $tbl SET status=0 WHERE id=$id");
			}
		}
		else
		{
			echo '<script language="JavaScript">';
			echo ' alert("Please select values first then press Deactivte");';
			echo '</script>';
		}
				
	}
		
	
}
?>
