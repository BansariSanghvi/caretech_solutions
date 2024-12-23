<?php
include '../connection/connection.php';

$query = "SELECT 
                medicalEquipment_list.equipment_ID,
                medicalEquipment_list.equipment_Name,
                medicalEquipment_list.equipment_description,
                medicalEquipment_list.qty,
                medicalEquipment_list.hospital_department_id,
                hospital_branches.department_name
            FROM 
                medicalEquipment_list
            INNER JOIN 
                hospital_branches 
            ON 
                medicalEquipment_list.hospital_department_id = hospital_branches.hospital_department_id";

$result = $conn->query($query);

// Check if there are any records
if ($result->num_rows > 0) {
    $inventory_data = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative array
} else {
    $inventory_data = []; // No records found
}

// Return the table rows as HTML
foreach ($inventory_data as $inventory) {
    $row_class = "";
    if ($inventory['qty'] < 10) {
        $row_class = "low-stock"; // Red color for low stock
    } elseif ($inventory['qty'] >= 10 && $inventory['qty'] <= 20) {
        $row_class = "approaching-stock"; // Yellow color for approaching stock
    } else {
        $row_class = "normal-stock"; // Default color for normal stock
    }

    echo "<tr class='$row_class'>";
    echo "<td>" . $inventory['equipment_ID'] . "</td>";
    echo "<td>" . $inventory['equipment_Name'] . "</td>";
    echo "<td>" . $inventory['equipment_description'] . "</td>";
    echo "<td>" . $inventory['qty'] . "</td>";
    echo "<td>" . $inventory['department_name'] . "</td>";
    echo "<td><a href='edit_inventory.php?id=" . $inventory['equipment_ID'] . "' class='edit-button'>View</a></td>";
    echo "</tr>";
}
?>
