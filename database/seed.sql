-- ==========================================
-- SEED DATA: preventive_maintenance (20 rows)
-- ==========================================
INSERT INTO preventive_maintenance (device_name, device_category, maintenance_type, schedule_date, technician, description, status, result) VALUES
('M01-ENG-NB005', 'Laptop', 'Pembersihan Internal & Thermal Paste', '2026-01-10', 'Fransiskus Simson', 'Pembersihan debu pada fan dan penggantian thermal paste', 'Selesai', 'Suhu CPU turun dari 85°C ke 65°C, kinerja meningkat'),
('M02-FIN-NB003', 'Laptop', 'Update OS & Security Patch', '2026-01-15', 'Degia Parlopa', 'Update Windows 11 Pro ke versi terbaru', 'Selesai', 'OS berhasil diupdate, semua patch terinstal'),
('M03-HRD-DT001', 'Desktop', 'Scan Antivirus & Malware', '2026-01-20', 'Fransiskus Simson', 'Full scan menggunakan Kaspersky', 'Selesai', 'Tidak ditemukan malware, sistem bersih'),
('M04-IT-PC001', 'Desktop', 'Backup Data Sistem', '2026-02-01', 'Degia Parlopa', 'Backup data ke NAS eksternal', 'Selesai', 'Backup 250GB berhasil, verifikasi OK'),
('M05-MKT-NB002', 'Laptop', 'Cek Kesehatan SSD', '2026-02-05', 'Fransiskus Simson', 'Pemeriksaan health SSD menggunakan CrystalDiskInfo', 'Selesai', 'SSD Health 92%, kondisi baik'),
('M06-HRD-PR001', 'Printer', 'Pembersihan Print Head', '2026-02-10', 'Degia Parlopa', 'Cleaning print head dan alignment', 'Selesai', 'Kualitas cetak membaik, tidak ada garis'),
('M07-ENG-DT002', 'Desktop', 'Pengecekan RAM & Memory Test', '2026-02-15', 'Fransiskus Simson', 'Test RAM menggunakan MemTest86', 'Selesai', 'RAM 16GB dalam kondisi baik, no error'),
('M08-FIN-PR001', 'Printer', 'Penggantian Roller', '2026-02-20', 'Degia Parlopa', 'Ganti roller pick-up yang aus', 'Menunggu', 'Menunggu sparepart roller tiba'),
('M09-MKT-DT001', 'Desktop', 'Pembersihan Casing & Fan', '2026-03-01', 'Fransiskus Simson', 'Pembersihan debu menyeluruh pada casing', 'Selesai', 'Sirkulasi udara kembali normal'),
('M10-IT-NB001', 'Laptop', 'Update Driver & Firmware', '2026-03-05', 'Degia Parlopa', 'Update driver VGA, chipset, dan BIOS', 'Selesai', 'Semua driver versi terbaru, BIOS updated'),
('M11-ENG-NB006', 'Laptop', 'Kalibrasi Battery', '2026-03-10', 'Fransiskus Simson', 'Kalibrasi battery hingga 100%', 'Selesai', 'Battery capacity reported 87%'),
('M12-HRD-DT002', 'Desktop', 'Defragmentasi Hardisk', '2026-03-15', 'Degia Parlopa', 'Defrag HDD 500GB', 'Selesai', 'Fragmentasi turun dari 12% ke 2%'),
('M13-FIN-NB004', 'Laptop', 'Pengecekan Port USB & Audio', '2026-03-20', 'Fransiskus Simson', 'Test semua port USB dan audio jack', 'Selesai', 'Semua port berfungsi normal'),
('M14-MKT-PR001', 'Printer', 'Kalibrasi Warna', '2026-04-01', 'Degia Parlopa', 'Kalibrasi warna printer untuk hasil cetak akurat', 'Menunggu', 'Menunggu jadwal user'),
('M15-IT-DT003', 'Desktop', 'Pembersihan RAM Slot', '2026-04-05', 'Fransiskus Simson', 'Bersihkan slot RAM dan re-seat modul', 'Selesai', 'RAM terdeteksi optimal, tidak ada lag'),
('M16-ENG-NB007', 'Laptop', 'Penggantian Thermal Pad', '2026-04-10', 'Degia Parlopa', 'Ganti thermal pad VGA dan VRM', 'Selesai', 'Suhu VGA turun drastis, performa game normal'),
('M17-HRD-PR002', 'Printer', 'Update Firmware Printer', '2026-04-15', 'Fransiskus Simson', 'Update firmware ke versi terbaru', 'Selesai', 'Firmware berhasil diupdate, fitur baru aktif'),
('M18-FIN-DT003', 'Desktop', 'Pengecekan Power Supply', '2026-04-20', 'Degia Parlopa', 'Ukur tegangan PSU menggunakan multimeter', 'Selesai', 'Tegangan stabil 12.3V, 5.1V, 3.3V'),
('M19-MKT-NB003', 'Laptop', 'Optimasi Startup & Services', '2026-05-01', 'Fransiskus Simson', 'Nonaktifkan startup program tidak perlu', 'Selesai', 'Waktu booting turun dari 45s ke 18s'),
('M20-IT-NB002', 'Laptop', 'Pengecekan Kabel Flexi LCD', '2026-05-05', 'Degia Parlopa', 'Cek koneksi kabel flexi LCD dan hinge', 'Menunggu', 'Menunggu kabel flexi pengganti');

-- ==========================================
-- SEED DATA: corrective_maintenance (20 rows)
-- ==========================================
INSERT INTO corrective_maintenance (device_name, device_category, problem, report_date, priority, technician, status, solution, sparepart_needed, completion_date) VALUES
('M04-IT-PC001', 'Desktop', 'Blue screen error IRQL_NOT_LESS_OR_EQUAL setiap kali menjalankan aplikasi berat', '2026-01-05', 'Tinggi', 'Fransiskus Simson', 'Selesai', 'Driver VGA corrupt, install ulang driver NVIDIA', NULL, '2026-01-06'),
('M05-MKT-NB002', 'Laptop', 'Battery tidak mengisi daya, hanya 15% dan langsung matup', '2026-01-08', 'Sedang', 'Degia Parlopa', 'Selesai', 'Ganti battery baru 5200mAh', 'Battery Laptop Dell', '2026-01-10'),
('M06-HRD-PR001', 'Printer', 'Printer paper jam terus menerus di tray 1', '2026-01-12', 'Rendah', 'Fransiskus Simson', 'Selesai', 'Bersihkan roller dan buang kertas tersangkut', NULL, '2026-01-12'),
('M01-ENG-NB005', 'Laptop', 'Layar berkedip-kedip saat dibuka sudut tertentu', '2026-01-18', 'Tinggi', 'Degia Parlopa', 'Selesai', 'Kabel flexi LCD putus, ganti kabel baru', 'Kabel Flexi LCD Zyrex', '2026-01-20'),
('M03-HRD-DT001', 'Desktop', 'CPU overheat hingga 95°C, sering shutdown otomatis', '2026-02-01', 'Tinggi', 'Fransiskus Simson', 'Selesai', 'Thermal paste kering, aplikasi ulang thermal paste', 'Thermal Paste MX-4', '2026-02-01'),
('M08-FIN-PR001', 'Printer', 'Printer tidak menarik kertas dari tray', '2026-02-05', 'Sedang', 'Degia Parlopa', 'Menunggu Sparepart', 'Roller pick-up aus, perlu penggantian', 'Roller Pick-up Epson', NULL),
('M09-MKT-DT001', 'Desktop', 'Tidak ada display, kipas menyala tapi monitor gelap', '2026-02-10', 'Tinggi', 'Fransiskus Simson', 'Selesai', 'RAM tidak terpasang sempurna, reseat RAM', NULL, '2026-02-10'),
('M02-FIN-NB003', 'Laptop', 'Keyboard beberapa tombol tidak berfungsi (A,S,D,F)', '2026-02-15', 'Sedang', 'Degia Parlopa', 'Selesai', 'Keyboard terkena cairan, ganti keyboard baru', 'Keyboard Laptop Dell Latitude', '2026-02-17'),
('M10-IT-NB001', 'Laptop', 'Windows tidak bisa booting, stuck di logo', '2026-02-20', 'Tinggi', 'Fransiskus Simson', 'Selesai', 'System file corrupt, repair menggunakan bootable USB', NULL, '2026-02-21'),
('M11-ENG-NB006', 'Laptop', 'Touchpad tidak responsif', '2026-03-01', 'Rendah', 'Degia Parlopa', 'Selesai', 'Driver touchpad disable, enable di Device Manager', NULL, '2026-03-01'),
('M07-ENG-DT002', 'Desktop', 'Sering restart sendiri saat rendering video', '2026-03-05', 'Tinggi', 'Fransiskus Simson', 'Selesai', 'PSU tidak stabil, ganti PSU baru 550W', 'Power Supply 550W', '2026-03-07'),
('M12-HRD-DT002', 'Desktop', 'Hardisk berbunyi klik-klik (clicking sound)', '2026-03-10', 'Tinggi', 'Degia Parlopa', 'Selesai', 'HDD bad sector parah, backup data dan ganti SSD', 'SSD 512GB SATA', '2026-03-12'),
('M13-FIN-NB004', 'Laptop', 'WiFi tidak mendeteksi jaringan sama sekali', '2026-03-15', 'Sedang', 'Fransiskus Simson', 'Selesai', 'WiFi card rusak, ganti module Intel AX200', 'WiFi Card Intel AX200', '2026-03-16'),
('M14-MKT-PR001', 'Printer', 'Hasil cetak bergaris-garis horizontal', '2026-03-20', 'Rendah', 'Degia Parlopa', 'Selesai', 'Print head kotor, jalankan deep cleaning 3x', NULL, '2026-03-20'),
('M15-IT-DT003', 'Desktop', 'USB port depan tidak berfungsi', '2026-04-01', 'Rendah', 'Fransiskus Simson', 'Selesai', 'Kabel USB front panel longgar, perbaiki koneksi', NULL, '2026-04-01'),
('M16-ENG-NB007', 'Laptop', 'Battery mengembung (swollen battery)', '2026-04-05', 'Tinggi', 'Degia Parlopa', 'Menunggu Sparepart', 'Battery bengkak, harus segera diganti', 'Battery Laptop Zyrex', NULL),
('M17-HRD-PR002', 'Printer', 'Error code 0xEA - Service required', '2026-04-10', 'Sedang', 'Fransiskus Simson', 'Selesai', 'Ink pad waste counter full, reset EEPROM', NULL, '2026-04-11'),
('M18-FIN-DT003', 'Desktop', 'Audio tidak keluar dari speaker eksternal', '2026-04-15', 'Rendah', 'Degia Parlopa', 'Selesai', 'Audio jack rusak, ganti audio port panel', 'Audio Jack Panel', '2026-04-16'),
('M19-MKT-NB003', 'Laptop', 'BSOD dengan error MEMORY_MANAGEMENT', '2026-04-20', 'Tinggi', 'Fransiskus Simson', 'Selesai', 'Salah satu modul RAM rusak, ganti RAM baru', 'RAM DDR4 8GB', '2026-04-22'),
('M20-IT-NB002', 'Laptop', 'Webcam tidak terdeteksi di aplikasi apapun', '2026-05-01', 'Sedang', 'Degia Parlopa', 'Proses', 'Driver webcam hilang, sedang install ulang driver', NULL, NULL);

-- ==========================================
-- SEED DATA: predictive_maintenance (20 rows)
-- ==========================================
INSERT INTO predictive_maintenance (device_name, device_category, prediction, accuracy, recommendation, predicted_date, status, actual_condition) VALUES
('M01-ENG-NB005', 'Laptop', 'Battery degradation diperkirakan turun di bawah 80% dalam 3 bulan', 92.50, 'Segera lakukan pengecekan battery health dan siapkan penggantian', '2026-03-15', 'Terbukti', 'Battery health turun ke 78%, perlu diganti'),
('M04-IT-PC001', 'Desktop', 'PSU berpotensi gagal berdasarkan fluktuasi tegangan', 88.00, 'Ganti PSU preventif sebelum mengalami kerusakan total', '2026-04-01', 'Terbukti', 'PSU mengalami failure 2 minggu setelah prediksi'),
('M05-MKT-NB002', 'Laptop', 'SSD mendekati end of life berdasarkan S.M.A.R.T data', 95.00, 'Backup data segera dan siapkan SSD pengganti', '2026-03-20', 'Terbukti', 'SSD reallocated sector meningkat drastis'),
('M02-FIN-NB003', 'Laptop', 'Thermal paste kemungkinan sudah kering, suhu naik 10% per bulan', 82.30, 'Jadwalkan penggantian thermal paste dalam 1 bulan', '2026-04-10', 'Terbukti', 'Suhu CPU mencapai 92°C, thermal paste sudah kering'),
('M03-HRD-DT001', 'Desktop', 'RAM berpotensi error berdasarkan memory test pattern', 76.50, 'Lakukan memtest lebih lanjut, siapkan RAM cadangan', '2026-05-01', 'Tidak Terbukti', 'RAM masih berfungsi normal setelah 3 bulan'),
('M06-HRD-PR001', 'Printer', 'Print head mengalami penurunan kualitas cetak', 71.20, 'Jadwalkan deep cleaning dan siapkan print head baru', '2026-04-15', 'Terbukti', 'Kualitas cetak menurun, perlu cleaning intensif'),
('M07-ENG-DT002', 'Desktop', 'Fan CPU menunjukkan peningkatan noise, bearing mulai aus', 89.00, 'Ganti fan CPU dalam 2 minggu untuk mencegah overheat', '2026-05-10', 'Terbukti', 'Fan CPU mulai berisik dan RPM tidak stabil'),
('M08-FIN-PR001', 'Printer', 'Roller pick-up aus berdasarkan jumlah cetakan (50.000 halaman)', 94.00, 'Pesan roller pick-up baru, jadwalkan penggantian', '2026-06-01', 'Terbukti', 'Roller pick-up sudah aus, kertas sering tidak masuk'),
('M09-MKT-DT001', 'Desktop', 'HDD menunjukkan peningkatan bad sector', 85.00, 'Backup data penting dan siapkan migrasi ke SSD', '2026-05-20', 'Terbukti', 'Bad sector bertambah 15 block dalam 2 bulan'),
('M10-IT-NB001', 'Laptop', 'Battery cycle count mendekati 500, kapasitas menurun', 91.00, 'Rencanakan penggantian battery dalam 2 bulan', '2026-06-15', 'Menunggu', ''),
('M11-ENG-NB006', 'Laptop', 'Hinge retak berpotensi merusak LCD dalam waktu dekat', 78.00, 'Ganti hinge case sebelum merusak kabel flexi LCD', '2026-06-10', 'Menunggu', ''),
('M12-HRD-DT002', 'Desktop', 'Power Supply tegangan 3.3V tidak stabil (3.1V - 3.4V)', 83.50, 'Monitor PSU secara berkala, siapkan PSU cadangan', '2026-06-20', 'Menunggu', ''),
('M13-FIN-NB004', 'Laptop', 'Keyboard mulai tidak responsif di beberapa tombol', 69.00, 'Bersihkan keyboard dan siapkan penggantian jika diperlukan', '2026-07-01', 'Menunggu', ''),
('M14-MKT-PR001', 'Printer', 'Ink pad waste counter mendekati batas maksimal', 97.00, 'Persiapkan reset EEPROM atau ganti ink pad', '2026-07-05', 'Menunggu', ''),
('M15-IT-DT003', 'Desktop', 'CMOS battery lemah, tanggal sering reset', 88.00, 'Ganti battery CMOS CR2032', '2026-07-15', 'Menunggu', ''),
('M16-ENG-NB007', 'Laptop', 'Battery mengembung secara fisik, berbahaya', 99.00, 'Segera ganti battery, risiko kebakaran', '2026-07-20', 'Menunggu', ''),
('M17-HRD-PR002', 'Printer', 'Firmware usang berpotensi masalah kompatibilitas', 65.00, 'Update firmware ke versi terbaru', '2026-08-01', 'Menunggu', ''),
('M18-FIN-DT003', 'Desktop', 'Ethernet port intermittent, kecepatan turun ke 100Mbps', 74.00, 'Cek kabel LAN dan siapkan USB Ethernet adapter', '2026-08-10', 'Menunggu', ''),
('M19-MKT-NB003', 'Laptop', 'Sistem terinfeksi adware, performa menurun 20%', 80.00, 'Scan antivirus menyeluruh dan hapus program mencurigakan', '2026-08-15', 'Menunggu', ''),
('M20-IT-NB002', 'Laptop', 'Webcam driver corrupt setelah Windows update', 72.00, 'Rollback Windows update dan reinstall driver webcam', '2026-08-20', 'Menunggu', '');
