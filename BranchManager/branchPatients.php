<?php
session_start();

$current_page = 'patients';

// Check if the user is an branch manager
if ($_SESSION['role'] != 'branchManager') {
    header('Location: unauthorized.php');
    exit;
}
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
    <title>BranchManager Patient Records</title>
    <style>
        .patient_table {
            width: 90%;
            border-collapse: collapse;
            margin-left: 2rem;
            margin-top:2rem;
            margin-bottom: 2rem
        }

        .patient_table thead {
            background-color: #001f3f; /* Dark navy blue */
            color: white; /* White text */
        }
                
        .patient_table th, .patient_table td {
            padding: 12px;
            border: 1px solid #ddd;
        }
                
        .patient_table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .patient_table tr:hover {
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

        .top_container {
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

        .add_btn{
            background-color: #4CAF50; 
            color: white;
            padding: 5px 10px;
            border: none;
            font-size: 14px;
            border-radius: 4px;
            margin-left: 30px;
        }

        .remove_btn{
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
            
</style>
</head>
<body>
    <div class="container">
      <!--------------------Side Menu------------ -->
         <!--------------------Side Menu------------ -->
      <?php  include("../common/branch_sidebar.php"); ?>

<!-------------------Header------------------->
<div class="main-content">
    
<?php  include("../common/branch_navbar.php"); ?>
            <!------------------Patient Section------------------>
            <div class="inside-content">
                <section class="patient_records_section" id='patient_records'>
                    <h2 class="page_title">Patient Records:</h2>

                    <div class="top_container">
                        <div class="buttons-container">
                            <div class="add_box">
                                <button class = "add_btn" onclick="window.location.href='add_branchPatients.php'"><i class="ri-user-add-line"></i>   Add Patient</button>
                            </div>
                            <div class="remove_box">
                                <button class="remove_btn" onclick="window.location.href='remove_branchPatients.php'"><i class='bx bxs-minus-square'></i> Remove Patient</button>
                            </div>

                            <div class="upload_box">
                                <button class="upload_btn" onclick="window.location.href='upload_branchPatients.php'"><i class="ri-file-upload-fill"></i> Upload CVS File</button>
                            </div>

                            </div>
                                <div class="search_filter">
                                <i class="ri-search-line"></i>  
                                <input type="text" placeholder="search">
                            </div>
            </div>

                   

                    <div class="scrollable-table">
                    <table class="patient_table">
                    <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>GP Practice</th>
                            <th>Contact No</th>
                            <th>Emergency Contact No</th>
                            <th>Dial-Code</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>P1001</td>
                            <td>Emma</td>
                            <td>Thompson</td>
                            <td>emma.thompson@email.com</td>
                            <td>Oakwood Medical Centre</td>
                            <td>07700 900123</td>
                            <td>07700 900124</td>
                            <td>+44</td>
                            <td><button>Edit</button></td>
                        </tr>
                        
                        <tr>
                            <td>P1002</td>
                            <td>Oliver</td>
                            <td>Brown</td>
                            <td>oliver.brown@email.com</td>
                            <td>Riverside Health Practice</td>
                            <td>07700 900125</td>
                            <td>07700 900126</td>
                            <td>+44</td>
                            <td><button>Edit</button></td>
                        </tr>
                        
                        <tr>
                            <td>P1003</td>
                            <td>Sophia</td>
                            <td>Taylor</td>
                            <td>sophia.taylor@email.com</td>
                            <td>Greenfield Family Clinic</td>
                            <td>07700 900127</td>
                            <td>07700 900128</td>
                            <td>+44</td>
                            <td><button>Edit</button></td>
                        </tr>
                        
                        <tr>
                            <td>P1004</td>
                            <td>James</td>
                            <td>Wilson</td>
                            <td>james.wilson@email.com</td>
                            <td>Hillside Surgery</td>
                            <td>07700 900129</td>
                            <td>07700 900130</td>
                            <td>+44</td>
                            <td><button>Edit</button></td>
                        </tr>
                        
                        <tr>
                            <td>P1005</td>
                            <td>Ava</td>
                            <td>Martin</td>
                            <td>ava.martin@email.com</td>
                            <td>Central City Medical</td>
                            <td>07700 900131</td>
                            <td>07700 900132</td>
                            <td>+44</td>
                            <td><button>Edit</button></td>
                        </tr>

                        <tr>
                            <td>P1006</td>
                            <td>Ethan</td>
                            <td>Clark</td>
                            <td>ethan.clark@email.com</td>
                            <td>Lakeview Health Centre</td>
                            <td>07700 900133</td>
                            <td>07700 900134</td>
                            <td>+44</td>
                            <td><button>Edit</button></td>
                        </tr>

                        <tr>
                            <td>P1007</td>
                            <td>Mia</td>
                            <td>Harris</td>
                            <td>mia.harris@email.com</td>
                            <td>Meadowbrook GP Practice</td>
                            <td>07700 900135</td>
                            <td>07700 900136</td>
                            <td>+44</td>
                            <td><button>Edit</button></td>
                        </tr>

                        <tr>
                            <td>P1008</td>
                            <td>Noah</td>
                            <td>Lewis</td>
                            <td>noah.lewis@email.com</td>
                            <td>Sunnydale Medical Group</td>
                            <td>07700 900137</td>
                            <td>07700 900138</td>
                            <td>+44</td>
                            <td><button>Edit</button></td>
                        </tr>

                        <tr>
                            <td>P1009</td>
                            <td>Isabella</td>
                            <td>Walker</td>
                            <td>isabella.walker@email.com</td>
                            <td>Westfield Community Clinic</td>
                            <td>07700 900139</td>
                            <td>07700 900140</td>
                            <td>+44</td>
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
