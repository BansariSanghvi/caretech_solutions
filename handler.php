<?php
ini_set('allow_url_fopen',1);
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
        require 'login.php';
        break;
    case '/login.php':
        require 'login.php';
        break;
    case '/admin':
        require 'index.php';
        break;
    case '/admin/index.php':
        require 'index.php';
        break;
    case '/admin/analytics.php':
        require 'analytics.php';
        break;
    case '/admin/staff_hub.php':
        require 'staff_hub.php';
        break;

    
    // This serves the main inventory page where AJAX will call the fetch updates function
    case '/admin/admin_stock_inventory.php':
        require __DIR__ . '/admin/admin_stock_inventory.php';
        break;

    // This handles the AJAX request to fetch inventory updates
    case '/admin/fetch_inventory_updates.php':
        require __DIR__ . '/admin/fetch_inventory_updates.php';
        break;

    
    case '/admin/medicalSupplierList.php':
        require 'medicalSupplierList.php';
        break;
    case '/admin/medical_associationsList.php':
        require 'medical_associationsList.php';
        break;
    case '/admin/past_orders.php':
        require 'past_orders.php';
        break;
    case '/admin/place_order_form.php':
        require 'place_order_form.php';
        break;
    case '/admin/report_problem.php':
        require 'report_problem.php';
        break;
    case '/admin/supply_orders.php':
        require 'supply_orders.php';
        break;
    case '/admin/admin_referal_view.php':
        require 'admin_referal_view.php';
        break;
    case '/admin/settings.php':
        require 'settings.php';
        break;
    case '/admin/user_accounts.php':
        require 'user_accounts.php';
        break;

    case '/admin/table_problem.php':
        require __DIR__ .'table_problem.php';
        break; 
    
    case '/admin/fetch_problems.php':
        require __DIR__.'fetch_problems.php';
        break;    
        
    case '/admin/user_permissons_table.php':
        require 'user_permissons_table.php';
        break;
    case '/admin/view_staff.php':
        require 'view_staff.php';
        break;

    case '/admin/user_requests_tb.php':
        require __DIR__.'user_requests_tb.php';
        break;
    case '/admin/fetch_requests.php':
        require __DIR__.'fetch_requests.php';
        break;  

    case '/admin/update_delivery.php':
        require 'update_delivery.php';
        break;    
    case '/admin/place_order_process.php':
        require 'place_order_process.php';
        break;
    case '/admin/add_staff.php':
        require 'add_staff.php';
        break;
    case '/admin/add_staff_process.php':
        require 'add_staff_process.php';
        break;
    case '/admin/remove_staff.php':
        require 'remove_staff.php';
        break;
    case '/admin/remove_staff_process.php':
        require 'remove_staff_process.php';
        break;
    case '/admin/upload_staff.php':
        require 'upload_staff.php';
        break;
    case '/admin/admin_view_patientsRecords.php':
        require 'admin_view_patientsRecords.php';
        break;
    case '/admin/add_patient_admin.php':
        require 'add_patient_admin.php';
        break;
    case '/admin/update_status.php':
        require 'update_status.php';
        break;
    case '/admin/update_referal_status.php':
        require 'update_referal_status.php';
        break;
    case '/admin/add_associations.php':
        require 'add_associations.php';
        break;
    case '/admin/add_external_assoc.php':
        require 'add_external_assoc.php';
        break;
    case '/admin/add_referal.php':
        require 'add_referal.php';
        break;
    case '/admin/admin_ref_process.php':
        require 'admin_ref_process.php';
        break;
    case '/admin/edit_inventory.php':
        require 'edit_inventory.php';
        break;
    
 
    case '/admin/remove_external_assoc.php':
        require 'remove_external_assoc.php';
        break;
    case '/admin/submit_problem.php':
        require 'submit_problem.php';
        break;
    
    /* Branch Manager Routes */
    
    case '/BranchManager':
        require 'branchDashboard.php';
        break;
    case '/BranchManager/branchDashboard.php':
        require 'branchDashboard.php';
        break;
    case '/BranchManager/add_branchPatients.php':
        require 'add_branchPatients.php';
        break; 
    case '/BranchManager/add_branchStaff.php;':
        require 'add_branchStaff.php';
        break;
    case '/BranchManager/add_branchStock.php':
        require 'add_branchStock.php';
        break;
    case '/BranchManager/branch_report_problem.php':
        require 'branch_report_problem.php';
        break;
    case '/BranchManager/branchAnalytics.php':
        require 'branchAnalytics.php';
        break;
    case '/BranchManager/branchApprovals.php':
        require 'branchApprovals.php';
        break; 
    case '/BranchManager/branchForm1.php':
        require 'branchForm1.php';
        break;
    case '/BranchManager/branchForm2.php':
        require 'branchForm2.php';
        break;
    case '/BranchManager/branchLetters.php':
        require 'branchLetters.php';
        break;
    case '/BranchManager/branchPatients.php':
        require 'branchPatients.php';
        break;
    case '/BranchManager/branchReferral.php':
        require 'branchReferral.php';
        break;  
    case '/BranchManager/branchReferralHistory':
        require 'branchReferralHistory.php';
        break;  
    case '/BranchManager/branchRequestPasswordChange.php':
        require 'branchRequestPasswordChange.php';
        break;
    case 'BranchManager/branchSettings.php':
        require 'branchSettings.php';
        break;            
    case '/BranchManager/branchStaff.php':
        require 'branchStaff.php';
        break;
    case '/BranchManager/branchStock.php':
        require 'branchStock.php';
    case '/BranchManager/branchStockUpdateQuantity.php':
        require 'branchStockUpdateQuantity.php';
        break;
    case '/BranchManager/edit_branchPatients.php':
        require 'edit_branchPatients.php';
        break;        
    case '/BranchManager/generate_letter.php':
        require 'generate_letter.php';
        break;
    case '/BranchManager/post_announcments.php':
        require 'post_announcments.php';
        break;
    case '/BranchManager/process_referral.php':
        require 'process_referral.php';
        break;
    case '/BranchManager/remove_BranchPatients.php':
        require 'remove_BranchPatients.php';
        break;
    case '/BranchManager/remove_BranchStaff.php':
        require 'remove_BranchStaff.php';
        break;
    case '/BranchManager/remove_BranchStock.php':
        require 'remove_BranchStock.php';
        break;
    case '/BranchManger/update_approval_status.php':
        require 'update_approval_status.php';
        break;
    case '/BranchManager/upload_branchPatients.php':
        require 'upload_branchPatients.php';
        break;
    case '/BranchManager/upload_branchStaff.php':
        require 'upload_branchStaff.php';
        break;
    case '/BranchManager/upload_branchStock.php':
        require 'upload_branchStock.php';
        break;
    
    /* Branch Staff Routing */ 
    case '/staff':
        require 'staff_dashboard.php';
        break;
    case '/staff/staff_dashboard.php':
        require 'staff_dashboard.php';
        break;
    case '/staff/staff_analytics.php':
        require 'staff_analytics.php';
        break;
    case '/staff/staff_approvals.php':
        require 'staff_approvals.php';
        break;
    case '/staff/staff_forms.php':
        require 'staff_forms.php';
        break;
    case '/staff/staff_patients_records.php':
        require 'staff_patients_records.php';
        break;
    case '/staff/staff_referral_form.php':
        require 'staff_referral_form.php';
        break;
    case '/staff/staff_report_form.php':
        require 'staff_report_form.php';
        break;
    case '/staff/staff_report_issue.php':
        require 'staff_report_issue.php';
        break;
    case '/staff/staff_request_form.php':
        require 'staff_request_form.php';
        break;                               
    case '/staff/staff_settings.php':
        require 'staff_settings.php';
        break;
    case '/staff/staff_staffhub.php':
        require 'staff_staffhub.php';
        break;
    default:
        http_response_code(404);
        echo @parse_url($_SERVER['REQUEST_URI'])['path'];
        exit("File not Found");
        
}
?>