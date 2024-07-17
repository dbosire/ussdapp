<?php  
  
//for africastalking  
//$phonenumber = $_GET['MSISDN'];  
//$sessionID = $_GET['sessionId'];  
//$servicecode = $_GET['serviceCode'];  
//$ussdString = $_GET['text'];  

$phonenumber = $_GET['MSISDN'];  
$sessionID =$_GET['SERVICE_CODE'];  
$servicecode = $_GET['SESSION_ID'];  
$ussdString = $_GET['USSD_STRING'];

include("connect.php");
  
//create data fields  
$regNo="";  
$fName="";  
$lName="";  
$gender="";  
$genderV="";  
$pass="";  
$acceptDeny="";  
  
$username="";  
$password="";  
$year="";  
$semester="";  
  
//N/B: on going live we will change the GET[] method to POST[] (that is how africastalking do their stuff)  
$level =0;  
  
if($ussdString != ""){  
$ussdString=  str_replace("#", "*", $ussdString);  
$ussdString_explode = explode("*", $ussdString);  
$level = count($ussdString_explode);  
}
if ($level==0){  
//displaymenu($phonenumber); 
 $ussd_text="END You are not using shared shortcode: *xxx*xx# Thank you." ;
 ussd_proceed($ussd_text);
 
}  
if ($level==1){  
displaymenu($phonenumber);  
}  
function displaymenu($phonenumber){  
$ussd_text="CON Welcome to DENCOM. Please reply with; \r\n 1. Register \r\n 2. Login1 \r\n 3. SDP";  
ussd_proceed($ussd_text);  
}  
function ussd_proceed ($ussd_text){  
echo $ussd_text;  
//exit(0);  
}  
if ($level>0){  
switch ($ussdString_explode[1])  
{  
case 1:  
register($ussdString_explode,$phonenumber);  
break;  
case 2:  
login($ussdString_explode,$phonenumber);  
break;  
case 2:  
SDP($ussdString_explode,$phonenumber);  
break; 
}  
}  
function register($details,$phone){  
  
if (count($details)==1){  
$ussd_text="CON Enter your registration number (Username)";  
ussd_proceed($ussd_text);  
}  
else if (count($details)==2){  
$ussd_text="CON Enter your first name";  
ussd_proceed($ussd_text);  
}  
else if(count($details) == 3){  
$ussd_text = "CON  Enter your last name";  
ussd_proceed($ussd_text);  
}  
else if(count($details) == 4){  
  
$ussd_text = "CON Select gender  \r\n 1. To select male \r\n 2. To select female ";  
ussd_proceed($ussd_text);  
}else if(count($details) == 5){  
  
$ussd_text = "CON set your password";  
ussd_proceed($ussd_text);  
}else if(count($details) == 6){  
$ussd_text = "CON \r\n 1. Accept registration \r\n 2. Cancel ";  
ussd_proceed($ussd_text);  
}else if(count($details) == 7){  
$regNo=$details[1];  
$fName=$details[2];  
$lName=$details[3];  
$genderV=$details[4];  
$pass=$details[5];  
$acceptDeny=$details[6];  
  
if($genderV=="1"){  
$gender="Male";  
}else if($genderV=="2"){  
$gender="Female";  
}  
if($acceptDeny=="1"){  
//=================Do your business logic here===========================  
//Remember to put "END" at the start of each echo statement that comes here  
echo "END Details that will be pushed to the database. \r\n Registration number: " . $regNo . "\r\n" .  
"Name: " . $fName. " " . $lName . "\r\n" .  
"Gender: " . $gender . "\r\n" .  
"Password (Encrypted): " . md5($pass) . "\r\n"; 
$pswd=md5($pass);

$query = mysql_query("select * from subreg where phonenumber='$phone'");
$rows = mysql_num_rows($query);
if ($rows == 0) {

mysql_query("INSERT INTO subreg (phonenumber,regnumber,firstname,lastname,gender,password,datetime) VALUES('$phone','$regNo','$fName','$lName','$gender', '$pswd',NOW())");
}
else
{
	$ussd_text = "END The record exists!";  
ussd_proceed($ussd_text); 
}
  
  
}else{//Choice is cancel  
$ussd_text = "END Your session is over";  
ussd_proceed($ussd_text);  
}  
  
  
}  
}  
  
function login($details,$phone){  
if (count($details)==2){  
$ussd_text="CON Enter your Username (registration number)";  
ussd_proceed($ussd_text);  
}  
else if (count($details)==3){  
$ussd_text="CON  Enter your password";  
ussd_proceed($ussd_text);  
}  
else if(count($details) == 4){  
$ussd_text = "CON  Select your year of study \r\n 1. For year 1 \r\n 2. For year 2 \r\n 3. For year 3";  
ussd_proceed($ussd_text);  
}  
else if(count($details) == 5){  
  
$ussd_text = "CON  Select semister \r\n 1. For semister 1 \r\n 2. For semester 2 \r\n";  
ussd_proceed($ussd_text);  
  
}else if(count($details) == 6){  
$username=$details[1];  
$password=$details[2];  
$year=$details[3];  
$semester=$details[4];  
echo "We are fetching your exam results using this information \r\n 
Username: " . $username . "\r\n" .  
"Password (Encrypted): " . md5($password) . "\r\n" .  
"Year: " . $year. "\r\n" .  
"Semester: " . $semester;  
}  
}  

function SDP($details,$phone){  
if (count($details)==2){  
$ussd_text="SDP|690907|5090|sub";  
ussd_proceed($ussd_text);  
}  
 
}  
?>  