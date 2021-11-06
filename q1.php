<?php
# Illustrates a query with a browser input value
#  and returns several rows of values using MySQL
print ("<br>");
$inprno = isset($_POST['inprno']) ? $_POST['inprno'] : '';
$visited = isset($_POST['visited']) ? $_POST['visited'] : '';
$inprnomsg = '';

if (!($inprno )) {
  if ($visited) {	  
     $inprnomsg = 'Please enter a rep number value';
  }

 // printing the form to enter the user input
 print <<<_HTML_
 <FORM method="POST" action="{$_SERVER['PHP_SELF']}">
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
 <font color= 'red'>$inprnomsg</font><br>
 Rep Number: <input type="text" name="inprno" size="9" value="$inprno">
 <br/>
 <br>
 <INPUT type="submit" value=" Submit ">
 <INPUT type="hidden" name="visited" value="true">
 </FORM>
_HTML_;
 
}
else {
  $host = "localhost";
  $user="root";
  $password="";
  $dbname = "premiere";
  $con=mysqli_connect($host, $user, $password, $dbname);
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MariaDB: " . mysqli_connect_error();
    exit;
  }
  $querystring1 = "select firstname, lastname from rep where repnum = $inprno";
  $result1 = mysqli_query($con, $querystring1);
  print("Rep number: $inprno <br><br>");
  
  if (!$result1) {
    print ( "Could not successfully run query ($querystring1) from DB: " . mysqli_error($con) . "<br>");
    exit;
  }

  if (mysqli_num_rows($result1) == 0) {
    print ("No results found, nothing to print so am exiting<br>");
    exit;
  }

  print("Full Name: ");
  while ($row = mysqli_fetch_assoc($result1)) {
    foreach ($row as $col) {
	  print $col." ";
	}
	print "<br><br>";
  }
  
  print("Number of customers: ");
  $querystring2 = "select count(*) from customer where repnum = $inprno";
  $result2 = mysqli_query($con, $querystring2);
  while ($row = mysqli_fetch_assoc($result2)) {
    foreach ($row as $col) {
	  print $col." ";
	}
	print "<br>";
  }
  print "<br>";
  
  print("Customer Names: <br>");
  $querystring3 = "select customername from customer where repnum = $inprno";
  $result3 = mysqli_query($con, $querystring3);
  while ($row = mysqli_fetch_assoc($result3)) {
    foreach ($row as $col) {
	  print $col." ";
	}
	print "<br>";
  }
  print "<br>";
  
  print("Average balance of customers: ");
  $querystring4 = "select avg(balance) from customer where repnum = $inprno";
  $result4 = mysqli_query($con, $querystring4);
  while ($row = mysqli_fetch_assoc($result4)) {
    foreach ($row as $col) {
	  print ("$".round($col, 2)." ");
	}
	print "<br>";
  }
  print "<br>";
  
  mysqli_close($con);
}
?>
