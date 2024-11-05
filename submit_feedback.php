<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get feedback data from the form
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Get the current timestamp
    $timestamp = date("Y-m-d H:i:s");

    // Format the feedback entry
    $feedback_entry = "Date: $timestamp\nName: $name\nEmail: $email\nMessage: $message\n\n";

    // Write to feedback.txt file
    $file = fopen("feedback.txt", "a");
    if ($file) {
        fwrite($file, $feedback_entry);
        fclose($file);
        echo "<p class='success'>Feedback submitted successfully!</p>";
    } else {
        echo "<p class='error'>Error saving feedback!</p>";
    }
}
?>
