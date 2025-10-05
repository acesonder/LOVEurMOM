-- LOVEurMOM Database Schema
-- Cancer Treatment Tracking System

-- Create database
CREATE DATABASE IF NOT EXISTS loveurmom_db;
USE loveurmom_db;

-- Diagnoses table
CREATE TABLE IF NOT EXISTS diagnoses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    diagnosis_date DATE NOT NULL,
    diagnosis_type VARCHAR(255) NOT NULL,
    stage VARCHAR(50),
    location VARCHAR(255),
    doctor_name VARCHAR(255),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Scans table
CREATE TABLE IF NOT EXISTS scans (
    id INT PRIMARY KEY AUTO_INCREMENT,
    scan_date DATE NOT NULL,
    scan_type VARCHAR(100) NOT NULL,
    scan_location VARCHAR(255),
    findings TEXT,
    tumor_size VARCHAR(100),
    tumor_markers VARCHAR(255),
    doctor_name VARCHAR(255),
    file_path VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Treatments table
CREATE TABLE IF NOT EXISTS treatments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    treatment_date DATE NOT NULL,
    treatment_type ENUM('surgery', 'chemotherapy', 'immunotherapy', 'radiation', 'clinical_trial', 'other') NOT NULL,
    treatment_name VARCHAR(255) NOT NULL,
    doctor_name VARCHAR(255),
    location VARCHAR(255),
    dosage VARCHAR(100),
    duration VARCHAR(100),
    side_effects TEXT,
    notes TEXT,
    status ENUM('scheduled', 'completed', 'cancelled', 'ongoing') DEFAULT 'scheduled',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tumor progression tracking
CREATE TABLE IF NOT EXISTS tumor_progression (
    id INT PRIMARY KEY AUTO_INCREMENT,
    measurement_date DATE NOT NULL,
    tumor_location VARCHAR(255) NOT NULL,
    size_mm DECIMAL(10,2),
    size_cm DECIMAL(10,2),
    volume_cc DECIMAL(10,2),
    tumor_marker_value DECIMAL(10,2),
    marker_type VARCHAR(100),
    progression_status ENUM('stable', 'growing', 'shrinking', 'new', 'resolved') DEFAULT 'stable',
    notes TEXT,
    scan_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (scan_id) REFERENCES scans(id) ON DELETE SET NULL
);

-- Pain and symptom tracking
CREATE TABLE IF NOT EXISTS symptoms (
    id INT PRIMARY KEY AUTO_INCREMENT,
    symptom_date DATE NOT NULL,
    symptom_time TIME,
    symptom_type VARCHAR(255) NOT NULL,
    severity INT NOT NULL CHECK (severity BETWEEN 1 AND 10),
    location VARCHAR(255),
    description TEXT,
    triggers TEXT,
    relief_methods TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Medications table
CREATE TABLE IF NOT EXISTS medications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    medication_name VARCHAR(255) NOT NULL,
    dosage VARCHAR(100) NOT NULL,
    frequency VARCHAR(100) NOT NULL,
    purpose VARCHAR(255),
    start_date DATE NOT NULL,
    end_date DATE,
    prescribing_doctor VARCHAR(255),
    side_effects TEXT,
    notes TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- AI suggestions/recommendations
CREATE TABLE IF NOT EXISTS ai_suggestions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    suggestion_date DATE NOT NULL,
    symptom_id INT,
    suggestion_type VARCHAR(100),
    suggestion_text TEXT NOT NULL,
    is_helpful BOOLEAN,
    user_feedback TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (symptom_id) REFERENCES symptoms(id) ON DELETE SET NULL
);

-- Appointments table
CREATE TABLE IF NOT EXISTS appointments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    doctor_name VARCHAR(255) NOT NULL,
    appointment_type VARCHAR(255),
    location VARCHAR(255),
    notes TEXT,
    reminder_sent BOOLEAN DEFAULT FALSE,
    status ENUM('scheduled', 'completed', 'cancelled', 'rescheduled') DEFAULT 'scheduled',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert some sample data for demonstration
INSERT INTO diagnoses (diagnosis_date, diagnosis_type, stage, location, doctor_name, notes) VALUES
('2024-01-15', 'Adenocarcinoma', 'Stage IV', 'Lung', 'Dr. Sarah Johnson', 'Initial diagnosis after CT scan revealed mass in right lung');

INSERT INTO treatments (treatment_date, treatment_type, treatment_name, doctor_name, status, notes) VALUES
('2024-02-01', 'chemotherapy', 'Carboplatin + Pemetrexed', 'Dr. Sarah Johnson', 'completed', 'Cycle 1 - tolerated well'),
('2024-02-22', 'chemotherapy', 'Carboplatin + Pemetrexed', 'Dr. Sarah Johnson', 'completed', 'Cycle 2 - mild nausea'),
('2024-03-15', 'immunotherapy', 'Pembrolizumab', 'Dr. Sarah Johnson', 'ongoing', 'Started immunotherapy treatment');

INSERT INTO scans (scan_date, scan_type, findings, tumor_size, doctor_name) VALUES
('2024-01-10', 'CT Scan', 'Mass detected in right upper lobe', '3.2 cm', 'Dr. Michael Chen'),
('2024-03-10', 'CT Scan', 'Slight reduction in tumor size', '2.8 cm', 'Dr. Michael Chen');
