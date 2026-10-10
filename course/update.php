<?php
//sửa thông tin loại sản phẩm trong bảng course
#Bước 0. Lấy dữ liệu từ form gửi lên
$id = $_POST['id'];
$course_name = $_POST['course_name'];
$student_name = $_POST['student_name'];
$phone = $_POST['phone'];
$registration_date = $_POST['registration_date'];
$learning_method = $_POST['learning_method'];
$fee = $_POST['fee'];
$status = $_POST['status'];
#Bước 1. Kết nối CSDL
require_once "../config/database.php";
try{
    #Bước 2. Viết câu lệnh truy vấn
    $sql = "UPDATE course_registrations SET course_name = :course_name, student_name = :student_name, phone = :phone, registration_date = :registration_date, learning_method = :learning_method, fee = :fee, status = :status WHERE id = :id";
    #Bước 3. Chuẩn bị câu lệnh
    $stmt = $pdo->prepare($sql);
    #Bước 4. Gán giá trị cho các tham số
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':course_name', $course_name);
    $stmt->bindParam(':student_name', $student_name);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':registration_date', $registration_date);
    $stmt->bindParam(':learning_method', $learning_method);
    $stmt->bindParam(':fee', $fee);
    $stmt->bindParam(':status', $status);
    #Bước 5. Thực thi câu lệnh
    $stmt->execute();
    #echo "Sửa loại sản phẩm thành công!";
    header("Location: index.php?info=updatesuccess"); // Chuyển hướng về trang danh sách loại sản phẩm sau khi sửa thành công
}
catch(PDOException $e){
    echo "Lỗi: " . $e->getMessage();
}
$pdo = null;
?>