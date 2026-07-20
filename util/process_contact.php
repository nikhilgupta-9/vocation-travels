<?php
// util/process_contact.php

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Use statements must be at the top
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include_once "../config/connect.php";
include_once "function.php";

// Use Composer's autoloader
require_once '../vendor/autoload.php';

define('SITE_URL', $site);

// Set timezone
date_default_timezone_set('UTC');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: " . SITE_URL . "contact.php");
    exit();
}

// Verify CSRF token
if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
    logError("CSRF token validation failed");
    $_SESSION['contact_error'] = "Security validation failed. Please try again.";
    header("Location: " . SITE_URL . "contact.php");
    exit();
}

// Sanitize and validate input data
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$date = trim($_POST['date'] ?? '');
$adults = (int)($_POST['adults'] ?? 0);
$children = (int)($_POST['children'] ?? 0);
$destination = trim($_POST['destination'] ?? '');
$timeline = trim($_POST['timeline'] ?? '');
$comments = trim($_POST['comments'] ?? '');

// Create message body from all fields
$message_body = "Travel Inquiry Details:\n\n";
$message_body .= "Name: $name\n";
$message_body .= "Email: $email\n";
$message_body .= "Phone: $phone\n";
$message_body .= "Date of Travel: $date\n";
$message_body .= "Number of Adults: $adults\n";
$message_body .= "Number of Children: $children\n";
$message_body .= "Total People: " . ($adults + $children) . "\n";
$message_body .= "Destination/Package: $destination\n";
$message_body .= "Package Timeline: $timeline\n";
$message_body .= "Additional Comments:\n$comments\n";

// Basic validation
$errors = [];

if (empty($name)) {
    $errors[] = "Name is required.";
} elseif (strlen($name) < 2 || strlen($name) > 100) {
    $errors[] = "Name must be between 2 and 100 characters.";
}

if (empty($email)) {
    $errors[] = "Email is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
}

if (empty($phone)) {
    $errors[] = "Phone number is required.";
} elseif (!preg_match('/^[0-9+\-\s()]{10,20}$/', $phone)) {
    $errors[] = "Please enter a valid phone number.";
}

if (empty($date)) {
    $errors[] = "Date of travel is required.";
}

if (empty($destination)) {
    $errors[] = "Destination/Package is required.";
}

if (empty($timeline)) {
    $errors[] = "Package timeline is required.";
}

if ($adults <= 0) {
    $errors[] = "At least 1 adult is required.";
}

// If errors exist, store and redirect
if (!empty($errors)) {
    $_SESSION['contact_errors'] = $errors;
    $_SESSION['contact_form_data'] = $_POST;
    header("Location: " . SITE_URL . "contact.php");
    exit();
}

// Check rate limit
if (!checkRateLimit($email, $conn)) {
    logError("Rate limit exceeded", ['email' => $email, 'ip' => $_SERVER['REMOTE_ADDR']]);
    $_SESSION['contact_error'] = "You have submitted too many inquiries. Please try again later.";
    header("Location: " . SITE_URL . "contact.php");
    exit();
}

// Prepare data for database
$clean_name = mysqli_real_escape_string($conn, $name);
$clean_email = mysqli_real_escape_string($conn, $email);
$clean_phone = mysqli_real_escape_string($conn, $phone);
$clean_date = mysqli_real_escape_string($conn, $date);
$clean_destination = mysqli_real_escape_string($conn, $destination);
$clean_timeline = mysqli_real_escape_string($conn, $timeline);
$clean_comments = mysqli_real_escape_string($conn, $comments);
$created_at = date('Y-m-d H:i:s');
$ip_address = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$status = 'unread';
$subject_line = "Travel Inquiry: $destination - " . date('d M Y');
$clean_subject = mysqli_real_escape_string($conn, $subject_line);

// First, check if all columns exist in the table
$columns_check = "SHOW COLUMNS FROM inquiries";
$columns_result = mysqli_query($conn, $columns_check);
$existing_columns = [];
while ($column = mysqli_fetch_assoc($columns_result)) {
    $existing_columns[] = $column['Field'];
}

// Build query based on existing columns
$insert_fields = ['name', 'email', 'phone', 'subject', 'message', 'ip_address', 'user_agent', 'created_at', 'status'];
$insert_values = [$clean_name, $clean_email, $clean_phone, $clean_subject, $message_body, $ip_address, $user_agent, $created_at, $status];
$types = "sssssssss";

// Add optional fields if they exist
$optional_fields = [
    'travel_date' => $date,
    'adults' => $adults,
    'children' => $children,
    'destination' => $destination,
    'timeline' => $timeline
];

foreach ($optional_fields as $field => $value) {
    if (in_array($field, $existing_columns)) {
        $insert_fields[] = $field;
        $insert_values[] = $value;
        $types .= is_int($value) ? "i" : "s";
    }
}

// Build the SQL query
$sql = "INSERT INTO inquiries (" . implode(', ', $insert_fields) . ") 
        VALUES (" . implode(', ', array_fill(0, count($insert_fields), '?')) . ")";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    logError("Database prepare failed", ['error' => mysqli_error($conn)]);
    $_SESSION['contact_error'] = "System error. Please try again later.";
    header("Location: " . SITE_URL . "contact.php");
    exit();
}

// Bind parameters dynamically
mysqli_stmt_bind_param($stmt, $types, ...$insert_values);

if (mysqli_stmt_execute($stmt)) {
    $inquiry_id = mysqli_insert_id($conn);
    
    // Get contact settings
    $contact = contact_us();
    $email_logo = get_email_logo();

    // Prepare email subject
    $email_subject = "New Travel Inquiry #$inquiry_id: $destination - " . date('d M Y');

    // Send email notification
    $email_sent = sendTravelInquiryEmail(
        $name,
        $email,
        $phone,
        $email_subject,
        $message_body,
        $contact,
        $email_logo,
        SITE_URL,
        $inquiry_id
    );

    if (!$email_sent) {
        logError("Email notification failed for inquiry #$inquiry_id", ['email' => $email]);
    }

    // Clear session data
    unset($_SESSION['csrf_token']);
    unset($_SESSION['contact_form_data']);

    // Set success message
    $_SESSION['contact_success'] = "Thank you for your inquiry #$inquiry_id! We'll get back to you soon with details about your trip.";

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header("Location: " . SITE_URL . "contact.php?success=1");
    exit();

} else {
    logError("Database insert failed", [
        'error' => mysqli_error($conn),
        'data' => ['email' => $email]
    ]);

    $_SESSION['contact_error'] = "Failed to save your inquiry. Please try again.";
    $_SESSION['contact_form_data'] = $_POST;

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header("Location: " . SITE_URL . "contact.php");
    exit();
}

// Function to send travel inquiry email
function sendTravelInquiryEmail($name, $email, $phone, $subject, $message_body, $contact, $email_logo, $site_url, $inquiry_id) {
    
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'support@vocationtravels.in';
        $mail->Password   = 'i^!v#9eM';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 465;
        $mail->SMTPDebug  = 0; // Set to 2 for debugging
        
        // Recipients
        $mail->setFrom('noreply@vocationtravels.com', 'Vocation Travels');
        $mail->addAddress($contact['contact_email'] ?? 'admin@vocationtravels.com', 'Travel Desk');
        $mail->addReplyTo($email, $name);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        
        // HTML Email Template
        $mail->Body = "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(to right, #16a34a, #dc2626); color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { padding: 20px; background: #f9f9f9; border: 1px solid #ddd; }
                .field { margin-bottom: 15px; padding: 10px; background: white; border-radius: 5px; }
                .label { font-weight: bold; color: #555; display: inline-block; width: 150px; }
                .value { color: #333; }
                .footer { text-align: center; padding: 20px; color: #777; font-size: 12px; background: #f0f0f0; border-radius: 0 0 10px 10px; }
                .inquiry-id { background: #333; color: white; padding: 5px 15px; border-radius: 20px; display: inline-block; margin-top: 10px; }
                hr { border: 1px solid #16a34a; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>🚀 New Travel Inquiry Received</h2>
                    <div class='inquiry-id'>Inquiry #$inquiry_id</div>
                </div>
                <div class='content'>
                    " . nl2br(htmlspecialchars($message_body)) . "
                </div>
                <div class='footer'>
                    <p>This inquiry was submitted from: " . ($_SERVER['HTTP_REFERER'] ?? 'Website') . "</p>
                    <p>IP Address: " . $_SERVER['REMOTE_ADDR'] . "</p>
                    <hr>
                    <p>© " . date('Y') . " Vocation Travels. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>";
        
        $mail->AltBody = strip_tags($message_body);
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        logError("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}
?>