<?php
include("../connection/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $patient_id = $_POST['patient_id'];
    $staff_id = $_POST['staff_id'];
    $hospital_department_id = $_POST['hospital_department_id'];
    $referral_reason = $_POST['referral_reason']; // Adjust field name if necessary
    $additional_notes = $_POST['additional_notes']; // Adjust field name if necessary

    // Prepare SQL to insert into the referrals table
    $sql = "INSERT INTO referrals 
            (date_submitted, patient_id, staff_id, hospital_department_id, referral_reason, additional_notes) 
            VALUES 
            (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Get current date in the format you specified (INT(8))
    $current_date = date('Ymd');

    // Bind parameters
    $stmt->bind_param("iiiiss", 
        $current_date, 
        $patient_id, 
        $staff_id, 
        $hospital_department_id, 
        $referral_reason, 
        $additional_notes
    );

    if ($stmt->execute()) {
        // Success: Output JavaScript to show alert and refresh the page
        echo "<script>
                alert('Referral submitted successfully!');
                window.location.href = 'staff_referral_form.php'; // Redirect to the referrals page
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
}
$conn->close();
?>
