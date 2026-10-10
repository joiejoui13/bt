<?php
require_once "../config/database.php";
try {
// TODO 15: Lấy id từ $_GET
$id = $_GET['id'];
// TODO 16: Truy vấn lịch hẹn theo id
$sql = "SELECT * FROM course_registrations WHERE id = $id";
$result = $pdo->query($sql);

// TODO 17: Lấy dữ liệu ra biến $course_registrations
$course_registrations = $result->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
    exit; // dừng lại, không render form khi truy vấn lỗi
}

$pdo = null; // đóng kết nối
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sửa Đăng ký khóa học</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
    <h1>Sửa đăng ký khóa học</h1>

    <form action="update.php" method="POST">
        <!-- TODO 18: Input hidden chứa id -->
        <input type="hidden" name="id" value="<?php echo $course_registrations['id']; ?>">
        <label>Tên khóa học</label>
        <!-- TODO 19: Input course_name có value là dữ liệu cũ -->
        <input type="text" name="course_name" required value="<?php echo $course_registrations['course_name']; ?>">

        <label>Số điện thoại</label>
        <!-- TODO 20: Input phone có value là dữ liệu cũ -->
        <input type="text" name="phone" required value="<?php echo $course_registrations['phone']; ?>">

        <label>Họ tên học viên</label>
        <!-- TODO 21: Input student_name có value là dữ liệu cũ -->
        <input type="text" name="student_name" required value="<?php echo $course_registrations['student_name']; ?>">

        <label>Ngày đăng ký</label>
        <!-- TODO 22: Input registration_date type date có value cũ -->
        <input type="date" name="registration_date" required value="<?php echo $course_registrations['registration_date']; ?>" max="<?php echo date('Y-m-d'); ?>">

        <label>Phương thức học</label>
        <!-- TODO 23: Input learning method type time có value cũ -->
        <input type="text" name="learning_method" required value="<?php echo $course_registrations['learning_method']; ?>">

        <label>Học phí</label>
        <!-- TODO 24: Textarea fee có dữ liệu cũ -->
        <input type="text" name="fee" required value="<?php echo $course_registrations['fee']; ?>" min="0">

        <label>Trạng thái</label>
        <!-- TODO 25: Select status tự động chọn trạng thái hiện tại -->
        <select name="status">
            <option value="0" <?php if ($course_registrations['status'] == 0) echo "selected"; ?>>Chờ duyệt</option>
            <option value="1" <?php if ($course_registrations['status'] == 1) echo "selected"; ?>>Đã duyệt</option>
            <option value="2" <?php if ($course_registrations['status'] == 2) echo "selected"; ?>>Đã hủy</option>
        </select>

        <button type="submit">Cập nhật</button>
        <a href="index.php">Quay lại</a>
    </form>
</div>
</body>
</html>
