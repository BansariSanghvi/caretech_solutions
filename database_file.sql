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
    department VARCHAR(200),
    hospital_id INT(10),
    isActive BOOLEAN,  
    reasonToLeave VARCHAR(255) NULL,

    FOREIGN KEY (hospital_id) REFERENCES hospital_info(hospital_id)
);

/* Table for patient records */
CREATE TABLE patient_records (
    patient_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(20),
    last_name VARCHAR(20),
    email VARCHAR(50),
    phone_no CHAR(11),
    date_of_birth INT(8)
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
CREATE TABLE external_associations (
    medical_association_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    medical_association_name VARCHAR(25),
    associations_location VARCHAR(255),
    associations_phone CHAR(11),
    associations_email VARCHAR(255),
    hospital_id INT(10),

    FOREIGN KEY (hospital_id) REFERENCES hospital_info(hospital_id)
);

/* Table for referral forms */
CREATE TABLE referal_form (
    request_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    request_type VARCHAR(255),
    summary_notes VARCHAR(255),
    hospital_department_id INT(10),
    staff_id INT(10),
    hospital_id INT(10),
    medical_association_id INT(10),
    patient_id INT(10),

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
    isUrgent BOOLEAN 
);

/* Table for medical equipment orders */
CREATE TABLE equipment_orders (
    order_number INT PRIMARY KEY AUTO_INCREMENT, 
    equipment_ID INT(10),
    order_qty INT(10),
    order_date INT(8),  
    hospital_department_id INT(10),
    delivery_status VARCHAR(20) DEFAULT 'Pending',
    user_id INT(10),

    FOREIGN KEY (equipment_ID) REFERENCES medicalEquipment_list(equipment_ID),
    FOREIGN KEY (hospital_department_id) REFERENCES hospital_branches(hospital_department_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
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

/* Manufacturer Table */
CREATE TABLE manufacturers (
    supplier_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    supplier_email VARCHAR(255),
    supplier_location VARCHAR(255),
    supplier_phone CHAR(11),
    supplier_status VARCHAR(255)
);

/* Announcements Table */
CREATE TABLE annoucments (
    annoucment_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    annoucment_duration INT(100),
    annoucment_description VARCHAR(255)
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

/* SECTION 2 - INSERTION */ 

INSERT INTO hospital_info (hname, hospital_address, hospital_phone, hospital_email) VALUES
('City Hospital', '123 Main St, Sheffield, UK', '01142345678', 'contact@cityhospital.com');


INSERT INTO staff_records (fname, lname, address, staff_phone_no, email, role, department, hospital_id, isActive, reasonToLeave) VALUES
('John', 'Smith', '12 Elm St, Sheffield', '07123456789', 'john.smith@cityhospital.com', 'Doctor', 'Cardiology', 1, TRUE, NULL),
('Emily', 'Johnson', '34 Oak Rd, Sheffield', '07987654321', 'emily.johnson@cityhospital.com', 'Nurse', 'Emergency', 1, TRUE, NULL),
('Michael', 'Davis', '56 Maple St, Liverpool', '07865432123', 'michael.davis@cityhospital.com', 'Surgeon', 'Orthopedics', 1, TRUE, NULL),
('Sarah', 'Taylor', '78 Pine Ave, Sheffield', '07712341234', 'sarah.taylor@cityhospital.com', 'Physiotherapist', 'Rehabilitation', 1, TRUE, NULL),
('David', 'Wilson', '90 Cedar St, Sheffield', '07698765432', 'david.wilson@cityhospital.com', 'Consultant', 'General Medicine', 1, TRUE, NULL);

INSERT INTO patient_records (first_name, last_name, email, phone_no, date_of_birth, emergency_contact, emergency_contact_name, patient_history, isRegistered_NHS, staff_id, hospital_id, medical_association_id, last_seen_date) VALUES
('Alice', 'Williams', 'alice.williams@email.com', '07123456789', '1985-06-15', '07812345678', 'John Williams', 'No history of major illnesses', TRUE, 1, 1, 1, '2024-11-15'),
('Bob', 'Brown', 'bob.brown@email.com', '07987654321', '1990-12-25', '07898765432', 'Emily Brown', 'Asthma', TRUE, 2, 2, 2, '2024-11-10'),
('Charlie', 'Davis', 'charlie.davis@email.com', '07865432123', '1982-09-12', '07765432123', 'Sarah Davis', 'Diabetes', TRUE, 3, 3, 3, '2024-11-18'),
('Deborah', 'Miller', 'deborah.miller@email.com', '07712341234', '1975-03-09', '07987654321', 'Michael Miller', 'High blood pressure', TRUE, 4, 4, 4, '2024-11-20'),
('Eve', 'Wilson', 'eve.wilson@email.com', '07698765432', '1995-08-30', '07654321876', 'David Wilson', 'No history', TRUE, 5, 5, 5, '2024-11-12');

INSERT INTO hospital_branches (department_name, department_email, department_type, department_phone, hospital_id) VALUES
('Cardiology', 'cardiology@cityhospital.com', 'Medical', '01142345679', 1),
('Emergency', 'emergency@cityhospital.com', 'Medical', '01618234568', 2),
('Orthopedics', 'orthopedics@cityhospital.com', 'Surgical', '01512345679', 3),
('Rehabilitation', 'rehabilitation@cityhospital.com', 'Rehabilitation', '01173216548', 4),
('General Medicine', 'general.medicine@cityhospital.com', 'Medical', '01865782347', 5);

INSERT INTO external_associations (medical_association_name, associations_location, associations_phone, associations_email, hospital_id) VALUES
('Greenwood GP Surgery', '12 Green St, Sheffield, UK', '01142345555', 'contact@greenwoodgp.com', 1),
('Mancity Medical Centre', '56 Central Rd, Manchester, UK', '01618230000', 'info@mancitymedical.com', 2),
('Liverpool Family Practice', '23 Riverside Dr, Liverpool, UK', '01512340000', 'support@liverpoolfamily.co.uk', 3),
('Bristol Care Clinic', '32 West End Rd, Bristol, UK', '01173216500', 'help@bristolcare.com', 4),
('Oxford Health Center', '10 Oxford High St, Oxford, UK', '01865782222', 'contact@oxfordhealthcenter.com', 5);

INSERT INTO users (user_type, user_name, user_email, user_password, user_level_id, hospital_department_id, external_associations_id) VALUES
('Admin', 'admin_user', 'admin@caretech.com', 'admin123', 1),
('Manager', 'manager', 'manager@caretech.com', 'manager123', 2),
('GP', 'gp_staff', 'gp@caretech.com', 'gp123', 3);


INSERT INTO user_level (user_type, description) VALUES
('Admin', 'Administrator with full access'),
('Manager', 'Hospital manager with access to hospital data and settings'),
('GP',' External General Practitioner');

