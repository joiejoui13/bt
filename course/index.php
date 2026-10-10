<?php
require_once "../config/database.php";
//Phân trang
    $limit = 3; // Số lượng khóa học hiển thị trên mỗi trang
    $numberOfPages = 0; // Tổng số trang
    $sql_count="SELECT COUNT(id) AS total FROM course_registrations"; // Câu lệnh SQL để đếm tổng số khóa học
    $stmt_count = $pdo->query($sql_count); // Thực thi câu lệnh SQL đếm tổng số khóa học
    $row_count = $stmt_count->fetch(PDO::FETCH_ASSOC); // Lấy kết quả đếm tổng số khóa học
    $totalRecords = $row_count['total']; // Tổng số khóa học
    $numberOfPages = ceil($totalRecords / $limit); // Tính tổng số
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1; // Trang hiện tại, mặc định là trang 1
    $offset = ($currentPage - 1) * $limit; // Vị trí
//Tìm kiếm 
$keyword = trim($_GET['keyword']??'');
$limit = 5;
$page= (int)($_GET['page']??1);
$start =($page -1)*$limit;


if ($keyword != '') {
    $count_sql = "SELECT COUNT(*) FROM course_registrations
                  WHERE course_name LIKE ?
                  OR student_name LIKE ?
                  OR phone LIKE ?";


    $count_stmt = $pdo->prepare($count_sql);
    $search = "%$keyword%";
    $count_stmt->execute([ $search, $search, $search ]);
    }


else {
    $count_stmt = $pdo->query("SELECT COUNT(*) FROM course_registrations");
    }


$total = $count_stmt->fetchColumn();
$total_page = ceil($total / $limit);




if ($keyword != '') {
$sql = "SELECT * FROM course_registrations
    WHERE course_name LIKE ?
    OR student_name LIKE ?
    OR phone LIKE ?
    ORDER BY id DESC
    LIMIT $start, $limit";


    $stmt = $pdo->prepare($sql);


    $search = "%$keyword%";
    $stmt->execute([ $search, $search, $search ]);
    $result = $stmt; }
else {
$sql ="SELECT * FROM course_registrations
        ORDER BY id DESC
        LIMIT $start, $limit";


$result = $pdo->query($sql);
}

// TODO 1: Viết câu lệnh SQL lấy danh sách lịch đăng kí lịch học, sắp xếp id giảm dần
$sql = "SELECT * FROM course_registrations ORDER BY id DESC LIMIT $offset, $limit";
// TODO 2: Thực thi truy vấn và lưu kết quả vào biến $result
$result = $pdo->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Danh sách đăng ký khóa học</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
    <h1>Danh sách đăng ký khóa học</h1>

    <a href="create.php" class="btn">Thêm mới</a> 
    <!-- -tí nữa nhớ sửa về create.php -->

    <table>
        <tr>
            <th>ID</th>
            <th>Khóa học</th>
            <th>Học viên</th>
            <th>Điện thoại</th>
            <th>Ngày đăng ký</th>
            <th>Phương thức học</th>
            <th>Học phí</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>


<!-- // TODO 3: Dùng while để hiển thị danh sách khóa học đăng kí  -->
<?php
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            echo "<tr>";

            echo "<td>" . $row['id'] . "</td>";

            echo "<td>" . $row['course_name'] . "</td>";

            echo "<td>" . $row['student_name'] . "</td>";

            echo "<td>" . $row['phone'] . "</td>";

            echo "<td>" . $row['registration_date'] . "</td>";

            echo "<td>" . $row['learning_method'] . "</td>";

            echo "<td>" . $row['fee'] . "</td>";

            // Hiển thị trạng thái
            if ($row['status'] == 0) {
                echo "<td>Chờ duyệt</td>";
            } elseif ($row['status'] == 1) {
                echo "<td>Đã duyệt</td>";
            } else {
                echo "<td>Đã hủy</td>";
            }

           

            // Hành động
            echo "<td>
                    <a href='edit.php?id=" . $row['id'] . "' class='btn'>Sửa</a>

                    <a href='delete.php?id=" . $row['id'] . "'
                       class='btn btn-danger'
                       onclick='return confirm(\"Bạn có chắc chắn muốn xóa đăng ký này?\")'>
                       Xóa
                    </a>
                  </td>";

            echo "</tr>";
        }
        

               #hiển thị phân trang
    echo "<div>";
    for ($page = 1; $page <= $numberOfPages; $page++)
    {
        echo "<a href='index.php?page=" . $page . "'>" . $page . "</a> ";
    }   
    echo "</div>";

    #Cần chuyển cách hiển thị sang bảng HTML để dễ nhìn hơn, nhưng tạm thời hiển thị như trên để kiểm tra dữ liệu có lấy ra được hay không.
    #Bước 6. Đóng kết nối
    $pdo = null; // Đóng kết nối 
?>

    </table>
    <!--Tìm kiếm!-->
     <?php for($i=1;$i<=$total_page;$i++){ ?>
         <a href="index.php?page=<?= $i ?>
         &keyword=<?= urlencode($keyword) ?>">
             <?= $i ?>
             </a>
   <?php } ?>
   <!--Kết thúc tìm kiếm!-->

</div>
</body>
</html>
