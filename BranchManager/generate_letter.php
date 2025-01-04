<?php
include dirname(__DIR__) . "../connection/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $patient_id = $_POST['patient_id'];
    $staff_id = $_POST['staff_id'];
    $hospital_department_id = $_POST['hospital_department_id'];
    $letter_type = $_POST['letter_type'];
    $message = $_POST['message']; // Use message as the letter content

    // Prepare SQL to insert into referral_letters
    $sql = "INSERT INTO referral_letters 
            (date_generated, hospital_department_id, staff_id, patient_id, letter_type, letter_description) 
            VALUES 
            (:date_generated, :hospital_department_id, :staff_id, :patient_id, :letter_type, :letter_description)";

    try {
        $stmt = $conn->prepare($sql);
        
        // Get current date in the format you specified (INT(8))
        $current_date = date('Ymd');

        // Bind parameters
        $stmt->bindValue(':date_generated', $current_date, PDO::PARAM_INT);
        $stmt->bindValue(':hospital_department_id', $hospital_department_id, PDO::PARAM_INT);
        $stmt->bindValue(':staff_id', $staff_id, PDO::PARAM_INT);
        $stmt->bindValue(':patient_id', $patient_id, PDO::PARAM_INT);
        $stmt->bindValue(':letter_type', $letter_type, PDO::PARAM_STR);
        $stmt->bindValue(':letter_description', $message, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Success: Output JavaScript to show alert and refresh the page
            echo "<script>
                    alert('Letter generated successfully!');
                    window.location.href = 'branchLetter.php'; // Redirect to the same page or desired page
                  </script>";
        } else {
            echo "Error: Could not execute the query.";
        }

    } catch (PDOException $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
}
?>
