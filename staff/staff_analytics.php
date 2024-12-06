<?php
session_start();

$current_page = 'analytics';

// Check if the user is correct
if ($_SESSION['role'] != 'gp') {
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
    <link rel="stylesheet" href="../css/main_theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Staff Analytics</title>
    <style>
        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }

        /* Graph Styles */
        .graph-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 20px;
            justify-content: space-evenly;
        }

        .graph-container .graph {
            flex: 1 1 calc(45% - 20px); /* Allows two graphs per row on large screens */
            max-width: 48%;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        canvas {
            display: block;
            width: 100% !important;
            height: auto !important;
        }

        /* General Styles */
        .card-header {
            background-color: #063478;
            color: white;
            text-align: center;
            font-weight: bold;
            width: 100%;
            height: 30px;
        }

        .graph h5 {
            text-align: center;
            margin-bottom: 10px;
            font-size: 18px;
        }

        @media screen and (max-width: 768px) {
            .graph-container .graph {
                flex: 1 1 100%; /* Full width on small screens */
                max-width: 100%;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <!--------------------Side Menu------------ -->
        <?php include("../common/staff_sidebar.php"); ?>

        <!-------------------Header------------------->
        <div class="main-content">
            <?php include("../common/staff_navbar.php"); ?>

            <!------------------Analytics Section------------------>
            <div class="inside-content">
                <section class="analytics_section" id="analytics">
                    <h2 class="page_title">Analytics:</h2>
                    <p class="desc" style="margin-left: 20px; margin-top: 20px;"></p>
                    
                    <!-- First Row of Graphs -->
                    <div class="graph-container">
                        <div class="graph">
                            <h5>Appointments per Month</h5>
                            <canvas id="appointmentsBarChart"></canvas>
                        </div>
                        <div class="graph">
                            <h5>Team Performance Metrics</h5>
                            <canvas id="staffPerformanceChart"></canvas>
                        </div>
                    </div>

                    <!-- Second Row of Graphs -->
                    <div class="graph-container">
                        <div class="graph">
                            <h5>Patient Demographics</h5>
                            <canvas id="patientDemographicsPieChart"></canvas>
                        </div>
                        <div class="graph">
                            <h5>Appointments Seen</h5>
                            <canvas id="appointmentsSeenPieChart"></canvas>
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
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Appointments',
                    data: [120, 150, 180, 130, 160, 200, 170, 190, 210, 180, 160, 150],
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

        // Pie Chart: Appointments Seen
        const ctxSeenPie = document.getElementById('appointmentsSeenPieChart').getContext('2d');
        new Chart(ctxSeenPie, {
            type: 'pie',
            data: {
                labels: ['Seen', 'Not Seen'],
                datasets: [{
                    data: [85, 15],
                    backgroundColor: ['#FF6384', '#36A2EB']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Appointments Seen'
                    }
                }
            }
        });

        // Pie Chart: Patient Demographics
        const ctxDemoPie = document.getElementById('patientDemographicsPieChart').getContext('2d');
        new Chart(ctxDemoPie, {
            type: 'pie',
            data: {
                labels: ['0-18', '19-35', '36-50', '51-65', '65+'],
                datasets: [{
                    data: [15, 30, 25, 20, 10],
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Patient Demographics'
                    }
                }
            }
        });

        // Stacked Bar Chart: Staff Performance Metrics
        const ctxStacked = document.getElementById('staffPerformanceChart').getContext('2d');
        new Chart(ctxStacked, {
            type: 'bar',
            data: {
                labels: ['Doctors', 'Nurses', 'Receptionist'],
                datasets: [
                    {
                        label: 'Patient Satisfaction (out of 5)',
                        data: [4.5, 4.2, 4.0],
                        backgroundColor: 'rgba(75, 192, 192, 0.6)'
                    },
                    {
                        label: 'Efficiency Score (out of 100)',
                        data: [85, 90, 88],
                        backgroundColor: 'rgba(153, 102, 255, 0.6)'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: { stacked: true },
                    y: { stacked: true, beginAtZero: true }
                }
            }
        });
    </script>
    <script src="assets/js/main.js"></script>
</body>
</html>
