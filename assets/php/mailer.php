<?php

    // if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //     $name = strip_tags(trim($_POST["name"]));
	// 			$name = str_replace(array("\r","\n"),array(" "," "),$name);
    //     $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    //     $message = trim($_POST["message"]);


    //     if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         http_response_code(400);
    //         echo "Oops! There was a problem with your submission. Please complete the form and try again.";
    //         exit;
    //     }

    //     // Change your email hosting in hire
    //     $recipient = "padgzmn@gmail.com"; 

    //     // Set the email subject.
    //     $subject = "New contact from $name";


    //     $email_content = "Name: $name\n";
    //     $email_content .= "Email: $email\n\n";
    //     $email_content .= "Message:\n$message\n";


    //     $email_headers = "From: $name <$email>";


    //     if (mail($recipient, $subject, $email_content, $email_headers)) {
    //         http_response_code(200);
    //         echo "Thank You! Your message has been sent.";
    //     } else {
    //         http_response_code(500);
    //         echo "Oops! Something went wrong and we couldn't send your message.";
    //     }

    // } else {
    //     http_response_code(403);
    //     echo "There was a problem with your submission, please try again.";
    // }


    
    // configure
$from = 'Demo contact form <demo@domain.com>';
$sendTo = 'Demo contact form <demo@domain.com>'; // Add Your Email
$subject = 'New message from contact form';
$fields = array('name' => 'Name', 'subject' => 'Subject', 'email' => 'Email', 'message' => 'Message'); // array variable name => Text to appear in the email
$okMessage = 'Contact form successfully submitted. Thank you, I will get back to you soon!';
$errorMessage = 'There was an error while submitting the form. Please try again later';

// let's do the sending

try
{
    $emailText = "You have new message from contact form\n=============================\n";

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
else {
    echo $responseArray['message'];
}
    
?>
