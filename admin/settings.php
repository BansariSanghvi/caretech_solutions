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
        /* Settings Section Styles */

        .settings-container {
            padding: 20px;
            border-radius: 8px;
            width: 95%;
            margin-left: 10px;
        }

        .settings-container h2 {
            margin: 0 0 20px;
            font-size: 24px;
            font-weight: bold;
            text-align: left;
            color: #000;
            text-decoration: underline;
        }

        .settings-grid {
            display: flex;
            gap: 30px;
            justify-content: space-between;
        }

        .settings-section {
            background-color: #fff;
            border-radius: 8px;
            padding: 15px;
            flex: 1;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .settings-section h4 {
            background-color: rgb(21, 10, 66);
            color: #fff;
            padding: 10px;
            border-radius: 4px 4px 0 0;
            margin: -15px -15px 10px;
            font-size: 15px;
        }

        .settings-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .settings-section li {
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            font-size: 16px;
            color: #333;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .settings-section li:hover {
            background-color: #f0f0f0;
        }

        .settings-section li:last-child {
            border-bottom: none;
        }
         

        
    </style>
</head>
<body>
    <div class="container">
        <!--------------------Side Menu------------ -->
        <?php include("../common/sidebar.php"); ?>

        <!-------------------Header------------------->
        <div class="main-content">
            <?php include("../common/navbar.php"); ?>

            <!------------------Inner Section------------------>
            <div class="inside-content">
                <section class="settings_section" id="settings_hub">
                    <h2 class="page_title">Settings:</h2>

                    <div class="settings-container">
                        <div class="settings-grid">
                            <!-- Account Section -->
                            <div class="settings-section">
                                <h4>Admin Account</h4>
                                <ul>
                                    <li onclick="window.location.href='user_accounts.php'">User Accounts</li>
                                    <li onclick="window.location.href='user_permissons_table.php'">User Permissions</li>
                                    <li>User Requests</li>
                                    
                                </ul>
                            </div>
                            <!-- Feedback Section -->
                            <div class="settings-section">
                                <h4>External</h4>
                                <ul>
                                    <li onclick = "window.location.href='admin_stock_inventory.php'">Medical Equipment</li>
                                    <li onclick="window.location.href='medicalSupplierList.php'">Supplier Hub</li>
                                    <li onclick="window.location.href='medical_associationsList.php'">Medical Associations</li>
                                </ul>
                            </div>

                            <div class="settings-section">
                                <h4>Accessibility</h4>
                                <ul>
                                    <li>Update Language</li>
                                </ul>
                            </div>

                            <!-- Report Problem Section -->
                            <div class="settings-section">
                                <h4 style = "background-color: #8b0303;">Report Problem</h4>
                                <ul>
                                    <li onclick = "window.location.href='report_problem.php'">Report Problem</li>
                                    <li onclick = "window.location.href='table_problem.php'">Table of Problems</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

    <script src="assets/js/main.js"></script>
</body>
</html>
