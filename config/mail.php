<?php
require_once(AUTO_LOAD);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
try {
	$mail->SMTPDebug = 2;
	$mail->isSMTP();
	$mail->Host = 'smtp.mailtrap.io';
	$mail->SMTPAuth = true;
	$mail->Username = '1540028672057a';
	$mail->Password = 'ef7074d7e115e5';
	$mail->SMTPSecure = 'tls';
	$mail->Port = 2525;

	if (isset($_POST['msg_submit'])) {
		$userName = $_POST['name'];
		$email = $_POST['email'];
		$subject = $_POST['subject'];
		$messages = $_POST['messages'];
		$attachmentName = $_FILES['attachment']['name'];
		$attachmentTmp = $_FILES['attachment']['tmp_name'];
		$dest= "$attachmentName";
		move_uploaded_file($attachmentTmp,"../../public/attachment/$attachmentName");

		$mail->setFrom($email, $userName);
		$mail->addAddress('micusawu@tinoza.org', 'Priyanka');

		if ($attachmentName) {
            $mail->addAttachment(LINK_BASE_PATH.'public/attachment/'.$dest);   // Add attachments
        }
        $mail->Subject = $subject;
        $mail->Body    = $messages;
        if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){
        	echo "<script>alert('Please enter correct captcha code!'); </script>";
        }else{
        	$mail->send();
        	echo "<script>alert('Mail send sucessfully.');
        	location.assign('contact-us.php');
        	</script>";
        }
    }
}catch (Exception $e) {
	echo "<script>alert('Something went wrong message could not be sent!'); </script>";
}