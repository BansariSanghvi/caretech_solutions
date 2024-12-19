<?php
include("../connection/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $patient_id = $_POST['patient_id'];
    $staff_id = $_POST['staff_id'];
    $hospital_department_id = $_POST['hospital_department_id'];
    $letter_type = $_POST['letter_type'];
    $message = $_POST['message']; // Use message as the letter content

    // Prepare SQL to insert into referal_letters
    $sql = "INSERT INTO referral_letters 
            (date_generated, hospital_department_id, staff_id, patient_id, letter_type, letter_description) 
            VALUES 
            (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    
    // Get current date in the format you specified (INT(8))
    $current_date = date('Ymd');

    // Bind parameters
    $stmt->bind_param("iiisss", 
        $current_date, 
        $hospital_department_id, 
        $staff_id, 
        $patient_id, 
        $letter_type, 
        $message // Use message as letter description
    );

    if ($stmt->execute()) {
        // Success: Output JavaScript to show alert and refresh the page
        echo "<script>
                alert('Letter generated successfully!');
                window.location.href = 'branchLetter.php'; // Redirect to the same page or desired page
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
}
$conn->close();
?>
