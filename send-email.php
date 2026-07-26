<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form fields and remove whitespace
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = isset($_POST["phone"]) ? strip_tags(trim($_POST["phone"])) : "N/A";
    $service = isset($_POST["service"]) ? strip_tags(trim($_POST["service"])) : "General Inquiry";
    $message = trim($_POST["message"]);

    // Check that data was sent to the mailer
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please complete the form and try again.";
        exit;
    }

    // Set the recipient email address
    $recipient = "lexlandtec@gmail.com";
    $subject = "New Quote Request from $name";

    // Build the email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone: $phone\n";
    $email_content .= "Service: $service\n\n";
    $email_content .= "Message:\n$message\n";

    // Build the email headers
    $email_headers = "From: $email" . "\r\n";
    $email_headers .= "Reply-To: $email" . "\r\n";

    // Send the email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>