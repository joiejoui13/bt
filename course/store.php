<?php
require_once "../config/database.php";

// TODO 11: Nhận student_name, phone, course_name, registration_date, learning_method, fee, status
$student_name = $_POST['student_name'];
$phone = $_POST['phone'];
$course_name = $_POST['course_name'];
$registration_date = $_POST['registration_date'];
$learning_method = $_POST['learning_method'];
$fee = $_POST['fee'];
$status = $_POST['status'];

// TODO 12: Viết câu lệnh INSERT INTO course_registrations
$sql = "INSERT INTO course_registrations (student_name, phone, course_name, registration_date, learning_method, fee, status) VALUES ('$student_name', '$phone', '$course_name', '$registration_date', '$learning_method', '$fee', '$status')";

// TODO 13: Thực thi truy vấn
try{
    $pdo->query($sql);
    // TODO 14: Chuyển hướng về index.php
    header("Location: index.php", true, 303);
exit();
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>