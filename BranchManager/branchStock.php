<?php
session_start();

include dirname(__DIR__).("/connection/connection.php");

$dbConnect = new DBConnect();
$conn = $dbConnect->connect();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/branch_theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>BranchManager Stock / Inventory</title>
    <style>

        .data_table {
            width: 90%;
            border-collapse: collapse;
            margin-left: 2rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .data_table thead {
            background-color: #001f3f; /* Dark navy blue */
            color: white; /* White text */
        }

        .data_table th, .data_table td {
            padding: 12px;
            border: 1px solid #ddd;
        }


        .edit-button {
            background-color: #4CAF50; /* Green */
            color: white;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 2px 1px;
            cursor: pointer;
            border-radius: 4px;
        }
   

        .scrollable-table {
            display: block;
            max-height: 535px; 
            overflow-y: auto;
        }

        .top_container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            width 100%;
        }

        .buttons-container {
            display: flex;
            gap: 10px; /* Space between buttons */
        }



        .add_btn {
            background-color: #4CAF50; 
            color: white;
            padding: 5px 10px;
            border: none;
            font-size: 14px;
            border-radius: 4px;
            margin-left: 30px;
        }

        .remove_btn {
            background-color: #4CAF50; 
            color: white;
            padding: 5px 10px;
            border: none;
            font-size: 14px;
            border-radius: 4px;
        }

        .upload_btn {
            background-color: #ff5733; 
            color: white;
            padding: 5px 10px;
            border: none;
            font-size: 14px;
            border-radius: 4px;
        } 

        .low-stock {
            background-color: #ba0a0a; /* Red for low stock */
            color: white;
        }

        .approaching-stock {
            background-color: #dfd81b; /* Yellow for approaching stock */
        }

        .normal-stock {
            background-color: white; 
            
        }


        .buttons-container {
            display: flex;
            gap: 10px; 
        }

        .department_filter {
            display: flex;
            align-items: center;
            margin-right: 100px;    
        }

        .department_filter label {
            margin-right: 10px;
            font-weight: bold;
            color: #063478;
        }

        .department_filter select {
            appearance: none;
            width: 200px;
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
            font-size: 14px;
            color: #333;
            cursor: pointer;
        }

        .department_filter select:hover {
            background-color: #e6e6e6;
        }
                
    </style>
</head>
<body>
    <div class="container">
      <!--------------------Side Menu------------ -->
      <?php include(__DIR__).("/common/branch_sidebar.php"); ?>

      <!-------------------Header------------------->
      <div class="main-content">
          <?php include(__DIR__).("/common/branch_navbar.php"); ?>
          
          <!------------------Stock Section------------------>
          <div class="inside-content">
               <section class="stock_section" id ='stock'>
                  <h2 class="page_title">Stock / Inventory:</h2>

                  <div class="top_container">
                    <div class="department_filter">
                        <form method="GET" action="">
                            <label for="department">Filter by Department:</label>
                            <select name="department" id="department" onchange="this.form.submit()">
                                <option value="">All Departments</option>
                                <?php
                                $dept_query = "SELECT hospital_department_id, department_name FROM hospital_branches";
                                $dept_stmt = $conn->query($dept_query);
                                while ($row = $dept_stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = (isset($_GET['department']) && $_GET['department'] == $row['hospital_department_id']) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($row['hospital_department_id']) . "' $selected>" . htmlspecialchars($row['department_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </form>
                    </div>
                  </div>

                  <?php
                  // Prepare the inventory query
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

                  if (isset($_GET['department']) && $_GET['department'] != '') {
                      $department_id = intval($_GET['department']); // Ensure it's an integer
                      $query .= " WHERE medicalEquipment_list.hospital_department_id = :department_id";
                  }

                  // Prepare and execute the query
                  $stmt = $conn->prepare($query);
                  
                  if (isset($_GET['department']) && $_GET['department'] != '') {
                      $stmt->bindParam(':department_id', $department_id, PDO::PARAM_INT);
                  }

                  $stmt->execute();
                  
                  // Fetch inventory data
                  if ($stmt->rowCount() > 0) {
                      $inventory_data = $stmt->fetchAll(PDO::FETCH_ASSOC); 
                  } else {
                      $inventory_data = []; 
                  }
                  ?>
                  
                  <div class="scrollable-table">
                      <table class="data_table">
                          <thead>
                              <tr>
                                  <th>Item ID</th>
                                  <th>Item Name</th>
                                  <th>Description</th>
                                  <th>Quantity</th>
                                  <th>Hospital Branch</th>
                                  <th>Edit</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php 
                              // Loop through inventory data and display it in the table
                              foreach ($inventory_data as $inventory) {
                                  // Determine row color based on quantity
                                  $row_class = "";
                                  if ($inventory['qty'] < 10) {
                                      $row_class = "low-stock"; // Red color for low stock
                                  } elseif ($inventory['qty'] >= 10 && $inventory['qty'] <= 20) {
                                      $row_class = "approaching-stock"; // Yellow color for approaching stock
                                  } else {
                                      $row_class = "normal-stock"; // Default color for normal stock
                                  }
                                  
                                  echo "<tr class='$row_class' data-id='" . htmlspecialchars($inventory['equipment_ID']) . "'>";
                                  echo "<td>" . htmlspecialchars($inventory['equipment_ID']) . "</td>";
                                  echo "<td>" . htmlspecialchars($inventory['equipment_Name']) . "</td>";
                                  echo "<td>" . htmlspecialchars($inventory['equipment_description']) . "</td>";
                                  echo "<td>" . htmlspecialchars($inventory['qty']) . "</td>";
                                  echo "<td>" . htmlspecialchars($inventory['department_name']) . "</td>";
                                  echo "<td><button onclick='editQuantity(" . htmlspecialchars($inventory['equipment_ID']) . ", " . htmlspecialchars($inventory['qty']) . ")' class='edit-button'>Edit Qty</button></td>";
                                  echo "</tr>";
                              }
                              ?>
                              <!-- Modal for editing quantity -->
                              <div id="editModal" style="display:none; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); background:white; padding:20px; border-radius:8px;">
                                  <h3>Edit Quantity</h3>
                                  <input type="number" id="newQuantity" min="0">
                                  <button onclick="updateQuantity()">Update</button>
                                  <button onclick="closeModal()">Cancel</button>
                              </div>
                          </tbody>
                      </table>
                  </div>

              </section>
          </div>
      </div>
    </div>

<script>
// JavaScript functions remain unchanged...
let currentItemId = null;

function editQuantity(id, currentQty) {
    currentItemId = id;
    document.getElementById('newQuantity').value = currentQty;
    document.getElementById('editModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}

function updateQuantity() {
    const newQty = document.getElementById('newQuantity').value;

    fetch('branchStockUpdateQuantity.php', {
        method:'POST',
        headers:{
             'Content-Type':'application/x-www-form-urlencoded',
         },
         body:`id=${currentItemId}&qty=${newQty}`
     })
     .then(response => response.json())
     .then(data => {
         if (data.success) {
             // Update the quantity in the table
             const row = document.querySelector(`tr[data-id="${currentItemId}"]`);
             const qtyCell = row.querySelector('td:nth-child(4)');
             qtyCell.textContent = newQty;

             // Update the edit button's onclick attribute
             const editButton = row.querySelector('.edit-button');
             editButton.setAttribute('onclick', `editQuantity(${currentItemId}, ${newQty})`);

             // Update row color based on new quantity
             updateRowColor(row, newQty);

             closeModal();
         } else {
             alert('Failed to update quantity');
         }
     });
}

function updateRowColor(row, qty) {
    row.className = ''; // Reset class
    if (qty < 10) {
        row.classList.add('low-stock');
    } else if (qty >= 10 && qty <= 20) {
        row.classList.add('approaching-stock');
    } else {
        row.classList.add('normal-stock');
    }
}
</script>

</body>
</html>
