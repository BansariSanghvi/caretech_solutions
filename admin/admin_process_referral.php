<?php
session_start();
include '../connection/connection.php';

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header('Location: unauthorized.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $patient_name = $_POST['patient_name'];
    $patient_id = $_POST['patient_id'];
    $request_type = $_POST['request_type']; // Consultation, Follow-Up, etc.
    $priority_category = $_POST['p_type']; // Urgent, Standard, etc.
    $notes = $_POST['notes'];
    $referral_type = $_POST['referral_type']; // internal or external
    $sending_department_id = $_POST['department_id']; 

    // Initialize other fields
    $hospital_department_id = null;
    $medical_association_id = null;
    $is_external = false;

    // Determine referral type and target
    if ($referral_type === 'internal') {
        $hospital_department_id = $_POST['hospital_department_id'];
    } elseif ($referral_type === 'external') {
        $medical_association_id = $_POST['medical_association_id'];
        $is_external = true;
    }

    // Define the initial 'Pending' status
    $status = 'Pending';

    try {
        // Prepare and execute SQL query
        $stmt = $conn->prepare("
            INSERT INTO referal_form 
            (request_type, summary_notes, priority_category, sending_department_id, 
            hospital_department_id, medical_association_id, staff_id, hospital_id, patient_id, 
            is_external, isViewed) 
            VALUES (?, ?, ?, ?, ?, ?, 1, 1, ?, ?, ?)
        ");

        // Bind parameters
        $stmt->bind_param(
            "sssiiiiiiis",
            $request_type,          // Request Type (Consultation, Follow-Up)
            $notes,                 // Summary Notes
            $priority_category,     // Priority (Urgent, Standard, etc.)
            $sending_department_id, // Sending Department ID
            $hospital_department_id, // Internal Department (nullable)
            $medical_association_id, // External Association (nullable)
            1,                      // Staff ID (hardcoded to 1)
            1,                      // Hospital ID (hardcoded to 1)
            $patient_id,            // Patient ID
            $is_external,           // Is External (true/false)
            $status                 // Initial status 'Pending'
        );

        if ($stmt->execute()) {
            echo "Referral submitted successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "Error processing referral: " . $e->getMessage();
    }
}
?>