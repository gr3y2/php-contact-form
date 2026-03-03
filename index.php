<?php
// Initialize variables
$errors = [];
$success = false;
$old_input = [];

// If form was submitted, include the processor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'process.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Contact Us</h1>
        <p>Please fill in the form below. We’ll get back to you as soon as possible.</p>

        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success-message">
                <p>Thank you for contacting us! Your message has been sent.</p>
            </div>
        <?php endif; ?>

        <form method="post" action="index.php" novalidate>
            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" id="name" name="name" 
                       value="<?php echo isset($old_input['name']) ? htmlspecialchars($old_input['name'], ENT_QUOTES, 'UTF-8') : ''; ?>" 
                       placeholder="Your full name">
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" 
                       value="<?php echo isset($old_input['email']) ? htmlspecialchars($old_input['email'], ENT_QUOTES, 'UTF-8') : ''; ?>" 
                       placeholder="you@example.com">
            </div>

            <div class="form-group">
                <label for="message">Message *</label>
                <textarea id="message" name="message" rows="6" 
                          placeholder="Your message..."><?php echo isset($old_input['message']) ? htmlspecialchars($old_input['message'], ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
            </div>

            <button type="submit" class="btn">Send Message</button>
        </form>
    </div>
</body>
</html>