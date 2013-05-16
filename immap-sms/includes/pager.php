<?php
class Pager
{
	////
	////	public variables
	////
	// Basic qry to get total no of rows	
	public 		$baseQry			= 	NULL;
	
	// Containing rows shown per page
	public 		$pageEnd 			= 	NULL;
	
	// Containing set to be shown
	public 		$pageSet 			= 	NULL;
	
	// Containing value of the next page
	// values should be given starting with '&'
	public 		$pageParam 			= 	NULL;
	
	// Containing all kinds of errors
	public 		$pageError	 		= 	NULL;
	
	////
	////	private variables
	////
	// Start value of the page 
	private 	$pageStart 			= 	NULL;
	
	// Containing total no of rows
	private 	$allRows 			= 	NULL;
		
	// Start value of set in the user value
	private 	$returnStart 		= 	NULL;
	
	// Containing value of the previous page
	private 	$pagePrev 			= 	NULL;
	
	// Containing total no of pages
	private 	$totalPageNo 		= 	NULL;
	
	// Containing value of the next page
	private 	$pageNext 			= 	NULL;
	
	/*
	$page->pageEnd = 15;	//setting length of the row shown per page
	$page->pageSet = 10;	//set of pageing shown in paging
	
	// assigning query for paging
	$page->baseQry = "SELECT * FROM tbl_titles ORDER BY disk_no ASC";
	
	// calling the function getPageQry 
	$qry = $page->getPagingQry();
	
	// running the result qry to display records
	$rsMsg = mysql_query($qry);
	
	// if want to add parameter, add them of keep them empty
	$page->pageParam ="mobile_no=".$_REQUEST['mobile_no'];
	// then calling paging function
	$page->getPaging();
	*/
	
	// CONSTRUCTOR
	// Setting the default vaue of set and end value
	function Pager()
	{
		$this->pageSet	= 10;
		$this->pageEnd	= 15;
	}// End of Pager()
	
	
	
	//executing query and returing the start limit value
	function getPagingQry()
	{
		//$this->baseQry ="select * from help_category";
		if ($this->baseQry != NULL)
		{
			$rs = pg_query($this->baseQry);
			if (!empty($rs))
			{
				$this->allRows = pg_num_rows($rs);
						
				if (isset($_REQUEST['pagenum']))
					$this->pageStart = $_REQUEST['pagenum'];
				else
					$this->pageStart = 1;
				
				$this->returnStart =(($this->pageStart-1) * $this->pageEnd);
				
				$this->baseQry = $this->baseQry." limit $this->pageEnd offset $this->returnStart";

				return $this->baseQry;
			}
			else
				$this->pageError = "Error Query : ".mysql_error();
		}
		else
			$this->pageError =  "Error: Please select Query first <br />";
	}// End of getPagingQry()
	
	
	function getPagingQryNew()
	{
		//$this->baseQry ="select * from help_category";
		if ($this->baseQry != NULL)
		{
			$rs = mysql_query($this->baseQry);
			if (!empty($rs))
			{
				$this->allRows = mysql_num_rows($rs);
						
				if (isset($_REQUEST['pagenum']) && !isset($_REQUEST['find']))
					$this->pageStart = $_REQUEST['pagenum'];
				else
					$this->pageStart = 1;
				
				$this->returnStart =(($this->pageStart-1) * $this->pageEnd);
				
				$this->baseQry = $this->baseQry." limit $this->returnStart,$this->pageEnd";

				return $this->baseQry;
			}
			else
				$this->pageError = "Error Query : ".pg_last_error();
		}
		else
			$this->pageError =  "Error: Please select Query first <br />";
	}// End of getPagingQry()
	
	
	// showing all the paging
	function getPaging()
	{
		if ($this->baseQry != NULL)
		{
			// starting table
			echo '<table width="10" border="0" cellpadding="2" cellspacing="6">
							<tr>';
							
			// getting the total no of values
			$this->totalPageNo = ceil($this->allRows/$this->pageEnd);
			
			// previous page
						$this->pagePrev  = $this->pageStart -1;
						
			//echo $rows." ".$end;
			// if on the first page then NO Previous link 
			// else	Previous link will be shown
			if ($this->pagePrev  <= 0)
				echo "";
			else
			{
				if ($this->pageParam == "")
					echo "<td  align='center'><a href='$_SERVER[PHP_SELF]?pagenum=".$this->pagePrev."' class='txt2'>PREV</a></td>";	
				else
					echo "<td align='center'><a href='$_SERVER[PHP_SELF]?pagenum=".$this->pagePrev."&".$this->pageParam."' class='txt2'>PREV</a></td>";	
			}	
			
			// this sets the value to 1 when the page is loadded first time
			if (!isset($_SESSION['set_val']))
				$_SESSION['set_val'] = 1;
				
			// check the session value if it is on the first set or not
			if ($_SESSION['set_val'] != ceil($this->pageStart/$this->pageSet))
				$_SESSION['set_val'] = ceil($this->pageStart/$this->pageSet);
				
			// setting value of start and the end of the for loop
			$first = ($_SESSION['set_val'] * $this->pageSet)-($this->pageSet-1);
			$last = ($_SESSION['set_val'] * $this->pageSet);
			
			// if the last value in greater than no of pages then change last value
			if ($last > $this->totalPageNo )
				$last = $this->totalPageNo ;
				
			//printing value number of pages with current page link disable	
			for ($j = $first ; $j<= $last ; $j++)
			{
				if ($this->pageStart == $j)
					echo "<td  align='center' class='text2_'><strong>".$j."</strong></td>";
				else
				{
					if ($this->pageParam == "")
						echo "<td  align='center'><a href='$_SERVER[PHP_SELF]?pagenum=$j' class='txt2'>".$j."</a></td>";
					else
						echo "<td  align='center'><a href='$_SERVER[PHP_SELF]?pagenum=$j"."&".$this->pageParam."' class='txt2'>".$j."</a></td>";
				}
			}
			
			// setting the next value 
			// if on the last page then NO Next link
			// else print Next link
			$this->pageNext = $this->pageStart +1;
			if ($this->pageNext > $this->totalPageNo  )
				echo '';
			else
			{
				if ($this->pageParam == "")
					echo "<td  align='center'><a class='txt2' href='$_SERVER[PHP_SELF]?pagenum=".$this->pageNext."'>NEXT</a></td>";
				else
					echo "<td  align='center'><a href='$_SERVER[PHP_SELF]?pagenum=".$this->pageNext."&".$this->pageParam."' class='txt2'>NEXT</a></td>";
			}	
			
			// ending table
			echo '</tr>
				</table>';	
		}
		else
			$this->pageError =  "Error: Please select Query first <br />";
	}// End of getPaging()
	
	
	
	
	function getPageInfo()
	{
		// getting the total no of values
		$total = ceil($this->allRows/$this->pageEnd);
		
		// currnts page
		$current  = $this->pageStart ;
		
		echo "Page ".$current." of ".$total;
	}
  	/////////////////////////////
	// getPagingNext
  function getPagingNext()
	{
		if ($this->baseQry != NULL)
		{
			$output = "";
			// starting table
			$output .= '<table width="10" border="0" cellpadding="0" cellspacing="0">
							<tr>';
							
			// getting the total no of values
			$this->totalPageNo = ceil($this->allRows/$this->pageEnd);
			
			// previous page
					
					//comment//	
					//$this->pagePrev  = $this->pageStart -1;
						
			//echo $rows." ".$end;
			// if on the first page then NO Previous link 
			// else	Previous link will be shown
			
			//comment//
			/*if ($this->pagePrev  <= 0)
				echo "";
			else
			{
				if ($this->pageParam == "")
					echo "<td  align='center'><a href='$_SERVER[PHP_SELF]?pagenum=".$this->pagePrev."' class='text2'>PREV</a></td>";	
				else
					echo "<td align='center'><a href='$_SERVER[PHP_SELF]?pagenum=".$this->pagePrev."&".$this->pageParam."' class='text2'>PREV</a></td>";	
			}	*/
			
			// this sets the value to 1 when the page is loadded first time
			if (!isset($_SESSION['set_val']))
				$_SESSION['set_val'] = 1;
				
			// check the session value if it is on the first set or not
			if ($_SESSION['set_val'] != ceil($this->pageStart/$this->pageSet))
				$_SESSION['set_val'] = ceil($this->pageStart/$this->pageSet);
				
			// setting value of start and the end of the for loop
			$first = ($_SESSION['set_val'] * $this->pageSet)-($this->pageSet-1);
			$last = ($_SESSION['set_val'] * $this->pageSet);
			
			// if the last value in greater than no of pages then change last value
			if ($last > $this->totalPageNo )
				$last = $this->totalPageNo ;
				
			//printing value number of pages with current page link disable	
			
			
			// setting the next value 
			// if on the last page then NO Next link
			// else print Next link
			$this->pageNext = $this->pageStart +1;
			if ($this->pageNext > $this->totalPageNo  )
				//echo '';
				$output .= "<td  align='center' class='text2' style='color:#000000;'>NEXT</td>";
			else
			{
				if ($this->pageParam == "")
					$output .= "<td  align='center'><a class='text2' href='".FULL_PATH."search/".$this->pageNext."'>NEXT</a></td>";
				else
					$output .= "<td  align='center'><a href='".FULL_PATH."search/".$this->pageNext."&".$this->pageParam."' class='text2'>NEXT</a></td>";
			}	
			
			// ending table
			$output .= '</tr>
				</table>';	
				
		   return $output;
		}
		else
			$this->pageError =  "Error: Please select Query first <br />";
	}// End of getPagingNext()
	///////////////////////////////////////
	/////////////////////////////
	// getPagingPrev
  function getPagingPrev()
	{
		if ($this->baseQry != NULL)
		{
			$output ="";
			// starting table
			$output .= '<table width="10" border="0" cellpadding="0" cellspacing="0">
							<tr>';
							
			// getting the total no of values
			$this->totalPageNo = ceil($this->allRows/$this->pageEnd);
			
			// previous page
					
					
				$this->pagePrev  = $this->pageStart -1;
						
			//echo $rows." ".$end;
			// if on the first page then NO Previous link 
			// else	Previous link will be shown
			
			//comment//
			if ($this->pagePrev  <= 0)
				$output .= "<td  align='center' class='text2' style='color:#000000;'>PREV</a></td>";	
			else
			{
				if ($this->pageParam == "")
					$output .= "<td  align='center'><a href='#' class='text2'>PREV</a></td>";	
				else
					$output .= "<td align='center'><a href='#' class='text2'>PREV</a></td>";	
			}	
			
			// this sets the value to 1 when the page is loadded first time
			if (!isset($_SESSION['set_val']))
				$_SESSION['set_val'] = 1;
				
			// check the session value if it is on the first set or not
			if ($_SESSION['set_val'] != ceil($this->pageStart/$this->pageSet))
				$_SESSION['set_val'] = ceil($this->pageStart/$this->pageSet);
				
			// setting value of start and the end of the for loop
			$first = ($_SESSION['set_val'] * $this->pageSet)-($this->pageSet-1);
			$last = ($_SESSION['set_val'] * $this->pageSet);
			
			// if the last value in greater than no of pages then change last value
			if ($last > $this->totalPageNo )
				$last = $this->totalPageNo ;
				
			
			
			// ending table
			$output .= '</tr>
				</table>';
			return $output;	
		}
		else
			$this->pageError =  "Error: Please select Query first <br />";
	}// End of getPagingPrev()
	///////////////////////////////////////

	
}
?>