<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main_theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Branches</title>

    <style>
.staff_table {
    width: 93%;
    border-collapse: collapse;
    margin-left: 2rem;
    margin-top:2rem;
    margin-bottom: 2rem
}

.staff_table thead {
    background-color: #001f3f; /* Dark navy blue */
    color: white; /* White text */
}
        
.staff_table th, .staff_table td {
    padding: 12px;
    border: 1px solid #ddd;
}
        
.staff_table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.staff_table tr:hover {
    background-color: #ddd;
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

.staff_hub_top_container {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
     
}

.buttons-container {
    display: flex;
    gap: 10px; /* Space between buttons */
}

.search_filter {
    display: flex;
    align-items: center;
    margin-right: 100px;
    gap: 5px; /* Space between the icon and input */
}

.search_filter input {
    padding: 5px 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.search_filter i {
    color: #888; 
    font-size: 20px; 
}

.add_staff_btn{
    background-color: #4CAF50; 
    color: white;
    padding: 5px 10px;
    border: none;
    font-size: 14px;
    border-radius: 4px;
    margin-left: 30px;
}

.remove_staff_btn{
    background-color: #4CAF50; 
    color: white;
    padding: 5px 10px;
    border: none;
    font-size: 14px;
    border-radius: 4px;
}
        
       
</style>
</head>
<body>
    <div class="container">
        <!--------------------Side Menu------------ -->
        <?php include("common/sidebar.php"); ?>

        <!-------------------Header------------------->
        <div class="main-content">
            <?php include("common/navbar.php"); ?>

            <!------------------Dashboard Section------------------>
            <div class="inside-content">
                <section class="staff_hub_section" id='staff_hub'>
                    <h2 class="page_title">Verifed Medication</h2>

                    <div class="staff_hub_top_container">
                        <div class="buttons-container">
                        <div class="add_staff_box">
                            <button class = "add_staff_btn" onclick="window.location.href='add_medication.php'"><i class="ri-user-add-line"></i>   Add Medication</button>
                        </div>
                    <div class="remove_staff_box">
                        <button class="remove_staff_btn"><i class='bx bxs-minus-square'></i>  Remove Medication</button>
                    </div>
                    </div>
                        <div class="search_filter">
                        <i class="ri-search-line"></i>
                        <input type="text" placeholder="search">
                    </div>
            </div>
                   

                    <div class="scrollable-table">
                    <table class="staff_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Drug Type</th>
                                <th>Side Effects</th>
                                <th>Supplier</th>
                                <th>Number</th>
                                <th>Price</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>3001</td>
                            <td>Paracetamol</td>
                            <td>Painkiller</td>
                            <td>Headache, Dizziness</td>
                            <td>Pharma Co.</td>
                            <td>+1 555-1122</td>
                            <td>£5.20</td>
                            <td><button>Edit</button></td>
                        </tr>
                        <tr>
                            <td>3002</td>
                            <td>Amoxicillin</td>
                            <td>Antibiotic</td>
                            <td>Nausea, Diarrhea</td>
                            <td>MedSupply Ltd.</td>
                            <td>+1 555-2233</td>
                            <td>£8.50</td>
                            <td><button>Edit</button></td>
                        </tr>
                        <tr>
                            <td>3003</td>
                            <td>Ibuprofen</td>
                            <td>Painkiller</td>
                            <td>Stomach upset, Dizziness</td>
                            <td>HealthCorp</td>
                            <td>+1 555-3344</td>
                            <td>£8.50</td>
                            <td><button>Edit</button></td>
                        </tr>
                        <tr>
                            <td>3004</td>
                            <td>Loratadine</td>
                            <td>Antihistamine</td>
                            <td>Dry mouth, Drowsiness</td>
                            <td>AllergyMed</td>
                            <td>+1 555-4455</td>
                            <td>£8.50</td>
                            <td><button>Edit</button></td>
                        </tr>
                        <tr>
                            <td>3005</td>
                            <td>Aspirin</td>
                            <td>Painkiller</td>
                            <td>Gastric discomfort, Nausea</td>
                            <td>Pharmalink</td>
                            <td>+1 555-5566</td>
                            <td>£8.50</td>
                            <td><button>Edit</button></td>
                        </tr>
                        <tr>
                            <td>3006</td>
                            <td>Metformin</td>
                            <td>Antidiabetic</td>
                            <td>Stomach upset, Lactic acidosis</td>
                            <td>Diabetes Meds</td>
                            <td>+1 555-6677</td>
                            <td>£8.50</td>
                            <td><button>Edit</button></td>
                        </tr>
                        <tr>
                            <td>3007</td>
                            <td>Salbutamol</td>
                            <td>Bronchodilator</td>
                            <td>Shaky hands, Increased heart rate</td>
                            <td>RespiraTech</td>
                            <td>+1 555-7788</td>
                            <td>£8.50</td>
                            <td><button>Edit</button></td>
                        </tr>
                        <tr>
                            <td>3008</td>
                            <td>Omeprazole</td>
                            <td>Proton pump inhibitor</td>
                            <td>Headache, Diarrhea</td>
                            <td>GastroMed</td>
                            <td>+1 555-8899</td>
                            <td>£4.50</td>
                            <td><button>Edit</button></td>
                        </tr>
                        <tr>
                            <td>3009</td>
                            <td>Simvastatin</td>
                            <td>Cholesterol-lowering</td>
                            <td>Muscle pain, Headache</td>
                            <td>CardioMed</td>
                            <td>+1 555-9900</td>
                            <td>£9.50</td>
                            <td><button>Edit</button></td>
                        </tr>
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>
</div>

    <script src="assets/js/main.js"></script>
</body>
</html>
