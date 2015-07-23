<?PHP

$msg = Null;
$mail = NULL;
$body = NULL;
$name = NULL;
$From = NULL;
$to = NULL;
$title = NULL;
$comments = NULL;

if (isset($_POST['Submit']))
{
include('./PHPMailer/class.phpmailer.php');

$mail = new PHPMailer();

$from_name = $_POST[from_name];
$from_addr = strtolower($_POST[from_addr]);
$title = $_POST[title];
$comments = nl2br($_POST[comments]);

$title = eregi_replace("[\]",'',$title);
$comments = eregi_replace("[\]",'',$comments);

if (strlen($comments) == 0)
{
$msg .= "You must type someting in the Comments section. <br>";
}
else
{
$body = "$comments";

}

if (strlen($from_addr) == 0)
{
$msg .= "Enter your email!<br>";
}
elseif (isset($from_addr))
{
$int = (ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $from_addr));
if ($int == 0)
{
$msg .= "Invalid Email! Please include a @ and use a .com, .org or .Country(ie .au, .tr) type address<br>";
}
else
{
$mail->From = "$from_addr";
}
}


if(strlen($from_name) == 0)
{
$msg .= "Enter your Name!<br>";
}
else
{
$mail->FromName = $from_name;
}

if(strlen($title) == 0)
{
$msg .= "Enter a Title.<br>";
}
else
{
$mail->Subject = "Article Submission - ".$title;
}

$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

$mail->AddAddress("editor@XYZ.com", "Editor");
// Add Attachment 1
if (isset($_FILES['attachment1']))
{
if ($_FILES['attachment1']['size'] > "500000")
{
$msg .= "<b>Attachment #1 is greater that 500k.</b> <br>";
}
if (strlen($msg) == 0)
{
$file1_path = $_FILES['attachment1']['tmp_name'];
$file1_name = $_FILES['attachment1']['name'];
$file1_type = $_FILES['attachment1']['type'];
$file1_error = $_FILES['attachment1']['error'];
$mail->AddAttachment($file1_path, $Subject . "_" . $file1_name); // optional name
}
}
// Add Attachment 2
if (isset($_FILES['attachment2']))
{
if ($_FILES['attachment2']['size'] > "500000")
{
$msg .= "<b>Attachment #2 is greater that 500k.</b> <br>";
}
if (strlen($msg) == 0)
{
$file2_path = $_FILES['attachment2']['tmp_name'];
$file2_name = $_FILES['attachment2']['name'];
$file2_type = $_FILES['attachment2']['type'];
$file2_error = $_FILES['attachment2']['error'];
$mail->AddAttachment($file2_path, $Subject . "_" . $file2_name); // optional name
}
}

// Add Attachment 3
if (isset($_FILES['attachment3']))
{
if ($_FILES['attachment3']['size'] > "500000")
{
$msg .= "<b>Attachment #3 is greater that 500k.</b> <br>";
}
if (strlen($msg) == 0)
{
$file3_path = $_FILES['attachment3']['tmp_name'];
$file3_name = $_FILES['attachment3']['name'];
$file3_type = $_FILES['attachment3']['type'];
$file3_error = $_FILES['attachment3']['error'];
$mail->AddAttachment($file3_path, $Subject . "_" . $file3_name); // optional name
}
}

if(strlen($msg) == 0)
{

if(!$mail->Send())
{
$msg = "<font color=\"#CC0000\" size=\"3\" face=\"Arial, Helvetica, sans-serif\"><b>Mailer Error: </b></font>" . $mail->ErrorInfo;
}
else
{
$msg = "<font color=\"#CC0000\" size=\"3\" face=\"Arial, Helvetica, sans-serif\"><b>Thank You</font>
<br><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Your article was sent to the Editor.</b> <form><input type=\"button\" value=\"Close Window\" onClick=\"window.close()\"></form>";
$body = NULL;
$from_name = NULL;
$from_addr = NULL;
$to = NULL;
$title = NULL;
$comments = NULL;

}
}
}

?>