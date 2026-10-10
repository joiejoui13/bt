<?php
require_once "../config/database.php";

// Phân trang và tìm kiếm
$limit = 5; // Số lượng khóa học hiển thị trên mỗi trang
$keyword = trim($_GET['keyword'] ?? ''); // Từ khóa tìm kiếm
$page = max(1, (int)($_GET['page'] ?? 1)); // Trang hiện tại, mặc định là trang 1
$start = ($page - 1) * $limit; // Vị trí bắt đầu

// TODO 1: Đếm tổng số bản ghi theo từ khóa hoặc tất cả bản ghi
if ($keyword != '') {
    $search = "%$keyword%";
    $count_sql = "SELECT COUNT(*)
                  FROM course_registrations
                  WHERE course_name LIKE ?
                  OR student_name LIKE ?
                  OR phone LIKE ?";
    $count_stmt = $pdo->prepare($count_sql);
    $count_stmt->execute([$search, $search, $search]);
} else {
    $count_stmt = $pdo->query("SELECT COUNT(*) FROM course_registrations");
}

$total = $count_stmt->fetchColumn(); // Tổng số bản ghi
$total_page = ($total > 0) ? ceil($total / $limit) : 1; // Tổng số trang

// TODO 2: Viết câu lệnh SQL lấy danh sách lịch đăng kí lịch học, sắp xếp id giảm dần
if ($keyword != '') {
    $search = "%$keyword%";
    $sql = "SELECT * FROM course_registrations
            WHERE course_name LIKE ?
            OR student_name LIKE ?
            OR phone LIKE ?
            ORDER BY id DESC
            LIMIT $start, $limit";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$search, $search, $search]);
    $result = $stmt;
} else {
    $sql = "SELECT * FROM course_registrations
            ORDER BY id DESC
            LIMIT $start, $limit";

    $result = $pdo->query($sql);
}
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

    <!-- Form tìm kiếm -->
    <form method="GET" action="index.php" style="margin: 20px 0;">
        <input type="text" name="keyword" value="<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?>" placeholder="Tìm kiếm khóa học, học viên, số điện thoại">
        <button type="submit" class="btn">Tìm kiếm</button>
    </form>

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

        <!-- TODO 3: Dùng while để hiển thị danh sách khóa học đăng kí -->
        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?= htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['course_name'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['student_name'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['phone'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['registration_date'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['learning_method'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['fee'], ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <?php
                    // Hiển thị trạng thái
                    if ($row['status'] == 0) {
                        echo 'Chờ duyệt';
                    } elseif ($row['status'] == 1) {
                        echo 'Đã duyệt';
                    } else {
                        echo 'Đã hủy';
                    }
                    ?>
                </td>
                <td>
                    <!-- Hành động -->
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn">Sửa</a>
                    <a href="delete.php?id=<?= $row['id'] ?>"
                       class="btn btn-danger"
                       onclick="return confirm('Bạn có chắc chắn muốn xóa đăng ký này?')">
                        Xóa
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Hiển thị phân trang với từ khóa tìm kiếm -->
    <div class="pagination" style="margin-top: 20px;">
        <?php for ($i = 1; $i <= $total_page; $i++) : ?>
            <a href="index.php?page=<?= $i ?>&keyword=<?= urlencode($keyword) ?>" 
               <?= ($i == $page) ? 'style="font-weight:bold;"' : '' ?>>
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>

    <?php
    // Bước 6. Đóng kết nối
    $pdo = null; // Đóng kết nối
    ?>
</div>
</body>
</html>
