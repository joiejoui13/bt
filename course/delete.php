<?php
    #Thực hiện xóa loại sản phẩm khỏi bảng course_registrations
    #Bước 0. Lấy ID loại sản phẩm từ URL
    $id = $_GET['id']; // Ví dụ: xóa loại sản phẩm có ID = 3, bạn có thể thay đổi giá trị này theo nhu cầu
    #Bước 1. Kết nối CSDL
    require_once "../config/database.php";
    try{
        #Bước 2. Viết câu lệnh truy vấn
        $sql = "DELETE FROM course_registrations WHERE id = :id";
        #Bước 3. Chuẩn bị câu lệnh
        $stmt = $pdo->prepare($sql);
        #Bước 4. Gán giá trị cho tham số
        $stmt->bindParam(':id', $id);
        #Bước 5. Thực thi câu lệnh
        $stmt->execute();
        #echo "Xóa loại sản phẩm thành công!";
        header("Location: index.php?info=deletesuccess"); // Chuyển hướng về trang danh sách loại sản phẩm sau khi xóa thành công
    }
    catch(PDOException $e){
        echo "Lỗi: " . $e->getMessage();
    }
    #Bước 6. Đóng kết nối
    $pdo = null;
?>