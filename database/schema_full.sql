-- =============================================================
-- IT MAINTENANCE - COMPLETE DATABASE SCHEMA
-- PK columns updated: code for org tables, email for email, username for ad, barcode for am
-- =============================================================

-- 1. LEVEL
CREATE TABLE IF NOT EXISTS `level` (
  code VARCHAR(10) PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  note VARCHAR(100) DEFAULT '',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. DIRECTORATE
CREATE TABLE IF NOT EXISTS `directorate` (
  code VARCHAR(10) PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  note VARCHAR(100) DEFAULT '',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. DIVISION
CREATE TABLE IF NOT EXISTS `division` (
  code VARCHAR(10) PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  note VARCHAR(100) DEFAULT '',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 4. DEPARTMENT
CREATE TABLE IF NOT EXISTS `department` (
  code VARCHAR(10) PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  note VARCHAR(100) DEFAULT '',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 5. SUB_DEPARTMENT
CREATE TABLE IF NOT EXISTS `sub_department` (
  code VARCHAR(10) PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  department_id VARCHAR(10),
  division_id VARCHAR(10),
  directorate_id VARCHAR(10),
  note TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (department_id) REFERENCES department(code) ON DELETE SET NULL,
  FOREIGN KEY (division_id) REFERENCES division(code) ON DELETE SET NULL,
  FOREIGN KEY (directorate_id) REFERENCES directorate(code) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 6. BUSINESS_UNIT
CREATE TABLE IF NOT EXISTS `business_unit` (
  code VARCHAR(10) PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  note VARCHAR(100) DEFAULT '',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 7. CORP
CREATE TABLE IF NOT EXISTS `corp` (
  code VARCHAR(10) PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  note VARCHAR(100) DEFAULT '',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 8. ITEM (Category Assets)
CREATE TABLE IF NOT EXISTS `item` (
  code_item VARCHAR(10) PRIMARY KEY,
  type VARCHAR(50) DEFAULT '',
  category VARCHAR(50) DEFAULT '',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 9. SITE
CREATE TABLE IF NOT EXISTS `site` (
  id_site VARCHAR(5) PRIMARY KEY,
  site VARCHAR(100) NOT NULL,
  business_unit VARCHAR(50) DEFAULT '',
  company VARCHAR(50) DEFAULT '',
  country VARCHAR(50) DEFAULT 'Indonesia',
  provincy VARCHAR(50) DEFAULT '',
  city VARCHAR(50) DEFAULT '',
  address TEXT,
  url_maps TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (business_unit) REFERENCES business_unit(code) ON DELETE SET NULL,
  FOREIGN KEY (company) REFERENCES corp(code) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 10. EMPLOYEE
CREATE TABLE IF NOT EXISTS `employee` (
  nip VARCHAR(10) PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  id_level VARCHAR(10) DEFAULT '',
  salary DECIMAL(15,2) DEFAULT 0,
  id_directorate VARCHAR(10) DEFAULT '',
  id_division VARCHAR(10) DEFAULT '',
  id_department VARCHAR(10) DEFAULT '',
  id_sub_department VARCHAR(10) DEFAULT '',
  business_unit VARCHAR(50) DEFAULT '',
  site_unit VARCHAR(10) DEFAULT '',
  corporate_name VARCHAR(50) DEFAULT '',
  date_hiring DATE DEFAULT NULL,
  date_resign DATE DEFAULT NULL,
  status VARCHAR(20) DEFAULT 'ACTIVE',
  no_tlp VARCHAR(20) DEFAULT '',
  email VARCHAR(100) DEFAULT '',
  ad VARCHAR(50) DEFAULT '',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_level) REFERENCES level(code) ON DELETE SET NULL,
  FOREIGN KEY (id_directorate) REFERENCES directorate(code) ON DELETE SET NULL,
  FOREIGN KEY (id_division) REFERENCES division(code) ON DELETE SET NULL,
  FOREIGN KEY (id_department) REFERENCES department(code) ON DELETE SET NULL,
  FOREIGN KEY (id_sub_department) REFERENCES sub_department(code) ON DELETE SET NULL,
  FOREIGN KEY (business_unit) REFERENCES business_unit(code) ON DELETE SET NULL,
  FOREIGN KEY (site_unit) REFERENCES site(id_site) ON DELETE SET NULL,
  FOREIGN KEY (corporate_name) REFERENCES corp(code) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 11. EMAIL
CREATE TABLE IF NOT EXISTS `email` (
  email VARCHAR(100) PRIMARY KEY,
  nip VARCHAR(10) DEFAULT '',
  domain VARCHAR(50) DEFAULT '',
  type VARCHAR(20) DEFAULT 'USER',
  apps VARCHAR(50) DEFAULT 'Microsoft Office 365',
  layer VARCHAR(20) DEFAULT 'STANDARD',
  status VARCHAR(20) DEFAULT 'ACTIVED',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (nip) REFERENCES employee(nip) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 12. AD (Active Directory)
CREATE TABLE IF NOT EXISTS `ad` (
  username VARCHAR(100) PRIMARY KEY,
  pswd VARCHAR(50) DEFAULT '',
  password VARCHAR(255) DEFAULT '',
  pic_nip VARCHAR(10) DEFAULT '',
  wst_access VARCHAR(5) DEFAULT 'NO',
  net_access VARCHAR(5) DEFAULT 'YES',
  svr_access VARCHAR(20) DEFAULT 'USER',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (pic_nip) REFERENCES employee(nip) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 13. WORKSTATION (Data Asset)
CREATE TABLE IF NOT EXISTS `workstation` (
  id_asset VARCHAR(15) PRIMARY KEY,
  hostname VARCHAR(20) NOT NULL,
  sn VARCHAR(20) DEFAULT '',
  barcode VARCHAR(20) DEFAULT '',
  category VARCHAR(20) DEFAULT '',
  brand VARCHAR(50) DEFAULT '',
  type VARCHAR(50) DEFAULT '',
  processors VARCHAR(20) DEFAULT '',
  gen INT DEFAULT 0,
  ram_cap INT DEFAULT 0,
  ram_slot VARCHAR(10) DEFAULT '',
  ram_type VARCHAR(50) DEFAULT '',
  disk1_cap INT DEFAULT 0,
  disk1_type VARCHAR(50) DEFAULT '',
  disk2_cap INT DEFAULT 0,
  disk2_type VARCHAR(50) DEFAULT '',
  os VARCHAR(30) DEFAULT '',
  os_type VARCHAR(30) DEFAULT '',
  os_ver VARCHAR(20) DEFAULT '',
  product_id VARCHAR(30) DEFAULT '',
  product_key VARCHAR(30) DEFAULT '',
  bh DECIMAL(10,5) DEFAULT 0,
  dc INT DEFAULT 0,
  fcc INT DEFAULT 0,
  casing VARCHAR(10) DEFAULT '',
  display VARCHAR(10) DEFAULT '',
  port_display VARCHAR(30) DEFAULT '',
  keyboard VARCHAR(10) DEFAULT '',
  touchpad VARCHAR(10) DEFAULT '',
  port_usb VARCHAR(30) DEFAULT '',
  port_jeck VARCHAR(10) DEFAULT '',
  port_psu VARCHAR(10) DEFAULT '',
  fan VARCHAR(10) DEFAULT '',
  webcam VARCHAR(10) DEFAULT '',
  microfon VARCHAR(10) DEFAULT '',
  speaker VARCHAR(10) DEFAULT '',
  connection VARCHAR(30) DEFAULT '',
  conditions VARCHAR(10) DEFAULT '',
  sub_con VARCHAR(10) DEFAULT '',
  note_con VARCHAR(200) DEFAULT '',
  solution VARCHAR(20) DEFAULT '',
  note_sol VARCHAR(200) DEFAULT '',
  status_func VARCHAR(10) DEFAULT '',
  functions VARCHAR(20) DEFAULT '',
  note_func VARCHAR(200) DEFAULT '',
  history_pic VARCHAR(200) DEFAULT '',
  location VARCHAR(10) DEFAULT '',
  note_loc VARCHAR(100) DEFAULT '',
  status VARCHAR(20) DEFAULT 'IN USE',
  pic_nip VARCHAR(10) DEFAULT '',
  id_maintenance VARCHAR(20) DEFAULT '',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (pic_nip) REFERENCES employee(nip) ON DELETE SET NULL,
  FOREIGN KEY (location) REFERENCES site(id_site) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 14. Q_WS (Workstation column definitions)
CREATE TABLE IF NOT EXISTS `q_ws` (
  id INT AUTO_INCREMENT PRIMARY KEY,
  column_name VARCHAR(50) NOT NULL,
  data_type VARCHAR(20) DEFAULT '',
  length_info VARCHAR(50) DEFAULT '',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 15. ME (Maintenance Type)
CREATE TABLE IF NOT EXISTS `me` (
  id_maintenance VARCHAR(10) PRIMARY KEY,
  maintenance VARCHAR(30) NOT NULL,
  time_desc VARCHAR(50) DEFAULT '',
  characteristic VARCHAR(50) DEFAULT '',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 16. TASK (Maintenance Schedule)
CREATE TABLE IF NOT EXISTS `task` (
  id_task VARCHAR(20) PRIMARY KEY,
  id_maintenance VARCHAR(10) DEFAULT '',
  maintenance VARCHAR(30) DEFAULT '',
  schedule_task INT DEFAULT 0,
  sch_conv DATE DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_maintenance) REFERENCES me(id_maintenance) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 17. WH (Warehouse)
CREATE TABLE IF NOT EXISTS `wh` (
  id_wh VARCHAR(20) PRIMARY KEY,
  no VARCHAR(10) DEFAULT '',
  id_asset VARCHAR(15) DEFAULT '',
  wh_site VARCHAR(10) DEFAULT '',
  status VARCHAR(20) DEFAULT '',
  status_available TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_asset) REFERENCES workstation(id_asset) ON DELETE SET NULL,
  FOREIGN KEY (wh_site) REFERENCES site(id_site) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 18. AM (Asset Management - PR/PO)
CREATE TABLE IF NOT EXISTS `am` (
  barcode VARCHAR(20) PRIMARY KEY,
  code_item VARCHAR(10) DEFAULT '',
  owner_code VARCHAR(10) DEFAULT '',
  id_site VARCHAR(5) DEFAULT '',
  no_pr VARCHAR(30) DEFAULT '',
  no_po VARCHAR(30) DEFAULT '',
  date_pr DATE DEFAULT NULL,
  date_po DATE DEFAULT NULL,
  date_shipping DATE DEFAULT NULL,
  recipient VARCHAR(10) DEFAULT '',
  price DECIMAL(15,2) DEFAULT 0,
  qty INT DEFAULT 1,
  date_acquisition DATE DEFAULT NULL,
  coll_support VARCHAR(30) DEFAULT '',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (code_item) REFERENCES item(code_item) ON DELETE SET NULL,
  FOREIGN KEY (id_site) REFERENCES site(id_site) ON DELETE SET NULL
) ENGINE=InnoDB;
