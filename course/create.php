
<?php
// courses/create.php

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm đăng ký khóa học</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>  
<body>

<h2>THÊM ĐĂNG KÝ KHÓA HỌC</h2>

<form action="store.php" method="POST">

    <div>
        <label for="course_name">Tên khóa học:</label>
        <input type="text"
               id="course_name"
               name="course_name"
               required>
    </div>

    <br>

    <div>
        <label for="student_name">Họ tên học viên:</label>
        <input type="text"
               id="student_name"
               name="student_name"
               required>
    </div>

    <br>

    <div>
        <label for="phone">Số điện thoại:</label>
        <input type="text"
               id="phone"
               name="phone"
               required>
    </div>

    <br>

    <div>
    <label for="registration_date">Ngày đăng ký:</label>
    <input type="date"
           id="registration_date"
           name="registration_date"
           max="<?php echo date('Y-m-d'); ?>"
           value="<?php echo date('Y-m-d'); ?>"
           required>
    </div>

    <br>

    <div>
        <label for="learning_method">Hình thức học:</label>
        <select id="learning_method" name="learning_method" required>
            <option value="">-- Chọn hình thức học --</option>
            <option value="Trực tiếp">Trực tiếp</option>
            <option value="Trực tuyến">Trực tuyến</option>
        </select>
    </div>

    <br>

    <div>
        <label for="fee">Học phí:</label>
        <input type="number"
               id="fee"
               name="fee"
               min="0"
               step="1000"
               required>
    </div>

    <br>

    <div>
        <label for="status">Trạng thái:</label>
        <select id="status" name="status" >
            <option value="0">Chờ duyệt</option>
            <option value="1">Đã duyệt</option>
            <option value="2">Đã hủy</option>
        </select>
    </div>

    <br>

    <button type="submit">Thêm mới</button>
    <a href="index.php">Quay lại</a>

</form>

</body>
</html>
