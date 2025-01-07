<?php
include dirname(__DIR__) . "/connection/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $patient_id = $_POST['patient_id'];
    $staff_id = $_POST['staff_id'];
    $sending_department_id = $_POST['hospital_department_id'];
    $request_type = $_POST['request_type']; // This is now the text input
    $referral_category = $_POST['referral_category']; // This is internal/external
    $urgency_level = $_POST['urgency_level'];
    $reason_for_referral = $_POST['reason_for_referral'];
    $is_external = ($referral_category == 'external') ? '1' : '0';

    // Initialize variables
    $hospital_department_id = null;
    $medical_association_id = null;

    // Determine which department or facility to use based on is_external
    if ($is_external == '1') {
        $medical_association_id = $_POST['external_facility'];
    } else {
        $hospital_department_id = $_POST['internal_department'];
    }

    // Set hospital_id to 1
    $hospital_id = 1;

    // Prepare SQL to insert into referral_form
    $sql = "INSERT INTO referral_form 
            (request_type, summary_notes, priority_category, sending_department_id, 
             hospital_department_id, medical_association_id, staff_id, hospital_id, patient_id, is_external) 
            VALUES (:request_type, :summary_notes, :priority_category, :sending_department_id, 
                    :hospital_department_id, :medical_association_id, :staff_id, :hospital_id, 
                    :patient_id, :is_external)";

    try {
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':request_type', $request_type);
        $stmt->bindParam(':summary_notes', $reason_for_referral);
        $stmt->bindParam(':priority_category', $urgency_level);
        $stmt->bindParam(':sending_department_id', $sending_department_id, PDO::PARAM_INT);
        $stmt->bindParam(':hospital_department_id', $hospital_department_id, PDO::PARAM_INT);
        $stmt->bindParam(':medical_association_id', $medical_association_id, PDO::PARAM_INT);
        $stmt->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
        $stmt->bindParam(':hospital_id', $hospital_id, PDO::PARAM_INT);
        $stmt->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);
        $stmt->bindParam(':is_external', $is_external);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Referral submitted successfully!');
                    window.location.href = 'branchReferral.php';
                  </script>";
        } else {
            echo "Error: Could not execute the query.";
        }

    } catch (PDOException $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
}
?>
