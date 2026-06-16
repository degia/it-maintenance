<?php
require_once 'includes/auth.php';
require_login();

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Ambil data dari form
    $form_no = $_POST['form_no'];
    $user_name = $_POST['user_name'];
    $user_nik = $_POST['user_nik'];
    $department = $_POST['department'];
    $site_unit = $_POST['site_unit'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $device_category = $_POST['device_category'];
    $device_brand = $_POST['device_brand'];
    $device_type = $_POST['device_type'];
    $device_name = $_POST['device_name'];
    $serial_number = $_POST['serial_number'];
    $asset_number = $_POST['asset_number'];

    // 2. Konversi Array Hardware & Software ke JSON
    $hardware_check = json_encode($_POST['hw'] ?? []);
    $software_check = json_encode($_POST['sw'] ?? []);

    // 3. Gabungkan checkbox actions menjadi string dipisahkan koma
    $actions_taken = isset($_POST['actions']) ? implode(", ", $_POST['actions']) : "Tidak ada tindakan";

    $os_name = $_POST['os_name'];
    $system_performance = $_POST['system_performance'];
    $notes = $_POST['notes'];
    $inspector_name = $_POST['inspector_name'];
    $manager_name = $_POST['manager_name'];
    $spv_name = $_POST['spv_name'];
    $inspection_date = $_POST['inspection_date'];

    // 4. Query Insert menggunakan Prepared Statement (Aman dari SQL Injection)
    $sql = "INSERT INTO device_inspections (
        form_no, user_name, user_nik, department, site_unit, email, phone,
        device_category, device_brand, device_type, device_name, serial_number, asset_number,
        hardware_check, software_check, actions_taken, os_name, system_performance, notes,
        inspector_name, manager_name, spv_name, inspection_date
    ) VALUES (
        :form_no, :user_name, :user_nik, :department, :site_unit, :email, :phone,
        :device_category, :device_brand, :device_type, :device_name, :serial_number, :asset_number,
        :hardware_check, :software_check, :actions_taken, :os_name, :system_performance, :notes,
        :inspector_name, :manager_name, :spv_name, :inspection_date
    )";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':form_no' => $form_no,
            ':user_name' => $user_name,
            ':user_nik' => $user_nik,
            ':department' => $department,
            ':site_unit' => $site_unit,
            ':email' => $email,
            ':phone' => $phone,
            ':device_category' => $device_category,
            ':device_brand' => $device_brand,
            ':device_type' => $device_type,
            ':device_name' => $device_name,
            ':serial_number' => $serial_number,
            ':asset_number' => $asset_number,
            ':hardware_check' => $hardware_check,
            ':software_check' => $software_check,
            ':actions_taken' => $actions_taken,
            ':os_name' => $os_name,
            ':system_performance' => $system_performance,
            ':notes' => $notes,
            ':inspector_name' => $inspector_name,
            ':manager_name' => $manager_name,
            ':spv_name' => $spv_name,
            ':inspection_date' => $inspection_date
        ]);

        echo "<script>alert('Data berhasil disimpan ke database!'); window.location.href='index.php?page=form';</script>";
    } catch (PDOException $e) {
        die("Error saat menyimpan data: " . $e->getMessage());
    }
} else {
    echo "Akses tidak diizinkan.";
}
