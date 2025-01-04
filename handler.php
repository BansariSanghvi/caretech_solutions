<?php
ini_set('allow_url_fopen', 1);

switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
    case '/login.php':
        require __DIR__ . '/login.php';
        break;
    
    case '/admin':
    case '/admin/index.php':
        require __DIR__ . '/admin/index.php';
        break;

    case '/admin/analytics.php':
        require __DIR__ . '/admin/analytics.php';
        break;

    case '/admin/staff_hub.php':
        require __DIR__ . '/admin/staff_hub.php';
        break;

    // Serve the main inventory page where AJAX calls the fetch updates function
    case '/admin/admin_stock_inventory.php':
        require __DIR__ . '/admin/admin_stock_inventory.php';
        break;

    // AJAX request to fetch inventory updates
    case '/admin/fetch_inventory_updates.php':
        require __DIR__ . '/admin/fetch_inventory_updates.php';
        break;

    case '/admin/medicalSupplierList.php':
        require __DIR__ . '/admin/medicalSupplierList.php';
        break;

    case '/admin/medical_associationsList.php':
        require __DIR__ . '/admin/medical_associationsList.php';
        break;

    case '/admin/past_orders.php':
        require __DIR__ . '/admin/past_orders.php';
        break;

    case '/admin/place_order_form.php':
        require __DIR__ . '/admin/place_order_form.php';
        break;

    case '/admin/report_problem.php':
        require __DIR__ . '/admin/report_problem.php';
        break;

    case '/admin/supply_orders.php':
        require __DIR__ . '/admin/supply_orders.php';
        break;

    case '/admin/admin_referal_view.php':
        require __DIR__ . '/admin/admin_referal_view.php';
        break;

    case '/admin/settings.php':
        require __DIR__ . '/admin/settings.php';
        break;

    case '/admin/user_accounts.php':
        require __DIR__ . '/admin/user_accounts.php';
        break;

    case '/admin/edit_inventory.php':
        require __DIR__ . '/admin/edit_inventory.php';
        break;

    case '/admin/add_staff.php':
        require __DIR__ . '/admin/add_staff.php';
        break;

    case '/admin/add_staff_process.php':
        require __DIR__ . '/admin/add_staff_process.php';
        break;

    case '/admin/remove_staff.php':
        require __DIR__ . '/admin/remove_staff.php';
        break;

    case '/admin/remove_staff_process.php':
        require __DIR__ . '/admin/remove_staff_process.php';
        break;

    case '/admin/upload_staff.php':
        require __DIR__ . '/admin/upload_staff.php';
        break;
    case '/admin/admin_view_patientsRecords.php':
        require __DIR__ .'/admin_view_patientsRecords.php';
        break;
    case '/admin/add_patient_admin.php':
        require __DIR__.'admin/add_patient_admin.php';
        break;
    case '/admin/update_status.php':
        require __DIR__.'admin/update_status.php';
        break;
    case '/admin/update_referal_status.php':
        require __DIR__.'admin/update_referal_status.php';
        break;
    case '/admin/add_associations.php':
        require __DIR__.'admin/add_associations.php';
        break;
    case '/admin/add_external_assoc.php':
        require __DIR__.'admin/add_external_assoc.php';
        break;
    case '/admin/add_referal.php':
        require __DIR__.'admin/add_referal.php';
        break;
    case '/admin/admin_ref_process.php':
        require __DIR__.'admin/admin_ref_process.php';
        break;
    case '/admin/remove_external_assoc.php':
        require __DIR__.'admin/remove_external_assoc.php';
        break;
    case '/admin/submit_problem.php':
        require __DIR__.'admin/submit_problem.php';
        break;
    
    /* Branch Manager Routes */
    
    case '/BranchManager':
        require __DIR__. '/BranchManager/branchDashboard.php';
        break;
    case '/BranchManager/add_branchPatients.php':
        require __DIR__. 'add_branchPatients.php';
        break; 
    case '/BranchManager/add_branchStaff.php;':
        require __DIR__. 'add_branchStaff.php';
        break;
    case '/BranchManager/add_branchStock.php':
        require __DIR__.'add_branchStock.php';
        break;
    case '/BranchManager/branch_report_problem.php':
        require __DIR__.'branch_report_problem.php';
        break;
    case '/BranchManager/branchAnalytics.php':
        require __DIR__.'branchAnalytics.php';
        break;
    case '/BranchManager/branchApprovals.php':
        require __DIR__.'branchApprovals.php';
        break; 
    case '/BranchManager/branchForm1.php':
        require __DIR__.'branchForm1.php';
        break;
    case '/BranchManager/branchForm2.php':
        require __DIR__.'branchForm2.php';
        break;
    case '/BranchManager/branchLetters.php':
        require __DIR__.'branchLetters.php';
        break;
    case '/BranchManager/branchPatients.php':
        require __DIR__.'branchPatients.php';
        break;
    case '/BranchManager/branchReferral.php':
        require __DIR__.'branchReferral.php';
        break;  
    case '/BranchManager/branchReferralHistory':
        require __DIR__.'branchReferralHistory.php';
        break;  
    case '/BranchManager/branchRequestPasswordChange.php':
        require __DIR__.'branchRequestPasswordChange.php';
        break;
    case 'BranchManager/branchSettings.php':
        require __DIR__.'branchSettings.php';
        break;            
    case '/BranchManager/branchStaff.php':
        require __DIR__.'branchStaff.php';
        break;
    case '/BranchManager/branchStock.php':
        require __DIR__.'branchStock.php';
        break;
    case '/BranchManager/branchStockUpdateQuantity.php':
        require __DIR__.'branchStockUpdateQuantity.php';
        break;
    case '/BranchManager/edit_branchPatients.php':
        require __DIR__.'edit_branchPatients.php';
        break;        
    case '/BranchManager/generate_letter.php':
        require __DIR__.'generate_letter.php';
        break;
    case '/BranchManager/post_announcments.php':
        require __DIR__.'post_announcments.php';
        break;
    case '/BranchManager/process_referral.php':
        require __DIR__.'process_referral.php';
        break;
    case '/BranchManager/remove_BranchPatients.php':
        require __DIR__.'remove_BranchPatients.php';
        break;
    case '/BranchManager/remove_BranchStaff.php':
        require __DIR__.'remove_BranchStaff.php';
        break;
    case '/BranchManager/remove_BranchStock.php':
        require __DIR__.'remove_BranchStock.php';
        break;
    case '/BranchManger/update_approval_status.php':
        require __DIR__.'update_approval_status.php';
        break;
    case '/BranchManager/upload_branchPatients.php':
        require __DIR__.'upload_branchPatients.php';
        break;
    case '/BranchManager/upload_branchStaff.php':
        require __DIR__.'upload_branchStaff.php';
        break;
    case '/BranchManager/upload_branchStock.php':
        require __DIR__.'upload_branchStock.php';
        break;
    
    /* Branch Staff Routing */ 
    case '/staff':
        require __DIR__.'staff_dashboard.php';
        break;
    case '/staff/staff_dashboard.php':
        require __DIR__.'staff_dashboard.php';
        break;
    case '/staff/staff_analytics.php':
        require __DIR__.'staff_analytics.php';
        break;
    case '/staff/staff_approvals.php':
        require __DIR__.'staff_approvals.php';
        break;
    case '/staff/staff_forms.php':
        require __DIR__.'staff_forms.php';
        break;
    case '/staff/staff_patients_records.php':
        require __DIR__.'staff_patients_records.php';
        break;
    case '/staff/staff_referral_form.php':
        require __DIR__.'staff_referral_form.php';
        break;
    case '/staff/staff_report_form.php':
        require __DIR__.'staff_report_form.php';
        break;
    case '/staff/staff_report_issue.php':
        require __DIR__.'staff_report_issue.php';
        break;
    case '/staff/staff_request_form.php':
        require __DIR__.'staff_request_form.php';
        break;                               
    case '/staff/staff_settings.php':
        require __DIR__.'staff_settings.php';
        break;
    case '/staff/staff_staffhub.php':
        require __DIR__.'staff_staffhub.php';
        break;
    default:
        http_response_code(404);
        echo @parse_url($_SERVER['REQUEST_URI'])['path'];
        exit("File not Found");
        
}
?>