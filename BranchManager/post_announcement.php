<?php
// Turn off output buffering
ob_start();

// Include your database connection
include dirname(__DIR__).("../connection/connection.php");

// Set error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure we're outputting JSON
header('Content-Type: application/json');

// Initialize the response array
$response = array('status' => 'error', 'message' => 'Unknown error occurred');

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['announcement_text'])) {
        $announcement_text = $_POST['announcement_text'];
        $duration = 5; // 5 minutes default

        // Prepare and execute the SQL query
        $sql = "INSERT INTO announcements (announcement_description, announcement_duration) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            throw new Exception("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("si", $announcement_text, $duration);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Announcement posted successfully!';
        } else {
            throw new Exception("Error executing statement: " . $stmt->error);
        }

        $stmt->close();
    } else {
        throw new Exception("Invalid request or empty announcement text");
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
} finally {
    $conn->close();
}

// Clear the output buffer
ob_end_clean();

// Output the JSON response
echo json_encode($response);
exit;
