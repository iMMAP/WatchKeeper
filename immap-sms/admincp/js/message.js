// JavaScript Document
/////////////////Update Message Begin/////////////////////////////

function call_messageTxt(p1)
{
	$('success').hide()
	 $('err').hide()
	if(p1 == "")
	{
			$('err').show()
			$('err').innerHTML='Please select keyword!'
			
			document.getElementById("key").focus();
	}
	else
	{
		document.getElementById("Tkey").style.backgroundColor = '';
		$('output').innerHTML = "Processing..." ;
		var keyword=document.getElementById("key").value;
	   var pars= "opr=0&keyword="+keyword + "&sId=" + Math.random();
	   var myajax=new Ajax.Request('../ajax/dml_message.php',{method: 'get', parameters: pars, onComplete: selDMLmessage});
	   return false;
	 
	}
		
}

function selDMLmessage(originalRequest)
 {
  	var res=originalRequest.responseText;
	$('output').innerHTML = res;	 
 }



function DML_Message()
 {
	 $('success').hide()
	  $('err').hide()
	  if (document.getElementById("key").value == "")
		{
			$('err').show()
			$('err').innerHTML='Please select keyword!'
			document.getElementById("key").focus();
		}
	else if (document.getElementById("msg").value == "")
		{
			$('err').show()
			$('err').innerHTML="Message can't be empty!"
			document.getElementById("msg").focus();
		}	
	else
	{
	   //$('all_msg').innerHTML = "Processing..." ;
	   var keyword = document.getElementById("key").value;
	   
	   var msg=document.getElementById("msg").value;
	   var pars= "opr=1&keyword="+keyword+"&msg="+msg +"&sId=" + Math.random();
	  // alert(pars)
	   var myajax=new Ajax.Request('../ajax/dml_message.php',{method: 'get', parameters: pars, onComplete: showDMLmessage});
	   return false;
	 }
 }

function showDMLmessage(originalRequest)
 {
  	var res=originalRequest.responseText;
	$('success').show()
	$('success').innerHTML = res;
	
 }


  /// textfield count functions max 160 char
 

function imposeMaxLength(Object, MaxLen)

{

  return (Object.value.length <= (MaxLen));

}

// to display the text areas length 

function len_display(Object,MaxLen){

    var len_remain = MaxLen-Object.value.length;

    if(len_remain >=0)

	{

    	document.getElementById("chars_left").value=len_remain;

	}

}
 // end text count functions

