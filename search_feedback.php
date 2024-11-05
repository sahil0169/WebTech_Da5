<?php
// Define the words to count occurrences of
$wordsToCount = ["great", "good", "poor"];

// Function to count occurrences of each word across all feedback
function countWordOccurrences($filePath, $wordsToCount) {
    // Read the entire file content
    $content = file_exists($filePath) ? strtolower(file_get_contents($filePath)) : '';
    $wordCounts = [];

    // Count occurrences of each specified word
    foreach ($wordsToCount as $word) {
        $wordCounts[$word] = substr_count($content, strtolower($word));
    }

    return $wordCounts;
}

// Check if search term is provided
if (isset($_GET['search_term']) && !empty($_GET['search_term'])) {
    // Clean and sanitize the search term
    $search_term = htmlspecialchars($_GET['search_term']);
    
    // Open the feedback.txt file in read mode
    $file = fopen("feedback.txt", "r");
    
    if ($file) {
        $results = [];
        $feedback_entry = '';  // Temporary variable to store the current feedback entry

        // Read the file line by line
        while (($line = fgets($file)) !== false) {
            // Append each line to the current feedback entry
            $feedback_entry .= $line;

            // If we encounter an empty line, it means we've reached the end of one feedback entry
            if (trim($line) === '') {
                // If the feedback contains the search term (case-insensitive), add it to the results array
                if (stripos($feedback_entry, $search_term) !== false) {
                    // Store the matching feedback entry
                    $results[] = $feedback_entry;
                }

                // Reset the feedback entry for the next feedback
                $feedback_entry = '';
            }
        }

        // Close the file after reading
        fclose($file);

        // Display search results
        if (!empty($results)) {
            echo "<h2>Search Results for: '" . htmlspecialchars($search_term) . "'</h2>";
            echo "<table border='1' cellpadding='10' cellspacing='0' style='width: 100%; border-collapse: collapse;'>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>";

            // Loop through the results and display them in a table
            foreach ($results as $result) {
                // Split the feedback entry into individual lines
                $lines = explode("\n", $result);

                // Extract the Date, Name, Email, and Message from the entry
                $date = isset($lines[0]) ? trim(substr($lines[0], 6)) : 'N/A';  // Date: 2024-11-01 15:35:02
                $name = isset($lines[1]) ? trim(substr($lines[1], 6)) : 'N/A';  // Name: John Doe
                $email = isset($lines[2]) ? trim(substr($lines[2], 7)) : 'N/A'; // Email: johndoe@example.com
                $message = isset($lines[3]) ? trim(substr($lines[3], 9)) : 'N/A'; // Message: The product was great!

                // Ensure that message is well formatted (escaping HTML characters and preserving line breaks)
                $message = nl2br(htmlspecialchars($message));

                // Display each feedback entry in a table row
                echo "<tr>
                        <td>" . htmlspecialchars($date) . "</td>
                        <td>" . htmlspecialchars($name) . "</td>
                        <td>" . htmlspecialchars($email) . "</td>
                        <td>" . $message . "</td>
                      </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p>No feedback found for '" . htmlspecialchars($search_term) . "'.</p>";
        }
    } else {
        echo "<p>Unable to open feedback file.</p>";
    }
} else {
    echo "<p>Please enter a search term.</p>";
}

// Display word occurrence count
$wordCounts = countWordOccurrences("feedback.txt", $wordsToCount);
echo "<h2>Word Occurrences</h2>";
echo "<table border='1' cellpadding='10' cellspacing='0' style='width: 100%; border-collapse: collapse;'>
        <thead>
            <tr>
                <th>Word</th>
                <th>Occurrences</th>
            </tr>
        </thead>
        <tbody>";
foreach ($wordCounts as $word => $count) {
    echo "<tr>
            <td>" . htmlspecialchars($word) . "</td>
            <td>" . htmlspecialchars($count) . "</td>
          </tr>";
}
echo "</tbody></table>";
?>
