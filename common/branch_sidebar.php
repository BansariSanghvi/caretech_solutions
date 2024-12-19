<section id="menu">
    <div class="logo">
        <img src="../img/heart.png" alt="">
        <h3 class="name">CareTech Solutions</h3>
    </div>
    <div class="items">
        <li class="<?php echo ($current_page == 'dashboard') ? 'active' : ''; ?>">
            <i class='bx bxs-home'></i><a href="branchDashboard.php">Dashboard</a>
        </li>
        <li class="<?php echo ($current_page == 'staff') ? 'active' : ''; ?>">
            <i class='bx bxs-user-detail'></i><a href="branchStaff.php">Staff Hub</a>
        </li>
        <li class="<?php echo ($current_page == 'patients') ? 'active' : ''; ?>">
            <i class='bx bx-male-female'></i><a href="branchPatients.php">Patient Records</a>
        </li>
        <li class="<?php echo ($current_page == 'stock') ? 'active' : ''; ?>">
            <i class='bx bx-cabinet'></i><a href="branchStock.php">Stock / Inventory</a>
        </li>
        <li class="<?php echo ($current_page == 'analytics') ? 'active' : ''; ?>">
            <i class='bx bx-line-chart'></i><a href="branchAnalytics.php">Analytics</a>
        </li>
        <li class="<?php echo ($current_page == 'approvals') ? 'active' : ''; ?>">
            <i class='bx bxs-check-circle'></i><a href="branchApprovals.php">Approvals</a>
        </li>
        <li class="dropdown <?php echo ($current_page == 'forms') ? 'active' : ''; ?>">
            <i class='bx bxs-file'></i><a href="#">Forms</a>
            <ul class="dropdown-menu">
                <li><a href="branchLetter.php">Letter Generation</a></li>
                <li><a href="branchReferral.php">Referral Form</a></li>
            </ul>
        </li>
        <li class="<?php echo ($current_page == 'settings') ? 'active' : ''; ?>">
            <i class='bx bxs-cog'></i><a href="branchSettings.php">Settings</a>
        </li>
        <li class="<?php echo ($current_page == 'report') ? 'active' : ''; ?>">
            <i class="ri-alert-fill"></i><a href="branch_report_problem.php">Report Problem</a>
        </li>
    </div>
</section>