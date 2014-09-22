<?php
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];

// Access WordPress
require_once( $path_to_wp . '/wp-load.php' );

function cs_validate_email($email)
{
	/*
	(Name) Letters, Numbers, Dots, Hyphens and Underscores
	(@ sign)
	(Domain) (with possible subdomain(s) ).
	Contains only letters, numbers, dots and hyphens (up to 255 characters)
	(. sign)
	(Extension) Letters only (up to 10 (can be increased in the future) characters)
	*/

	$regex = '/([a-z0-9_.-]+)'. # name

	'@'. # at

	'([a-z0-9.-]+){2,255}'. # domain & possibly subdomains

	'.'. # period

	'([a-z]+){2,10}/i'; # domain extension 

	if($email == '') { 
		return false;
	}
	else {
		$eregi = preg_replace($regex, '', $email);
	}

	return empty($eregi) ? true : false;
}

$post = (!empty($_POST)) ? true : false;

if($post)
{
	$name = stripslashes($_POST['name']);
	$subject = 'Contact Form';
	$email = trim($_POST['email']);
	$to = trim($_POST['to_email']);
	$message = stripslashes($_POST['message']);
	$error = '';

	// Check name

	if(!$name)
	{
		$error .= 'Please enter your name.<br />';
	}

	// Check email

	if(!$email)
	{
		$error .= 'Please enter an e-mail address.<br />';
	}

	if($email && !cs_validate_email($email))
	{
		$error .= 'Please enter a valid e-mail address.<br />';
	}

	// Check message (length)

	if(!$message || strlen($message) < 15)
	{
		$error .= "Please enter your message. It should have at least 15 characters.<br />";
	}
	
	if(!$error) // send email
	{
		$headers = 'From: ' . $name . ' <'.$email.'>'."\n".'Reply-To: ' . $name . ' <'.$email.'>';
		$mail = wp_mail($to, $subject, $message, $headers);

		if($mail)
		{
			echo 'OK';
		}

	}
	else
	{
		echo '<div class="notification_error">'.$error.'</div>'; // set up error div for jQuery/Ajax
	}

}

?>