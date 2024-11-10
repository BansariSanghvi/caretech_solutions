<?php
session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
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
    <link rel="stylesheet" href="css/main_theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Admin Dashboard</title>

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
            gap: 0;
            justify-content: space-between;
        }

        .count-box {
            background-color: #ffffff;
            padding: 5px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 120px; /* Fixed height for uniform size */
            width: 265px;
            display: flex;
            flex-direction: column;
            justify-content: center; /* Center content vertically */ 
        }

        .count-box:hover {
            transform: translateY(-5px); 
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2); /* Enhanced shadow */
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
            width: 1150px;
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

        /* Quick Action Buttons */
        .big-button {
            font-size: 16px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            border: none;
            box-shadow: none;
            padding: 10px 20px;
            margin: 5px;
            transition: transform 0.3s ease;
        }

        .big-button:hover {
            transform: scale(1.05);
            background-color: #f1f1f1;
        }

        /* Button Icon Styling */
        .big-button i {
            margin-right: 8px;
            font-size: 20px;
        }

        
        .graph-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-top: 10px;
            margin-left: 33px;
            margin-right: 33px;
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
        
    </style>  

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <!-- Side Menu -->
        <?php include("common/sidebar.php"); ?>

        <!-- Main Content -->
        <div class="main-content">
            <?php include("common/navbar.php"); ?>

            <!-- Dashboard Section -->
            <div class="inside-content">
                <section class="dashboard_section" id="dashboard">
                    <h2 class="page_title">Dashboard:</h2>
                    
                    <!-- Top Metrics -->
                    <div class="container-fluid">
                        <div class="row">
                            <!-- Box 1 -->
                            <div class="col-md-3">
                                <div class="count-box">
                                    <h5><i class="ri-currency-fill"></i>Total Revenue</h5>
                                    <h6>£20,000</h6>
                                </div>
                            </div>

                            <!-- Box 2 -->
                            <div class="col-md-3">
                                <div class="count-box">
                                    <h5><i class="ri-hospital-line"></i>Total Branches</h5>
                                    <h6>25</h6>
                                </div>
                            </div>

                            <!-- Box 3 -->
                            <div class="col-md-3">
                                <div class="count-box">
                                    <h5><i class="ri-user-fill"></i>Total Patients</h5>
                                    <h6>1,200</h6>
                                </div>
                            </div>

                            <!-- Box 4 -->
                            <div class="col-md-3">
                                <div class="count-box">
                                    <h5><i class="ri-add-box-fill"></i>Total Appointments</h5>
                                    <h6>300</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Tab -->
                    <div class="col-md-18">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            Quick Actions
                                        </div>
                                        <div class="card-body">
                                            <div class="tag-container">
                                                <!-- Quick Action Buttons -->
                                                <button class="btn btn-default big-button" onclick="window.location.href='medicineList.php'">
                                                    <i class="ri-folder-4-fill"></i> Inventory
                                                </button>

                                                <button class="btn btn-default big-button" onclick="window.location.href='staff_hub.php'">
                                                    <i class="ri-group-2-fill"></i> Staff Hub
                                                </button>

                                                <button class="btn btn-default big-button" onclick="window.location.href='medicalBranches.php'">
                                                    <i class="ri-hospital-fill"></i> Branches
                                                </button>

                                                <button class="btn btn-default big-button" onclick="window.location.href='analytics.php'">
                                                    <i class="ri-line-chart-fill"></i> Analytics
                                                </button>

                                                <button class="btn btn-default big-button">
                                                    <i class="ri-file-list-3-fill"></i> Orders
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <!-- Graphs Split into Two Equal Parts -->
                    <div class="graph-container">
                        <!-- Left Graph: Appointments per Month -->
                        <div class="graph">
                            <h5>Appointments per Month</h5>
                            <canvas id="appointmentsBarChart"></canvas>
                        </div>

                        <!-- Right Graph: Revenue per Quarter -->
                        <div class="graph">
                            <h5>Revenue per Quarter</h5>
                            <canvas id="revenueLineChart"></canvas>
                        </div>
                    </div>
                    
                </section>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Bar Chart: Appointments per Month
        const ctxBar = document.getElementById('appointmentsBarChart').getContext('2d');
        const appointmentsBarChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], // Months
                datasets: [{
                    label: 'Appointments',
                    data: [120, 150, 180, 130, 160, 200, 170, 190, 210, 180, 160, 150], // Example data for each month
                    backgroundColor: '#4e73df',
                    borderColor: '#4e73df',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Line Chart Example for Revenue per Quarter
        var revenueLineChart = new Chart(document.getElementById("revenueLineChart"), {
        type: "line", // Set chart type to "line" for revenue
        data: {
          labels: ["Q1", "Q2", "Q3", "Q4"], // Quarters
          datasets: [{
            label: "Revenue",
            data: [10000, 5000, 20000, 25000], // Sample data for revenue
            fill: false, // No fill for the area under the line (line-only chart)
            borderColor: "rgba(255, 99, 132, 1)", // Line color (red)
            borderWidth: 2, // Line thickness
            tension: 0.4 // Smooth the line curve
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true, // Keep the aspect ratio
        scales: {
            y: {
                beginAtZero: true // Ensure the y-axis starts from zero
            }
        }
    }
});
    </script>

</body>
</html>
