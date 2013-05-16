<?php
class DBConnect
{	
	var $connstr;
	
	var $success;
	var $pin;
	var $error = "Error :: " ;
	var $sqlQry;
	
	//Database Connection Method
	function DBConnect()
	{
	
		$this->connstr = CONNSTR;
		$this->success = pg_connect($this->connstr);
		
		if(!$this->success)
				echo "Error in connection<BR>";
		
	}
	
	function DB_close()
	 {
		 pg_close($this->success);
		 
	 }
	//Data Insertion Method
	function Insert($strTable, $arrValue)
	{
			
		$res = "";	
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
		 $res = $this->MySQLQuery($strQuery);
		
		return $res;
	
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
	   $strString = "" . pg_escape_string($strString) . "";
	   
	  }
	return $strString;
	}
	
	
	
	//RUNS MySql Query
	function MySQLQuery($strQuery)
	{
		//$this->success = mysql_db_query($this->DB_DBName, $strQuery);
		$this->success = pg_query($strQuery);
		if(!$this->success)
		{
			//Nothing
			echo "Error in Query";
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
		
		$rsQry = pg_query($strQry);
		if(!empty($rsQry))
		{
			if(pg_num_rows($rsQry) > 0)
			{
				while($rowsQry = pg_fetch_array($rsQry))
				{
					$arr[] = $rowsQry;
				}
			}
			else
				$this->error .= " Table empty.";
		}
		else
			$this->error .=  "Error in RunQuery";
	return $arr;
	}
	
	//run all query
	function RunQueryObj($strQry)
	{
		$arr = "";
		
		
		 $rsQry = pg_query($strQry);
		
		if(!empty($rsQry))
		{
			if(pg_num_rows($rsQry) > 0)
			{
				while($rowsQry = pg_fetch_object($rsQry))
				{
					$arr[] = $rowsQry;
				}
			}
			else
				$this->error .= " Table empty.";
		}
		else
			$this->error .= "Error in RunQueryObj";
	return $arr;
	}
	
	//run single query
	function RunQuerySingle($strQry)
	{
		$arr = "";
		$rsQry = pg_query($strQry);
		if(!empty($rsQry))
		{
			if(pg_num_rows($rsQry) > 0)
			{
				$rowsQry = pg_fetch_array($rsQry);
					$arr = $rowsQry;
			}
			else
				$this->error .= " Table empty.";
		}
		else
			echo $this->error .= "Error in RunQuerySingle";
	return $arr;
	}
	
	//run single query
	function RunQuerySingleObj($strQry)
	{
		$arr = "";
		
		$rsQry = pg_query($strQry);
		if(!empty($rsQry))
		{
			if(pg_num_rows($rsQry) > 0)
			{
				$rowsQry = pg_fetch_object($rsQry);
					$arr = $rowsQry;
			}
			else
				$this->error .= " Table empty.";
		}
		else
			echo $this->error .= "Error in RunQuerySingleObj";
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
	
	
	
	

	
}
?>
