<?php
$file = fopen("feedback.txt", "r");

if ($file) {
    echo "<h2>All Feedback Entries</h2><table><thead><tr><th>Date</th><th>Name</th><th>Email</th><th>Message</th></tr></thead><tbody>";

    $feedback_entry = '';
    while (($line = fgets($file)) !== false) {
        $feedback_entry .= $line;
        if (trim($line) === '') {  // Blank line after each feedback entry
            // Parse and display the entry
            $lines = explode("\n", $feedback_entry);
            $date = trim(substr($lines[0], 6));  // Extract Date
            $name = trim(substr($lines[1], 6));  // Extract Name
            $email = trim(substr($lines[2], 7));  // Extract Email
            $message = trim(substr($lines[3], 9));  // Extract Message

            echo "<tr>
                    <td>$date</td>
                    <td>$name</td>
                    <td>$email</td>
                    <td>$message</td>
                  </tr>";
            $feedback_entry = ''; // Reset for next entry
        }
    }

    echo "</tbody></table>";
    fclose($file);
} else {
    echo "<p>Unable to open feedback file.</p>";
}
?>
