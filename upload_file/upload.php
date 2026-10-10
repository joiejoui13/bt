<?php 
#print_r($_FILES); // In ra thông tin file upload để kiểm tra
#Xử lý upload file
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['myfile']) && $_FILES['myfile']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'upload/'; // Thư mục lưu trữ file upload
        $uploadFile = $uploadDir . basename($_FILES['myfile']['name']);
        // Kiểm tra xem thư mục upload có tồn tại không, nếu không thì tạo mới
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);        }
        //kiểm tra kiểu file dạng ảnh và kích thước file <2MB
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB
        $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        if (!in_array($fileType, $allowedTypes)) {
            echo "Chỉ cho phép upload file ảnh (JPG, JPEG, PNG, GIF).";
            exit;
        }
        if ($_FILES['myfile']['size'] > $maxFileSize) {
            echo "Kích thước file không được vượt quá 2MB.";
            exit;
        }
        // Di chuyển file từ thư mục tạm sang thư mục upload
        if (move_uploaded_file($_FILES['myfile']['tmp_name'], $uploadFile)) {
            echo "File đã được upload thành công: " 
            . htmlspecialchars(basename($_FILES['myfile']['name']));
        } else {
            echo "Có lỗi xảy ra khi upload file.";
        }
    } else {
        echo "Không có file nào được chọn hoặc có lỗi xảy ra.";
    }
} else {
    echo "Phương thức yêu cầu không hợp lệ.";
}
?>