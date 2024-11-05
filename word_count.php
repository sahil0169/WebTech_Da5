<?php
// List of words to count
$words_to_count = ['great', 'good', 'poor', 'excellent', 'bad'];

// Initialize counts
$word_counts = array_fill_keys($words_to_count, 0);

// Open feedback.txt file
$file = fopen("feedback.txt", "r");

if ($file) {
    while (($line = fgets($file)) !== false) {
        foreach ($words_to_count as $word) {
            // Count occurrences of each word (case-insensitive)
            $word_counts[$word] += substr_count(strtolower($line), strtolower($word));
        }
    }
    fclose($file);

    // Display word counts
    echo "<h2>Word Frequency Counts</h2><table><thead><tr><th>Word</th><th>Frequency</th></tr></thead><tbody>";
    foreach ($word_counts as $word => $count) {
        echo "<tr><td>" . htmlspecialchars($word) . "</td><td>" . $count . "</td></tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<p>Unable to open feedback file.</p>";
}
?>
