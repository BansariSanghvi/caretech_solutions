<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/main_theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Settings</title>

    <style>
        /* General Styles */
        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .count-box {
            background-color: #ffffff;
            padding: 5px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 120px;
            width: 265px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .count-box:hover {
            transform: translateY(-5px); 
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        }

        .count-box h5 i {
            font-size: 24px;
            color: #4a90e2; 
            margin-right: 8px;
            vertical-align: middle;
        }

        .count-box h5 {
            font-size: 18px;
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .count-box h6 {
            font-size: 24px;
            font-weight: 700;
            color: #27ae60;
        }

        /* Quick Actions Styles */
        .card-header {
            background-color: #063478;
            color: white;
            text-align: center;
            font-weight: bold;
            height: 30px;
        }

        .tag-container {
            display: flex;
            flex-wrap: wrap;
            height: 80px;
            padding: 10px;
            justify-content: space-between;
            background-color: white;
        }

        .count-box {
            font-size: 16px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            transition: transform 0.3s ease;
        }

        .count-box:hover {
            transform: scale(1.05);
            background-color: #f1f1f1;
        }

        .count-box i {
            margin-right: 8px;
            font-size: 20px;
        }

        .graph-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin: 5px 0px;
            height: 320px;
        }

        .graph-container .graph {
            flex: 1;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        canvas {
            width: 100% !important;
            height: 260px !important;
        }

        .appointment_table {
            width: 93%;
            border-collapse: collapse;
            margin: 2rem;
        }

        .appointment_table thead {
            background-color: #001f3f;
            color: white;
        }

        .appointment_table th, .appointment_table td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        .appointment_table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .appointment_table tr:hover {
            background-color: #ddd;
        }

        .edit-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .scrollable-table {
            max-height: 250px; 
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
            gap: 10px;
        }

        .search_filter {
            display: flex;
            align-items: center;
            margin-right: 100px;
            gap: 5px;
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
        .announcement_box {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            height: 250px;
            width: 300px;
            margin-right: 25px;
        }
    </style>
</head>
<body>
    <div class="container">
      <!--------------------Side Menu------------ -->
         <!--------------------Side Menu------------ -->
      <?php  include("../common/staff_sidebar.php"); ?>

<!-------------------Header------------------->
<div class="main-content">
    
<?php  include("../common/staff_navbar.php"); ?>
            <!------------------Inner Section------------------>
            <div class="inside-content">
               <section class="staff_section" id ='staff_hub'>
                  <h2 class="page_title">Settings:</h2>
                  
                    <!-------Add the other elements under this------>
                    <!-- Top Metrics -->
                    <div class="metrics-container">
                        <div class="container-fluid">
                            <div class="row">
                                <!-- Metric Boxes -->
                                <button class="count-box" onclick="window.location.href='staff_forms.php'">
                                    <h5><i class="ri-hospital-fill"></i>Change Email</h5>
                                </button>
                                <button class="count-box" onclick="window.location.href='staff_forms.php'">
                                    <h5><i class="ri-hospital-fill"></i>Change Password</h5>
                                </button>
                                <button class="count-box" onclick="window.location.href='staff_forms.php'">
                                    <h5><i class="ri-hospital-fill"></i>Change Phone No</h5>
                                </button>
                                <button class="count-box" onclick="window.location.href='staff_forms.php'">
                                    <h5><i class="ri-hospital-fill"></i>Change Display Pic</h5>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Metrics -->
                    <div class="additional-metrics-container">
                        <div class="container-fluid">
                            <div class="row">
                                <button class="count-box" onclick="window.location.href='staff_forms.php'">
                                    <h5><i class="ri-hospital-fill"></i>Hospital Information</h5>
                                </button>
                                <button class="count-box" onclick="window.location.href='staff_forms.php'">
                                    <h5><i class="ri-hospital-fill"></i>Department Information</h5>
                                </button>
                                <button class="count-box" onclick="window.location.href='staff_forms.php'">
                                    <h5><i class="ri-hospital-fill"></i>Emergency Contacts</h5>
                                </button>
                                <button class="count-box" onclick="window.location.href='staff_forms.php'">
                                    <h5><i class="ri-hospital-fill"></i>Form</h5>
                                </button>
                            </div>
                        </div>
                    </div>

                  </section>
                  

               </section>
            </div>
            
        </div>
    </div>



    <script src="assets/js/main.js"></script>
</body>
</html>
