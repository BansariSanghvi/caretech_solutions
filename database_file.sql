/* SECTION 1 - TABLE CREATION */

-- Table for patient records
CREATE TABLE patient_records (
    patient_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    firstName VARCHAR(20),
    lastName VARCHAR(20),
    email VARCHAR(50),
    phone_no CHAR(11),
    dateOfBirth INT(10),  -- You may want to change this to DATE for better date handling
    emergency_contact INT(10),
    emergency_contact_name CHAR(255),
    patient_history VARCHAR(255),
    isRegistered_NHS BOOLEAN,
    staff_id INT(10),
    hospital_id INT(10),
    last_seen_date INT(8),  -- Again, change this to DATE if you want proper date handling
    branch_id INT(10),    

    FOREIGN KEY (staff_id) REFERENCES staff_records(staff_id),
    FOREIGN KEY (hospital_id) REFERENCES hospital_info(hospital_id),
    FOREIGN KEY (branch_id) REFERENCES branches(branch_id)
);

-- Table for staff records
CREATE TABLE staff_records (
    staff_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    fname VARCHAR(20),
    lname VARCHAR(20),
    address VARCHAR(255),
    staff_phone_no CHAR(10),  -- Changed to CHAR(10) for phone numbers
    email VARCHAR(255),
    role VARCHAR(255),
    department VARCHAR(200),
    hospital_id INT(10),
    
    FOREIGN KEY (hospital_id) REFERENCES hospital_info(hospital_id)
);

-- Table for hospital information
CREATE TABLE hospital_info (
    hospital_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    hname VARCHAR(255),
    hospital_address VARCHAR(255),
    hospital_phone CHAR(11),  -- Changed to CHAR(11) for phone numbers
    hospital_email VARCHAR(255)
);

-- Table for branches of hospitals
CREATE TABLE branches (
    branch_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
    branch_name VARCHAR(255),
    branch_email VARCHAR(255),   
    hospital_id INT(10),

    FOREIGN KEY (hospital_id) REFERENCES hospital_info(hospital_id)
);

-- Table for request forms
CREATE TABLE request_form (
    request_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
    request_type VARCHAR(255),
    summary_notes VARCHAR(255),
    staff_id INT(10),
    hospital_id INT(10),    
    branch_id INT(10),

    FOREIGN KEY (staff_id) REFERENCES staff_records(staff_id),
    FOREIGN KEY (hospital_id) REFERENCES hospital_info(hospital_id),
    FOREIGN KEY (branch_id) REFERENCES branches(branch_id)
);

-- Table for prescription orders
CREATE TABLE prescription_order (
    prescription_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
    patient_id INT(10),
    hospital_id INT(10),
    to_address VARCHAR(255),
    from_address VARCHAR(255),
    date_issued INT(8),  -- Consider changing this to DATE for better date handling
    isrepeat BOOLEAN,
    isNHSCovered BOOLEAN,
    order_status VARCHAR(20) DEFAULT 'Pending',

    FOREIGN KEY (hospital_id) REFERENCES hospital_info(hospital_id),
    FOREIGN KEY (patient_id) REFERENCES patient_records(patient_id)
);

-- Table for prescription items
CREATE TABLE prescription_items (
    item_ID INT PRIMARY KEY AUTO_INCREMENT,          
    prescription_id INT NOT NULL,                    
    drugID INT NOT NULL,                            
    dosage VARCHAR(50) NOT NULL,                    
    frequency VARCHAR(50) NOT NULL,               
    duration VARCHAR(50) NOT NULL,                
    notes VARCHAR(255),
    
    FOREIGN KEY (drugID) REFERENCES drugs_list(drugID), 
    FOREIGN KEY (prescription_id) REFERENCES prescription_order(prescription_id)
);

-- Table for drugs list
CREATE TABLE drugs_list (
    drugID INT PRIMARY KEY AUTO_INCREMENT,          
    drugName VARCHAR(100) NOT NULL,                 
    manufacturer VARCHAR(100),                      
    description VARCHAR(255),
    price INT(10)
);

-- Table for users (e.g., for login and permissions)
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT, 
    user_type VARCHAR(255), 
    user_name VARCHAR(255),
    user_email VARCHAR(255),
    user_password VARCHAR(255),
    user_level_id INT(3),
    
    FOREIGN KEY (user_level_id) REFERENCES user_level(user_level_id)
);

-- Table for user levels (roles, access levels)
CREATE TABLE user_level (
    user_level_id INT PRIMARY KEY AUTO_INCREMENT, 
    user_type VARCHAR(255), 
    description VARCHAR(255)
);


/* SECTION 2 - Adding Data */

INSERT INTO patient_records 
(firstName, lastName, email, phone_no, dateOfBirth, emergency_contact, emergency_contact_name, patient_history, isRegistered_NHS, staff_id, hospital_id, last_seen_date, branch_id) 
VALUES
('John', 'Doe', 'john.doe@example.com', '12345678901', 25012004, 9876543210, 'Jane Doe', 'Diabetes', 1, 1, 1, 20231101, 1),
('Jane', 'Smith', 'jane.smith@example.com', '12345678902', 13051998, 9876543211, 'John Smith', 'Asthma', 1, 2, 1, 20231028, 2),
('Michael', 'Brown', 'michael.brown@example.com', '12345678903', 19021981, 9876543212, 'Sarah Brown', 'Hypertension', 0, 3, 2, 20231115, 2),
('Emily', 'Davis', 'emily.davis@example.com', '12345678904', 14072001, 9876543213, 'Thomas Davis', 'None', 1, 4, 3, 20231103, 3),
('Daniel', 'Wilson', 'daniel.wilson@example.com', '12345678905', 22032006, 9876543214, 'Laura Wilson', 'Chronic Pain', 0, 5, 3, 20231030, 3),
('Sophia', 'Taylor', 'sophia.taylor@example.com', '12345678906', 15022003, 9876543215, 'Mark Taylor', 'None', 1, 6, 4, 20231104, 4),
('Liam', 'Anderson', 'liam.anderson@example.com', '12345678907', 20091975, 9876543216, 'Nora Anderson', 'Epilepsy', 0, 7, 4, 20231106, 4),
('Ava', 'Thomas', 'ava.thomas@example.com', '12345678908', 19051963, 9876543217, 'Jake Thomas', 'Heart Disease', 1, 8, 5, 20231020, 5),
('Noah', 'Jackson', 'noah.jackson@example.com', '12345678909', 23121921, 9876543218, 'Ethan Jackson', 'Arthritis', 0, 9, 5, 20231101, 5),
('Mia', 'White', 'mia.white@example.com', '12345678910', 05012004, 9876543219, 'Emma White', 'None', 1, 10, 6, 20231105, 6);


INSERT INTO staff_records (fname, lname, address, staff_phone_no, email, role, department, hospital_id)
VALUES
('Mark', 'Carter', '123 Main St, City', '0123456789', 'mark.carter@cityhospital.com', 'Doctor', 'General Medicine', 1),
('Susan', 'Adams', '456 Oak St, Valley', '0123456790', 'susan.adams@greenvalleyhospital.com', 'Doctor', 'Pediatrics', 2),
('James', 'Wilson', '789 Pine St, City', '0123456791', 'james.wilson@cityhospital.com', 'Nurse', 'Emergency', 1),
('Alan', 'Garcia', '101 Maple St, Valley', '0123456792', 'alan.garcia@greenvalleyhospital.com', 'Doctor', 'Cardiology', 2),
('Emily', 'Martinez', '102 Birch St, Lakeside', '0123456793', 'emily.martinez@lakesidemedical.com', 'Nurse', 'ICU', 3),
('Linda', 'Moore', '103 Elm St, City', '0123456794', 'linda.moore@cityhospital.com', 'Doctor', 'Orthopedics', 1),
('Robert', 'Lee', '104 Cedar St, Lakeside', '0123456795', 'robert.lee@lakesidemedical.com', 'Doctor', 'Neurology', 3),
('Sarah', 'Kim', '105 Walnut St, Valley', '0123456796', 'sarah.kim@greenvalleyhospital.com', 'Nurse', 'Surgery', 2),
('Brian', 'Davis', '106 Willow St, City', '0123456797', 'brian.davis@cityhospital.com', 'Doctor', 'General Surgery', 1),
('Olivia', 'Jackson', '107 Pine St, Lakeside', '0123456798', 'olivia.jackson@lakesidemedical.com', 'Doctor', 'Pediatrics', 3);



INSERT INTO hospital_info (hospital_id, hname, hospital_address, hospital_phone, hospital_email) 
VALUES
(1, 'General Hospital', '100 Main Street', 9876543210, 'contact@generalhospital.com'),
(2, 'City Medical Center', '200 City Avenue', 9876543211, 'info@citymedical.com'),
(3, 'Community Health', '300 State Road', 9876543212, 'help@communityhealth.com'),
(4, 'Wellness Hospital', '400 Wellness Blvd', 9876543213, 'wellness@hospital.com'),
(5, 'CarePoint Clinic', '500 Care Street', 9876543214, 'contact@carepoint.com'),
(6, 'Advanced Medical', '600 Advanced Road', 9876543215, 'support@advancedmedical.com'),
(7, 'Northside Hospital', '700 North Avenue', 9876543216, 'northside@hospital.com'),
(8, 'Lakeside Clinic', '800 Lake Drive', 9876543217, 'lakeside@clinic.com'),
(9, 'RiverHealth Center', '900 River Street', 9876543218, 'riverhealth@hospital.com'),
(10, 'MetroCare Hospital', '1000 Metro Parkway', 9876543219, 'metrocare@hospital.com');


INSERT INTO branches (branch_name, branch_email, hospital_id) 
VALUES
('Branch A', 'branchA@generalhospital.com', 1),
('Branch B', 'branchB@citymedical.com', 2),
('Branch C', 'branchC@communityhealth.com', 3),
('Branch D', 'branchD@wellnesshospital.com', 4),
('Branch E', 'branchE@carepointclinic.com', 5),
('Branch F', 'branchF@advancedmedical.com', 6),
('Branch G', 'branchG@northsidehospital.com', 7),
('Branch H', 'branchH@lakesideclinic.com', 8),
('Branch I', 'branchI@riverhealthcenter.com', 9),
('Branch J', 'branchJ@metrocarehospital.com', 10);


INSERT INTO request_form (request_type, summary_notes, staff_id, hospital_id, branch_id) 
VALUES
('Medication', 'Request for painkillers', 1, 1, 1),
('Appointment', 'Follow-up visit', 2, 2, 2),
('Referral', 'Refer to specialist', 3, 1, 3),
('Lab Test', 'Blood work needed', 4, 3, 4),
('Radiology', 'X-ray required', 5, 2, 5),
('Medication', 'Prescription refill', 6, 3, 6),
('Surgery', 'Schedule procedure', 7, 1, 7),
('Therapy', 'Request for therapy', 8, 2, 8),
('Medical Records', 'Retrieve patient history', 9, 3, 9),
('Billing', 'Invoice request', 10, 1, 10);

INSERT INTO prescription_order (patient_id, hospital_id, to_address, from_address, date_issued, isrepeat, isNHSCovered, order_status) 
VALUES
(1, 1, '123 Elm St', 'Hospital Pharmacy', 20231101, 0, 1, 'Pending'),
(2, 2, '456 Oak Ave', 'City Medical', 20231102, 1, 1, 'Approved'),
(3, 3, '789 Pine Rd', 'Community Health', 20231103, 1, 0, 'Dispensed'),
(4, 4, '321 Cedar Ln', 'Wellness Pharmacy', 20231104, 0, 0, 'Pending'),
(5, 5, '654 Maple Dr', 'CarePoint Clinic', 20231105, 1, 1, 'Rejected'),
(6, 6, '987 Spruce Wy', 'Advanced Medical', 20231106, 0, 1, 'Pending'),
(7, 7, '135 Birch St', 'Northside Pharmacy', 20231107, 0, 0, 'Dispensed'),
(8, 8, '246 Aspen Ct', 'Lakeside Clinic', 20231108, 1, 1, 'Approved'),
(9, 9, '369 Willow Ln', 'RiverHealth', 20231109, 0, 0, 'Pending'),
(10, 10, '975 Poplar Rd', 'MetroCare Pharmacy', 20231110, 1, 1, 'Pending');



INSERT INTO prescription_items (prescription_id, drugID, dosage, frequency, duration, notes)
VALUES 
(1, 1, '500 mg', 'Twice a day', '7 days', 'Take with food'),
(2, 2, '1 tablet', 'Once a day', '5 days', 'Morning only'),
(3, 3, '250 mg', 'Three times a day', '10 days', ''),
(4, 4, '10 ml', 'Every 6 hours', '3 days', 'Shake well'),
(5, 5, '100 mg', 'Once a day', '7 days', 'Before sleep'),
(6, 6, '500 mg', 'Twice a day', '5 days', 'Take after meals'),
(7, 7, '50 mg', 'Once a day', '3 days', 'Take in the morning'),
(8, 8, '200 mg', 'Three times a day', '7 days', ''),
(9, 9, '75 mg', 'Twice a day', '10 days', 'Take with plenty of water'),
(10, 10, '250 mg', 'Once a day', '7 days', 'Take with food');


INSERT INTO drugs_list (drugName, manufacturer, description, price)
VALUES 
('Paracetamol', 'ABC Pharma', 'Pain reliever/fever reducer', 5),
('Vitamin D3', 'XYZ Pharma', 'Vitamin D supplement', 8),
('Amoxicillin', 'HealthCorp', 'Antibiotic for infections', 10),
('Cough Syrup', 'Wellness Inc.', 'Cough suppressant', 7),
('Aspirin', 'PharmaCare', 'Anti-inflammatory', 6),
('Ibuprofen', 'MedPro', 'Pain and fever reducer', 4),
('Lisinopril', 'CardioHealth', 'Blood pressure medication', 12),
('Metformin', 'LifeScience', 'Diabetes medication', 9),
('Omeprazole', 'GastroCare', 'Acid reflux medication', 11),
('Simvastatin', 'HeartGuard', 'Cholesterol reducer', 14);

INSERT INTO users (user_type, user_name, user_email, user_password, user_level_id) 
VALUES ('Admin', 'admin1', 'admin@caretech.com', 'admin123', 1),
('BranchAdmin', 'branchManager', 'manager@caretech.com', 'manager123', 2),
('company', 'GP', 'gp@caretech.com', 'gp123', 3);

INSERT INTO user_level (user_type, description)
VALUES 
('Admin', 'System administrator with full access'),
('branchAdmin', 'Head of Department of Hospital'),
('company','These are the medical branches of the hosptials such as GP, Clinics etc.')


