CREATE TABLE IF NOT EXISTS preventive_maintenance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    device_name VARCHAR(100) NOT NULL,
    device_category VARCHAR(50) NOT NULL,
    maintenance_type VARCHAR(100) NOT NULL,
    schedule_date DATE NOT NULL,
    technician VARCHAR(100) NOT NULL,
    description TEXT,
    status ENUM('Selesai','Menunggu','Dibatalkan') DEFAULT 'Menunggu',
    result TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS corrective_maintenance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    device_name VARCHAR(100) NOT NULL,
    device_category VARCHAR(50) NOT NULL,
    problem TEXT NOT NULL,
    report_date DATE NOT NULL,
    priority ENUM('Tinggi','Sedang','Rendah') DEFAULT 'Sedang',
    technician VARCHAR(100),
    status ENUM('Proses','Selesai','Menunggu Sparepart','Dibatalkan') DEFAULT 'Proses',
    solution TEXT,
    sparepart_needed VARCHAR(200),
    completion_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS predictive_maintenance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    device_name VARCHAR(100) NOT NULL,
    device_category VARCHAR(50) NOT NULL,
    prediction TEXT NOT NULL,
    accuracy DECIMAL(5,2) DEFAULT 0,
    recommendation TEXT,
    predicted_date DATE NOT NULL,
    status ENUM('Terbukti','Tidak Terbukti','Menunggu') DEFAULT 'Menunggu',
    actual_condition VARCHAR(200),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
