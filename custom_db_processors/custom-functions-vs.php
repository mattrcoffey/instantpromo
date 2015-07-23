<?php

//Is it a POA quote Request?

$poa_sub_check = $_POST['poa_sub_check'];
$ref_url=@$HTTP_REFERER; 
if ($poa_sub_check == 1)

{
	//Generate random poa reference
	for ($i = 0; $i<6; $i++) 
{
    $poa_reference_rand .= mt_rand(0,12);
	$poa_reference ="IP/".$poa_reference_rand;
}



if ((isset($_POST['name'])) && (strlen(trim($_POST['name'])) > 0)) {
	$name = stripslashes(strip_tags($_POST['name']));
} else {$name = 'No price entered';}
if ((isset($_POST['email'])) && (strlen(trim($_POST['email'])) > 0)) {
	$email = stripslashes(strip_tags($_POST['email']));
} else {$email = 'No name entered';}
if ((isset($_POST['phone'])) && (strlen(trim($_POST['phone'])) > 0)) {
	$phone = stripslashes(strip_tags($_POST['phone']));
} else {$phone = 'No email entered';}
if ((isset($_POST['company'])) && (strlen(trim($_POST['company'])) > 0))
 {	$company = stripslashes(strip_tags($_POST['company']));
} else {$postcode = 'No phone entered';}
if ((isset($_POST['comments'])) && (strlen(trim($_POST['comments'])) > 0)) {
	$comments = stripslashes(strip_tags($_POST['comments']));
} else {$comments = 'No comments entered';}
//if ((isset($_POST['poa-item-name'])) && (strlen(trim($_POST['poa-item-name'])) > 0)) {
//	$poa_item = stripslashes(strip_tags($_POST['poa-item-name']));
//} else {$poa_item = 'No product entered';}
if ((isset($_POST['product_name'])) && (strlen(trim($_POST['product_name'])) > 0)) {
	$product_name = stripslashes(strip_tags($_POST['product_name']));
} else {$product_name = 'No product entered';}
if ((isset($_POST['package_interested'])) && (strlen(trim($_POST['package_interested'])) > 0)) {
	$package_interested = stripslashes(strip_tags($_POST['package_interested']));
} else {$product_interested = 'No product entered';}
if ((isset($_POST['product-size'])) && (strlen(trim($_POST['product-size'])) > 0)) {
	$product_size = stripslashes(strip_tags($_POST['product-size']));
} else {$product_size = '';}
if ((isset($_POST['date-required'])) && (strlen(trim($_POST['date-required'])) > 0)) {
	$date_required = stripslashes(strip_tags($_POST['date-required']));
} else {$date_required = '';}
if ((isset($_POST['referrer'])) && (strlen(trim($_POST['referrer'])) > 0)) {
	$referrer = stripslashes(strip_tags($_POST['referrer']));
} else {$referrer = '';}




//Send the emails
require("phpmailer.php");
$fromaddress = "sales@instantpromotionusa.com";
$fromname = "Instant Promotion";
$subject ="Your Instant Promotion Enquiry";
$admin_email ="liam.mcsheffrey@hotmail.co.uk";        
$agent_email =  "sales@instantpromotionusa.com";  
$agent_email_1 =  "jordan@instantpromotionusa.com";   
$customer_email = $email; 

	$mail = new PHPMailer();

	$mail->From  = $fromaddress;
    $mail->FromName = $fromname;
    $mail->Subject = $subject;
    $mail->IsHTML(true);       
	  
		//email for customer - marketing styled
        $msg= file_get_contents('poa_customer_email.html'); 
		//pass variables into email
			$msg = strtr($msg, array(
   			 '{name}' => $name,
			 '{reference}' =>$poa_reference,
		));
		
        $sendmail_customer = $mail->AddBCC($admin_email);
		$sendmail_customer = $mail->AddBCC($agent_email);
		$sendmail_customer = $mail->AddBCC($agent_email_1);
		$sendmail_customer = $mail->AddAddress($customer_email);
        $mail->Body = $msg;    
        $mail->Send();
        $mail->ClearAddresses();
		$mail->ClearCCs();
		$mail->ClearBCCs();   
		
		
		
        //email for the admin / agent

         $msg= file_get_contents('poa_agent_email.html'); 
		//pass variables into email and replace the placeholders
			$msg = strtr($msg, array(
			 '{product}' => $product_name,
   			 '{name}' => $name,
			 '{email}'=> $email,
			 '{phone}'=> $phone,
			 '{company}'=> $company,
			 '{comments}'=> $comments,
			 '{product_interested}'=> $product_name,
			 '{product_size}'=> $product_size,			 
			 '{reference}' =>$poa_reference,
			 '{date}' =>$date_required,
			 '{referrer}' =>$referrer,
			 '{package_interested}' =>$package_interested,
		));     
		
		$sendmail_agent = $mail->AddBCC($admin_email);
		$sendmail_agent = $mail->AddAddress($agent_email);
		$sendmail_agent = $mail->AddAddress($agent_email_1);
		
		// Add Attachment 1
		if (isset($_FILES['attachment1']))
			{
		if (($_FILES['attachment1']['size'] > "5000000"))
			{
		$err_msg .= "<b>Attachment #1 is greater that 5mb.</b> <br>";
			}
		if (strlen($err_msg) == 0)
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
		if (($_FILES['attachment2']['size'] > "5000000"))
			{
		$err_msg .= "<b>Attachment #2 is greater that 5mb.</b> <br>";
			}
		if (strlen($err_msg) == 0)
			{
			$file1_path = $_FILES['attachment2']['tmp_name'];
			$file1_name = $_FILES['attachment2']['name'];
			$file1_type = $_FILES['attachment2']['type'];
			$file1_error = $_FILES['attachment2']['error'];
			$mail->AddAttachment($file1_path, $Subject . "_" . $file1_name); // optional name
			}
		}
		
		
		// Add Attachment 3
		if (isset($_FILES['attachment3']))
			{
		if (($_FILES['attachment3']['size'] > "5000000"))
			{
		$err_msg .= "<b>Attachment #3 is greater that 5mb.</b> <br>";
			}
		if (strlen($err_msg) == 0)
			{
			$file1_path = $_FILES['attachment3']['tmp_name'];
			$file1_name = $_FILES['attachment3']['name'];
			$file1_type = $_FILES['attachment3']['type'];
			$file1_error = $_FILES['attachment3']['error'];
			$mail->AddAttachment($file1_path, $Subject . "_" . $file1_name); // optional name
			}
		}

       
        $mail->Body = $msg;    
        $mail->Send();
        //$mail->ClearAddresses();
		//$mail->ClearCCs();
		//$mail->ClearBCCs(); 
		
		
        //separate email for inquiree
        //$msg="3";          
        //$sendmail_email = $mail->AddAddress($email,$name);
        // $mail->Body = $msg;    
        // $mail->Send();
          
        if(!$mail->Send()){
           echo "Message was not sent <p>";
           echo "Mailer Error: " . $mail->ErrorInfo;
           exit;
        } 
  

//header( 'Location: /thank-you' ) ;

} //End POA Form
?>



<?php
//Is it a Quick Quote?

$quick_quote = $_POST['quick_quote'];

if ($quick_quote == 1)

{


if ((isset($_POST['name'])) && (strlen(trim($_POST['name'])) > 0)) {
	$name = stripslashes(strip_tags($_POST['name']));
} else {$name = 'No name entered';}
if ((isset($_POST['email'])) && (strlen(trim($_POST['email'])) > 0)) {
	$customer_email = stripslashes(strip_tags($_POST['email']));
} else {$email = 'No email entered';}
if ((isset($_POST['phone'])) && (strlen(trim($_POST['phone'])) > 0))
 {	$phone = stripslashes(strip_tags($_POST['phone']));
} else {$phone = 'No phone entered';}
if ((isset($_POST['product-interested'])) && (strlen(trim($_POST['product-interested'])) > 0))
 {	$product_name = stripslashes(strip_tags($_POST['product-interested']));
} else {$product_name = '';}
if ((isset($_POST['comments'])) && (strlen(trim($_POST['comments'])) > 0))
 {	$comments = stripslashes(strip_tags($_POST['comments']));
} else {$comments = '';}



$to = 'Instant Promotion Price Match Request';
$email = 'sales@instantpromotionusa.com';
$fromaddress = "sales@instantpromotionusa.com";
$fromname = "Instant Promotion Web Site";

//Send the emails
require("phpmailer.php");
$fromaddress = "sales@instantpromotionusa.com";
$fromname = "Instant Promotion";
$subject ="Instant Promotion Enquiry";
$admin_email ="liam.mcsheffrey@hotmail.co.uk";        
$agent_email =  "sales@instantpromotionusa.com";  
$agent_email_1 =  "jordan@instantpromotionusa.com";   
//$customer_email = $email; 

	$mail = new PHPMailer();

	$mail->From  = $fromaddress;
    $mail->FromName = $fromname;
    $mail->Subject = $subject;
    $mail->IsHTML(true);       
	  
		//email for the admin / agent

         $msg= file_get_contents('quick_quote_email.html'); 
		//pass variables into email and replace the placeholders
			$msg = strtr($msg, array(			 
   			 '{name}' => $name,
			 '{email}'=> $customer_email,
			 '{phone}'=> $phone,	
			 '{product_interested}'=> $product_name,	
			 '{product}'=> $product_name,
			 '{comments}'=> $comments
		));     
		
		$sendmail_agent = $mail->AddBCC($admin_email);
		$sendmail_agent = $mail->AddAddress($agent_email);
		$sendmail_agent = $mail->AddAddress($agent_email_1);
		
		
        $mail->Body = $msg;    
        $mail->Send();
        //$mail->ClearAddresses();
		//$mail->ClearCCs();
		//$mail->ClearBCCs(); 
		
		
        //separate email for inquiree
        //$msg="3";          
        //$sendmail_email = $mail->AddAddress($email,$name);
        // $mail->Body = $msg;    
        // $mail->Send();
          
        if(!$mail->Send()){
           echo "Message was not sent <p>";
           echo "Mailer Error: " . $mail->ErrorInfo;
           exit;
        } 
  

//header( 'Location: /thank-you' ) ;

} //End qUICK qUOTE Match
?>


