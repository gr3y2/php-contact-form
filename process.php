<?php
// Initialize error array and old input
$errors = [];
$old_input = $_POST; // Keep for repopulating form
$success = false;

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // --- Sanitization & Validation ---

    // Name: required, trim, basic sanitization
    $name = trim($_POST['name'] ?? '');
    if (empty($name)) {
        $errors[] = 'Name is required.';
    } else {
        // For safe output later, we store the raw input; htmlspecialchars will be used at display time
        $name = $_POST['name']; // keep original, but we already trimmed
    }

    // Email: required, valid format
    $email = trim($_POST['email'] ?? '');
    if (empty($email)) {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    // Message: required
    $message = trim($_POST['message'] ?? '');
    if (empty($message)) {
        $errors[] = 'Message is required.';
    }

    // If no errors, process the data
    if (empty($errors)) {
        // All inputs are safe to use now (further sanitization for storage)
        $safe_name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $safe_email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
        $safe_message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        // --- Optional MongoDB Storage ---
        // Uncomment and configure the following if you have MongoDB installed and the PHP extension enabled.

        /*
        try {
            // Connect to MongoDB (adjust URI/database/collection as needed)
            $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
            $collection = $mongoClient->contact_form->submissions;

            // Insert document
            $insertResult = $collection->insertOne([
                'name' => $safe_name,
                'email' => $safe_email,
                'message' => $safe_message,
                'submitted' => new MongoDB\BSON\UTCDateTime(),
                'ip' => $_SERVER['REMOTE_ADDR'] ?? null
            ]);

            // Optional: check if insert was successful
            // if ($insertResult->getInsertedCount() === 1) { ... }
        } catch (Exception $e) {
            // Log error or display a user-friendly message (but don't expose details)
            error_log('MongoDB insert failed: ' . $e->getMessage());
            // You could add a non‑critical error message here if you want
            // $errors[] = 'Could not save to database, but your message was received.';
        }
        */

        // For this example, we simply set success to true
        $success = true;

        // Clear old input on success so the form is empty
        $old_input = [];
    }
}