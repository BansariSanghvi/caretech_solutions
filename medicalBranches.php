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
    width: 90%;
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
                    <h2 class="page_title">Verifed Medical Branches</h2>

                    <div class="staff_hub_top_container">
                        <div class="buttons-container">
                        <div class="add_staff_box">
                            <button class = "add_staff_btn" onclick="window.location.href='add_staff_form.php'"><i class="ri-user-add-line"></i>   Add Branch</button>
                        </div>
                    <div class="remove_staff_box">
                        <button class="remove_staff_btn"><i class='bx bxs-minus-square'></i>  Remove Branch</button>
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
                                <th>Branch ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Location</th>
                                <th>Postcode</th>
                                <th>Number</th>
                          
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                              <tr>
                                <td>2001</td>
                                <td>Sunnydale Hospital</td>
                                <td>Hospital</td>
                                <td>Sunnydale, California</td>
                                <td>90210</td>
                                <td>+1 555-1234</td>
                                
                                <td><button>Edit</button></td>
                            </tr>
                            <tr>
                                <td>2002</td>
                                <td>Greenfield Clinic</td>
                                <td>Clinic</td>
                                <td>Greenfield, Texas</td>
                                <td>75001</td>
                                <td>+1 555-5678</td>
                                
                                <td><button>Edit</button></td>
                            </tr>
                            <tr>
                                <td>2003</td>
                                <td>Mountain View Health Center</td>
                                <td>Health Center</td>
                                <td>Mountain View, Colorado</td>
                                <td>80501</td>
                                <td>+1 555-6789</td>
                                
                                <td><button>Edit</button></td>
                            </tr>
                            <tr>
                                <td>2004</td>
                                <td>Riverside Medical</td>
                                <td>Hospital</td>
                                <td>Riverside, California</td>
                                <td>92501</td>
                                <td>+44 555-2345</td>
                                
                                <td><button>Edit</button></td>
                            </tr>
                            <tr>
                                <td>2005</td>
                                <td>Westlake Specialist Clinic</td>
                                <td>Specialist Clinic</td>
                                <td>Westlake, Texas</td>
                                <td>78701</td>
                                <td>+1 555-3456</td>
                                
                                <td><button>Edit</button></td>
                            </tr>
                            <tr>
                                <td>2006</td>
                                <td>Maple Leaf Medical Center</td>
                                <td>Medical Center</td>
                                <td>Maple Leaf, Canada</td>
                                <td>M5A 1A1</td>
                                <td>+1 555-7890</td>
                                
                                <td><button>Edit</button></td>
                            </tr>
                            <tr>
                                <td>2007</td>
                                <td>Lakeside General</td>
                                <td>General Hospital</td>
                                <td>Lakeside, Illinois</td>
                                <td>60001</td>
                                <td>+1 555-9876</td>
                                
                                <td><button>Edit</button></td>
                            </tr>
                            <tr>
                                <td>2008</td>
                                <td>Starlight Medical</td>
                                <td>Medical Center</td>
                                <td>Starlight, Nevada</td>
                                <td>89501</td>
                                <td>+1 555-5432</td>
                                
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
