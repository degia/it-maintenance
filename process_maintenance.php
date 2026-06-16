<?php
require_once 'includes/auth.php';
require_login();

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");
    exit;
}

$type = $_POST['type'] ?? '';
$redirect = "index.php?page=";

switch ($type) {
    case 'preventive':
        $redirect .= 'preventive';
        $sql = "INSERT INTO preventive_maintenance 
                (device_name, device_category, maintenance_type, schedule_date, technician, description, status, result)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $_POST['device_name'],
                $_POST['device_category'],
                $_POST['maintenance_type'],
                $_POST['schedule_date'],
                $_POST['technician'],
                $_POST['description'],
                $_POST['status'],
                $_POST['result']
            ]);
            echo "<script>alert('Data preventive maintenance berhasil ditambahkan!'); window.location.href='$redirect';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href='$redirect';</script>";
        }
        break;

    case 'corrective':
        $redirect .= 'corrective';
        $sql = "INSERT INTO corrective_maintenance 
                (device_name, device_category, problem, report_date, priority, technician, status, solution, sparepart_needed, completion_date)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $_POST['device_name'],
                $_POST['device_category'],
                $_POST['problem'],
                $_POST['report_date'],
                $_POST['priority'],
                $_POST['technician'],
                $_POST['status'],
                $_POST['solution'],
                $_POST['sparepart_needed'],
                $_POST['completion_date'] ?: null
            ]);
            echo "<script>alert('Data corrective maintenance berhasil ditambahkan!'); window.location.href='$redirect';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href='$redirect';</script>";
        }
        break;

    case 'predictive':
        $redirect .= 'predictive';
        $sql = "INSERT INTO predictive_maintenance 
                (device_name, device_category, prediction, accuracy, recommendation, predicted_date, status, actual_condition)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $_POST['device_name'],
                $_POST['device_category'],
                $_POST['prediction'],
                $_POST['accuracy'],
                $_POST['recommendation'],
                $_POST['predicted_date'],
                $_POST['status'],
                $_POST['actual_condition']
            ]);
            echo "<script>alert('Data predictive maintenance berhasil ditambahkan!'); window.location.href='$redirect';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href='$redirect';</script>";
        }
        break;

    default:
        header("Location: index.php");
        break;
}
