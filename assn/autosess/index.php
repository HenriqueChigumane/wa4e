<!DOCTYPE html>
<?php
require_once("../assn_util.php");
$json = loadPeer("peer.json");
?>
<html>
<head>
<title>Assignment: <?= $json->title ?></title>
<style>
li { padding: 5px; }
pre {padding-left: 2em;}
</style>
</head>
<body style="margin-left:5%; margin-bottom: 60px; margin-right: 5%; font-family: sans-serif;">
<h1>Assignment: <?= $json->title ?></h1>
<p>
<?= $json->description ?>
</p>
<p>
<center>
<a href="01-Autos.png" target="_blank">
<img 
alt="Image of the auto management application"
width="300px" src="01-Autos.png" border="2"/>
</a>
</center>
<p>
Note that there is no specific sample code for this assignment.
</p>
<?php if ( isset($json->solution) ) { ?>
<h2>Sample solution</h2>
<p>
You can explore a sample solution for this problem at
<pre>
<a href="<?= $json->solution ?>" target="_blank"><?= $json->solution ?></a>
</pre>
<?php } ?>
<h1>Resources</h1>
<p>There are several resources you might find useful:
<ul>
<li>Recorded lectures, sample code and chapters from 
<a href="http://www.php-intro.com" target="_blank">www.php-intro.com</a>:
<ul>
<li class="toplevel">
Review the SQL language
</li>
<li class="toplevel">
Using PDO in PHP
</li>
</li>
</ul>
</li>
<li>Documentation on 
<a href="https://en.wikipedia.org/wiki/Post/Redirect/Get" target="_new">Post-Redirect-GET Pattern</a>
</li>
<li>
You can look though the sample code from the lecture. It has examples
of using sessions and POST-Redirect.
<pre>
<a href="http://www.php-intro.com/code/sessions.zip" target="_blank">http://www.php-intro.com/code/sessions.zip</a>
</pre>
</li>
</ul>
</p>
<h2 clear="all">General Specifications</h2>
<p>
Here are some general specifications for this assignment:
<ul>
<li>
You <b>must</b> use the PHP PDO database layer for this assignment.  If you use the 
"mysql_" library routines or "mysqli" routines to access the database, you will
<b>receive a zero on this assignment</b>.
<li>
Your name must be in the title tag of the HTML for all of the pages
for this assignment.
</li>
<li>
Your program must be resistant to HTML Injection attempts.
All data that comes from the users must be properly escaped
using the <b>htmlentities()</b> function in PHP.  You do not 
need to escape text that is generated by your program.
</li>
<li>
Your program must be resistant to SQL Injection attempts. 
This means that you should never concatenate user provided data 
with SQL to produce a query.  You should always use a PDO prepared statement.
<li>
Please do not use HTML5 in-browser data 
validation (i.e. type="number") for the fields 
in this assignment as we want to make sure you can properly do server 
side data validation.  And in general, even when you do client-side
data validation, you should stil validate data on the server in case
the user is using a non-HTML5 browser.
</li>
</ul>
<h2 clear="all">Databases and Tables Required for the Assignment</h2>
<p>
This assignment reuses the tables from the
<a href="../autosdb">previous assignment</a>.
No additional tables are necessary.
</p>
<h1>Specifications</h1>
<p>
The changes to <b>index.php</b> are new wording and pointing to 
<b>autos.php</b> to test for login bypass.
</p>
<h2>Specifications for the Login Screen</h2>
<p>
The basic functionality, password checking using salt and hashing,
error logging, and data validation for the <b>login.php</b>
is the same as in the
<a href="../autosdb">previous assignment</a>.
<center>
<a href="02-Login.png" target="_blank">
<img 
alt="Image of the login screen"
width="300px" src="02-Login.png" border="2"/>
</a>
</center>
<p>
There are several changes that are needed for this assignment as follows:
<ul>
<li>The script must redirect after every POST.   It must never produce HTML output
as a result of a POST operation.
</li>
<li>It must redirect to <b>view.php</b> instead of <b>autos.php</b> and must pass the
logged in user's name through the session.  A GET parameter is not allowed.
<pre>
// Redirect the browser to view.php
$_SESSION['name'] = $_POST['email'];
header("Location: view.php");
return;
</pre>
</li>
<li>All error messages must be passed between the POST and GET using the session
and "flash message" pattern:
<pre>
$_SESSION['error'] = "Email must have an at-sign (@)";
header("Location: login.php");
return;
</pre>
The error message must be displayed only on the next GET request.  
propertly implement the POST-Redirect-GET-Flash pattern.
<pre>
if ( isset($_SESSION['error']) ) {
    echo('&lt;p style="color: red;">'.htmlentities($_SESSION['error'])."&lt;/p>\n");
    unset($_SESSION['error']);
}
</pre>
Subsequent GET 
requests (i.e. refreshing the page) should <b>not</b> show the error message to 

</li> 
</ul>
<h2>Specifications for the Auto Database Screens</h2>
<p>
The <b>autos.php</b> script is broken into two scripts. The <b>view.pbp</b> script
shows the list of automobiles in the database and the <b>add.php</b> script 
handles adding new automobiles to the database but does not list any autos.  
The <b>view.pbp</b> includes a link to <b>add.php</b> and <b>logout.php</b>
and the <b>add.php</b> has a <b>Cancel</b> button.
</p>
<p>
<center>
<p><b>The view.php screen</b></p>
<a href="03-View.png" target="_blank">
<img 
alt="Image of the auto management application"
width="300px" src="03-View.png" border="2"/>
</a>
<p><b>The add.php screen</b></p>
<a href="03-Add.png" target="_blank">
<img 
alt="Image of the auto management application"
width="300px" src="03-Add.png" border="2"/>
</a>
</center>
</p>
<p>
In order to protect the database from being modified without the user properly
logging in, the <b>autos.php</b> and <b>add.php</b> must first check the session to see
if the user's name is set and if the user's name is not present,
the autos.php must stop immediately using the PHP die() function:
<pre>
if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
}
</pre>
To test, navigate to <b>autos.php</b> manually without logging in - it 
should fail with "Not logged in".
</p>
<p>
In <b>view.php</b> if the <b>Logout</b> button is pressed the user should be redirected back to the 
<b>logout.php</b> page.  The <b>logout.php</b> page should clear the session and immediately 
reditect back to <b>index.php</b>:
<pre>
session_start();
session_destroy();
header('Location: index.php');
</pre>
<p>
In the <b>add.php</b> script, when the "Add" button is pressed, you need to 
the same input validation as in the previus assignment, except that you 
must display the error using a proper POST-ReDirect-GET-Flash pattern.
</p>
In the <b>add.php</b> script, when you successfully add data to your database, 
you need to redirect back to <b>view.php</b> and pass a "success message"
to <b>view.php</b> using the session:
<pre>
$_SESSION['success'] = "Record inserted";
header("Location: view.php");
return;
</pre>
<p>
The <b>view.php</b> must detect and display the success message using the flash pattern:
<pre>
if ( isset($_SESSION['success']) ) {
    echo('&lt;p style="color: green;">'.htmlentities($_SESSION['success'])."&lt;/p>\n");
    unset($_SESSION['success']);
}
</pre>
<center>
<a href="04-Add-Success.png" target="_blank">
<img 
alt="Image of the auto management application"
width="300px" src="04-Add-Success.png" border="2"/>
</a>
</center>
</p>
<h1>What To Hand In</h1>
<p>
For this assignment you will hand in:
<ol>
<?php
foreach($json->parts as $part ) {
    echo("<li>$part->title</li>\n");
}
?>
</ol>
</p>
<h2>Grading</h2>
<p>
<?= $json->grading ?>
</p>
<p>
<?= pointsDetail($json) ?>
</p>
<h2>Sample Screen Shots</h2>
<p>
Some of the screenshots ask to see the developer console demonstrating the 
POST-Redirect pattern similar to the following:
<p>
<center>
<img alt="Image of a POST-Redirect pattern in the developer console" style="width: 95%"
src="05-POST-Redirect.png" border="2"/>
</center>
</p>
<p>
Provided by: <a href="http://www.php-intro.com/" target="_blank">
www.php-intro.com</a> <br/>
</p>
<center>
Copyright Creative Commons Attribution 3.0 - Charles R. Severance
</center>
</body>
</html>
