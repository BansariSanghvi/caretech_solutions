/* SECTION 1 - TABLE CREATION */

/* Table for hospital information */
CREATE TABLE hospital_info (
    hospital_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    hname VARCHAR(255),
    hospital_address VARCHAR(255),
    hospital_phone CHAR(11),
    hospital_email VARCHAR(255)
);

/* Table for staff records within the hospital */
CREATE TABLE staff_records (
    staff_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    fname VARCHAR(20),
    lname VARCHAR(20),
    address VARCHAR(255),
    staff_phone_no CHAR(10),
    email VARCHAR(255),
    role VARCHAR(255),
    hospital_department_id INT(10),
    hospital_id INT(10),
    isActive BOOLEAN,  
    reasonToLeave VARCHAR(255) NULL,


    FOREIGN KEY (hospital_department_id) REFERENCES hospital_branches(hospital_department_id),
    FOREIGN KEY (hospital_id) REFERENCES hospital_info(hospital_id)
);

/* Table for patient records */
CREATE TABLE patient_records (
    patient_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(20),
    last_name VARCHAR(20),
    email VARCHAR(50),
    phone_no CHAR(11),
    date_of_birth INT(8),
    emergency_contact CHAR(10),
    emergency_contact_name VARCHAR(255),
    patient_history VARCHAR(255),
    isRegistered_NHS BOOLEAN,
    staff_id INT(10),
    hospital_id INT(10),
    medical_association_id INT(10),
    last_seen_date INT(8),  

    FOREIGN KEY (staff_id) REFERENCES staff_records(staff_id),
    FOREIGN KEY (hospital_id) REFERENCES hospital_info(hospital_id),
    FOREIGN KEY (medical_association_id) REFERENCES external_associations(medical_association_id)
);

/* Table for hospital departments (branches) */
CREATE TABLE hospital_branches (
    hospital_department_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    department_name VARCHAR(255),
    department_email VARCHAR(255),
    department_type VARCHAR(255), -- Department Type
    department_phone CHAR(11),
    hospital_id INT(10),

    FOREIGN KEY (hospital_id) REFERENCES hospital_info(hospital_id)
);

/* Table for external medical associations such as GP Surgery */
-- Maybe I need Catagory onto this? Primary Care 
CREATE TABLE external_associations (
    medical_association_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    medical_association_name VARCHAR(25),
    associations_location VARCHAR(255),
    associations_phone CHAR(11),
    associations_email VARCHAR(255),
    hospital_id INT(10), -- main hosptial branch

    FOREIGN KEY (hospital_id) REFERENCES hospital_info(hospital_id)
);

/* Table for referral forms */
CREATE TABLE referral_form (
    request_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    request_type VARCHAR(255),
    summary_notes VARCHAR(255),
    priority_catagory VARCHAR(255),
    hospital_department_id INT(10),
    staff_id INT(10),
    hospital_id INT(10),
    medical_association_id INT(10),
    patient_id INT(10),
    isViewed VARCHAR(20) DEFAULT 'Pending',
    FOREIGN KEY (patient_id) REFERENCES patient_records(patient_id),
    FOREIGN KEY (hospital_department_id) REFERENCES hospital_branches(hospital_department_id),
    FOREIGN KEY (staff_id) REFERENCES staff_records(staff_id),
    FOREIGN KEY (hospital_id) REFERENCES hospital_info(hospital_id),
    FOREIGN KEY (medical_association_id) REFERENCES external_associations(medical_association_id)
);




/* Table for prescription orders */
CREATE TABLE prescription_order (
    prescription_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    patient_id INT(10),
    hospital_id INT(10),
    to_address VARCHAR(255),
    from_address VARCHAR(255),
    date_issued INT(8), 
    is_repeat BOOLEAN,
    is_NHS_covered BOOLEAN,
    order_status VARCHAR(20) DEFAULT 'Pending',

    FOREIGN KEY (hospital_id) REFERENCES hospital_info(hospital_id),
    FOREIGN KEY (patient_id) REFERENCES patient_records(patient_id)
);

/* Table for prescription items */
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

/* Table for drugs list */
CREATE TABLE drugs_list (
    drugID INT PRIMARY KEY AUTO_INCREMENT,
    drugName VARCHAR(100) NOT NULL,
    supplier_id INT(10),
    description VARCHAR(255),
    qty INT(10),
    price INT(10),

    FOREIGN KEY (supplier_id) REFERENCES manufacturers(supplier_id)
);

/* Table for medical equipment list */
CREATE TABLE medicalEquipment_list (
    equipment_ID INT PRIMARY KEY AUTO_INCREMENT,
    equipment_Name VARCHAR(100) NOT NULL,
    equipment_description VARCHAR(255),
    qty INT(10),
    price INT(10),
    isUrgent BOOLEAN,
    hospital_department_id INT(10),

    FOREIGN KEY (hospital_department_id) REFERENCES hospital_branches(hospital_department_id)
);

/* Table for medical equipment orders */
CREATE TABLE equipment_orders (
    order_number INT PRIMARY KEY AUTO_INCREMENT, 
    equipment_ID INT(10),
    order_qty INT(10),
    order_date INT(8),  
    hospital_department_id INT(10),
    delivery_status VARCHAR(20) DEFAULT 'Pending',
    supplier_id INT(10),

    FOREIGN KEY (equipment_ID) REFERENCES medicalEquipment_list(equipment_ID),
    FOREIGN KEY (hospital_department_id) REFERENCES hospital_branches(hospital_department_id),
    FOREIGN KEY (supplier_id) REFERENCES manufacturers(supplier_id)
);

/* Table for generating referral letters */
CREATE TABLE referal_letters (
    letter_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    date_generated INT(8),  
    hospital_department_id INT(10),
    staff_id INT(10),
    patient_id INT(10),

    FOREIGN KEY (hospital_department_id) REFERENCES hospital_branches(hospital_department_id),
    FOREIGN KEY (staff_id) REFERENCES staff_records(staff_id),
    FOREIGN KEY (patient_id) REFERENCES patient_records(patient_id)
);

/* Table for appointments */
CREATE TABLE appointments (
    appointment_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    patient_id INT(10),
    hospital_department_id INT(10),
    staff_id INT(10),
    appointment_date DATE, 
    appointment_time TIME,  

    FOREIGN KEY (patient_id) REFERENCES patient_records(patient_id),
    FOREIGN KEY (hospital_department_id) REFERENCES hospital_branches(hospital_department_id),
    FOREIGN KEY (staff_id) REFERENCES staff_records(staff_id)
);

/* Manufacturer Table - only for medical equipment  */
CREATE TABLE manufacturers (
    supplier_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    supplier_name VARCHAR(255),
    supplier_email VARCHAR(255),
    supplier_location VARCHAR(255),
    supplier_phone CHAR(11),
    supplier_status VARCHAR(255)
);

/* Announcements Table */
CREATE TABLE announcements (
    announcement_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    announcement_duration INT(100),
    announcement_description VARCHAR(255)
);

/* Table for users (e.g., for login and permissions) */
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    user_type VARCHAR(255),
    user_name VARCHAR(255),
    user_email VARCHAR(255),
    user_password VARCHAR(255),
    user_level_id INT(3),
    hospital_department_id INT(10) NULL,
    external_associations_id INT(10) NULL,


    FOREIGN KEY (user_level_id) REFERENCES user_level(user_level_id)
);

/* Table for user levels (roles, access levels) */
CREATE TABLE user_level (
    user_level_id INT PRIMARY KEY AUTO_INCREMENT,
    user_type VARCHAR(255),
    description VARCHAR(255)
);

/* Approvals Table */
CREATE TABLE approvals (
    approval_id INT PRIMARY KEY AUTO_INCREMENT, 
    user_id INT(10),
    hospital_department_id INT(10), 
    equipment_ID INT(10),
    approval_qty INT(10),
    approval_description VARCHAR(255),
    approval_sent_date DATE DEFAULT CURRENT_DATE,
    approval_date INT(8) NULL, 
    approval_status VARCHAR(255) DEFAULT 'Waiting Approval',
     

    FOREIGN KEY (equipment_ID) REFERENCES medicalEquipment_list(equipment_ID),
    FOREIGN KEY (hospital_department_id) REFERENCES hospital_branches(hospital_department_id),
    FOREIGN KEY(user_id) REFERENCES users(user_id)
    
);

/* SECTION 2 - INSERTION */ 

INSERT INTO hospital_info (hname, hospital_address, hospital_phone, hospital_email) VALUES
('City Hospital', '123 Main St, Sheffield, UK', '01142345678', 'contact@cityhospital.com');


INSERT INTO staff_records (fname, lname, address, staff_phone_no, email, role, hospital_department_id, hospital_id, isActive, reasonToLeave) 
VALUES 
('John', 'Doe', '123 Main St', '1234567890', 'john.doe@cityhospital.com', 'Doctor', 1, 1, TRUE, NULL),
('Jane', 'Smith', '456 Elm St', '2345678901', 'jane.smith@cityhospital.com', 'Nurse', 2, 1, TRUE, NULL),
('Michael', 'Johnson', '789 Oak St', '3456789012', 'michael.johnson@cityhospital.com', 'Assistant', 3, 1, TRUE, NULL),
('Emily', 'Davis', '101 Pine St', '4567890123', 'emily.davis@cityhospital.com', 'Manager', 4, 1, TRUE, NULL),
('David', 'Brown', '202 Cedar St', '5678901234', 'david.brown@cityhospital.com', 'Doctor', 1, 1, TRUE, NULL);


INSERT INTO patient_records (first_name, last_name, email, phone_no, date_of_birth, emergency_contact, emergency_contact_name, patient_history, isRegistered_NHS, staff_id, hospital_id, medical_association_id, last_seen_date) VALUES
('Alice', 'Williams', 'alice.williams@email.com', '07123456789', '1985-06-15', '07812345678', 'John Williams', 'No history of major illnesses', TRUE, 1, 1, 1, '2024-11-15'),
('Bob', 'Brown', 'bob.brown@email.com', '07987654321', '1990-12-25', '07898765432', 'Emily Brown', 'Asthma', TRUE, 2, 2, 2, '2024-11-10'),
('Charlie', 'Davis', 'charlie.davis@email.com', '07865432123', '1982-09-12', '07765432123', 'Sarah Davis', 'Diabetes', TRUE, 3, 3, 3, '2024-11-18'),
('Deborah', 'Miller', 'deborah.miller@email.com', '07712341234', '1975-03-09', '07987654321', 'Michael Miller', 'High blood pressure', TRUE, 4, 4, 4, '2024-11-20'),
('Eve', 'Wilson', 'eve.wilson@email.com', '07698765432', '1995-08-30', '07654321876', 'David Wilson', 'No history', TRUE, 5, 5, 5, '2024-11-12');

INSERT INTO hospital_branches (department_name, department_email, department_type, department_phone, hospital_id) VALUES
('Cardiology', 'cardiology@cityhospital.com', 'Medical', '01142345679', 1),
('Emergency', 'emergency@cityhospital.com', 'Medical', '01618234568', 2),
('Orthopedics', 'orthopedics@cityhospital.com', 'Surgical', '01512345679', 1),
('Rehabilitation', 'rehabilitation@cityhospital.com', 'Rehabilitation', '01173216548', 1),
('General Medicine', 'general.medicine@cityhospital.com', 'Medical', '01865782347', 1),
('Adminstration','admin@caretech.com','Admin','1234689300','1');


INSERT INTO external_associations (medical_association_name, associations_location, associations_phone, associations_email, hospital_id) VALUES
('Greenwood GP Surgery', '12 Green St, Sheffield, UK', '01142345555', 'contact@greenwoodgp.com', 1),
('Mancity Medical Centre', '56 Central Rd, Manchester, UK', '01618230000', 'info@mancitymedical.com', 2),
('Liverpool Family Practice', '23 Riverside Dr, Liverpool, UK', '01512340000', 'support@liverpoolfamily.co.uk', 3),
('Bristol Care Clinic', '32 West End Rd, Bristol, UK', '01173216500', 'help@bristolcare.com', 4),
('Oxford Health Center', '10 Oxford High St, Oxford, UK', '01865782222', 'contact@oxfordhealthcenter.com', 5);

INSERT INTO users (user_type, user_name, user_email, user_password, user_level_id, hospital_department_id, external_associations_id) VALUES
('Admin', 'admin_user', 'admin@caretech.com', 'admin123', 1, NULL ,NULL),
('Manager', 'manager', 'manager@caretech.com', 'manager123', 2,2,NULL),
('GP', 'gp_staff', 'gp@caretech.com', 'gp123', 3,NULL, 1),
('HStaff', 'staff', 'staff@caretech.com', 'staff123', 3,NULL, 1);


INSERT INTO user_level (user_type, description) VALUES
('Admin', 'Administrator with full access'),
('Manager', 'Hospital manager with access to hospital data and settings'),
('GP',' External General Practitioner'),
('Staff', "Member of Staff of Specific Department" );

INSERT INTO manufacturers (supplier_name,supplier_email, supplier_location, supplier_phone, supplier_status) VALUES
('MedSupplies Ltd', 'info@medsupplies.com', 'London, UK', '02079460001', 'Active'),
("HealthCare Ltd",'contact@healthcaretech.com', 'Birmingham, UK', '01214560023', 'Active'),
("BioTech Solutions",'sales@biohealthsolutions.com', 'Manchester, UK', '01612345001', 'Active'),
("MedicalTech World",'support@medicaltechworld.com', 'Edinburgh, Scotland', '01314450099', 'Inactive'),
("AdvancedMedSupply",'service@advancedmedsupply.com', 'Cardiff, Wales', '02920010034', 'Active');

INSERT INTO drugs_list (drugName, supplier_id, description, qty, price) VALUES
('Aspirin', 1, 'Pain reliever, anti-inflammatory', 100, 10),
('Ibuprofen', 2, 'Anti-inflammatory drug used for fever and pain', 200, 15),
('Amoxicillin', 3, 'Antibiotic used to treat bacterial infections', 150, 25),
('Paracetamol', 4, 'Painkiller used for mild to moderate pain relief', 250, 5),
('Lisinopril', 5, 'ACE inhibitor used for high blood pressure treatment', 120, 30);

INSERT INTO `medicalequipment_list` (`equipment_ID`, `equipment_Name`, `equipment_description`, `qty`, `price`, `isUrgent`, `hospital_department_id`) VALUES
(1, 'ECG Machine', 'Used for measuring the electrical activity of the heart.', 5, 12000, 1, 1),
(2, 'Defibrillator', 'Essential for emergency cardiac situations.', 25, 15000, 1, 2),
(3, 'Orthopedic Drill', 'Used in surgical orthopedic procedures.', 2, 8000, 0, 3),
(4, 'Rehabilitation Chair', 'Adjustable chair for patient rehabilitation exercises.', 10, 3000, 0, 4),
(5, 'Stethoscope', 'Basic diagnostic equipment for medical practitioners.', 50, 200, 0, 5),
(6, 'Heart Monitor', 'Device for continuous monitoring of heart activity.', 4, 25000, 1, 1),
(7, 'Ventilator', 'Critical equipment for patients with breathing difficulties.', 6, 45000, 1, 2),
(8, 'Medical Gloves', 'Required for various tasks .', 500, 2000, 0, 3),
(9, 'Walking Frame', 'Support equipment for patients learning to walk again.', 12, 1500, 0, 4),
(10, 'Thermometer', 'Used to measure patient body temperature.', 100, 50, 0, 5);

INSERT INTO referral_form (request_type, summary_notes, hospital_department_id, staff_id, hospital_id, medical_association_id, patient_id) VALUES
('Cardiology Consultation', 'Patient experiencing chest pain, requires specialist opinion.', 1, 1, 1, 1, 1),
('Emergency Trauma', 'Patient with multiple fractures from an accident.', 2, 2, 2, 1, 2),
('Rehabilitation Assessment', 'Patient recovering from knee surgery.', 4, 3, 1, 1, 3),
('General Checkup', 'Routine physical examination for the patient.', 5, 4, 1, 1, 4),
('Orthopedic Surgery', 'Patient requires surgical intervention for a broken arm.', 3, 5, 1, 1, 5);