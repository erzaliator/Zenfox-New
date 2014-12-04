<form method="post" action="sender.php" name="player-contact">
	<table align="center">
		<tbody>
			<tr>
				<td height="50">Name* :</td>
				<td><span><input type="text" required="" value="" name="name"></span></td>
			</tr>
			<tr>
				<td height="30">Email* :</td>
				<td><span><input type="text" required="" value="" name="email"></span></td>
			</tr>
			<tr>
				<td valign="top" height="50">Message* :</td>
				<td><textarea required="" name="message" cols="30" rows="5"></textarea></td>
			</tr>
			<tr>
				<td valign="top" height="50"></td>
				<td><input type="submit" value="Submit"></td>
			</tr>
		</tbody>
	</table>
</form>
<?php
if($_POST)
{
	$userEmail = $_POST['email'];
	$message = $_POST['message'];
	$name = $_POST['name'];
	
	require_once 'PHPMailer/class.phpmailer.php';
	require_once 'PHPMailer/class.smtp.php';
	$mail = new PHPMailer();
	//$mail->SMTPDebug = true;
	$mail->SMTPAuth = true;
	$mail->CharSet = 'utf-8';
	$mail->SMTPSecure = 'ssl';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = '465';
	$mail->Username = '<GMAIL USER>';
	$mail->Password = '<GMAIL PASSWORD>';
	$mail->Mailer = 'smtp';
	$mail->From = '<FROM EMAIL>';
	$mail->FromName = '<FROM NAME>';
	$mail->Sender = '<SENDER MAIL>';
	$mail->Priority = 3;
	
	$mail->AddAddress('yaswanth@fortuity.in', 'Yaswanth');
	//$mail->AddReplyTo('replay to', 'admin name');
	$mail->Subject = '<SUBJECT>';
	$mail->Body = 'User: ' . $name . "<br>Email: " . $userEmail . "<br>Message: " . $message;
	$mail->IsHTML(true);
		
	if(!$mail->Send()) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
		exit;
	}
	
	echo 'Message has been sent';
}