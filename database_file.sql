/* SECTION 1 - TABLE CREATION */

/* Table for hospital information */
CREATE TABLE hospital_info (
    hospital_id INT PRIMARY KEY AUTO_INCREMENT,
    hname VARCHAR(255) NOT NULL,
    hospital_address VARCHAR(255) NOT NULL,
    hospital_phone CHAR(11) NOT NULL,
    hospital_email VARCHAR(255) NOT NULL
);

/* Table for staff records within the hospital */
CREATE TABLE staff_records (
    staff_id INT PRIMARY KEY AUTO_INCREMENT,
    fname VARCHAR(20) NOT NULL,
    lname VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL,
    staff_phone_no CHAR(10) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    role VARCHAR(255) NOT NULL,
    hospital_department_id INT NOT NULL,
    hospital_id INT NOT NULL,
    isActive BOOLEAN DEFAULT TRUE,
    reasonToLeave VARCHAR(255) NULL,
    FOREIGN KEY (hospital_department_id) REFERENCES hospital_branches(hospital_department_id),
    FOREIGN KEY (hospital_id) REFERENCES hospital_info(hospital_id)
);

/* Table for patient records */
CREATE TABLE patient_records (
    patient_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(20) NOT NULL,
    last_name VARCHAR(20) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    phone_no CHAR(11) NOT NULL,
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
    hospital_department_id INT PRIMARY KEY AUTO_INCREMENT,
    department_name VARCHAR(255),
    department_email VARCHAR(255),
    department_type VARCHAR(255), -- Department Type
    department_phone CHAR(11),
    hospital_id INT(10),
    FOREIGN KEY (hospital_id) REFERENCES hospital_info(hospital_id)
);

/* Table for external medical associations such as GP Surgery */
CREATE TABLE external_associations (
    medical_association_id INT PRIMARY KEY AUTO_INCREMENT,
    medical_association_name VARCHAR(25),
    associations_location VARCHAR(255),
    associations_phone CHAR(11),
    associations_email VARCHAR(255),
    hospital_id INT(10),
    FOREIGN KEY (hospital_id) REFERENCES hospital_info(hospital_id)
);

/* Table for referral forms */
CREATE TABLE referal_form (
    request_id INT PRIMARY KEY AUTO_INCREMENT,
    request_type VARCHAR(255),
    summary_notes VARCHAR(255),
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
    prescription_id INT PRIMARY KEY AUTO_INCREMENT,
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

/* Manufacturer Table - only for medical equipment */
CREATE TABLE manufacturers (
    supplier_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    supplier_name VARCHAR(255),
    supplier_email VARCHAR(255),
    supplier_location VARCHAR(255),
    supplier_phone CHAR(11),
    supplier_status VARCHAR(255)
);

/* Announcements Table */
CREATE TABLE annoucments (
    annoucment_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
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

/* Approvals Table */
CREATE TABLE approvals (
    approval_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT(10),
    hospital_department_id INT(10),
    equipment_ID INT(10),
    approval_qty INT(10),
    approval_description VARCHAR(255),
    approval_sent_date DATE DEFAULT CURRENT_TIMESTAMP,
    approval_date INT(8) NULL,
    approval_status VARCHAR(255) DEFAULT 'Waiting Approval',
    FOREIGN KEY (equipment_ID) REFERENCES medicalEquipment_list(equipment_ID),
    FOREIGN KEY (hospital_department_id) REFERENCES hospital_branches(hospital_department_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
