-- =========================================================
-- CSDL cho Đề kiểm tra 2 - Lập trình Web với PHP
-- Chủ đề: Quản lý đăng ký khóa học
-- Database: web_crud_course
-- =========================================================

CREATE DATABASE IF NOT EXISTS web_crud_course
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE web_crud_course;

DROP TABLE IF EXISTS course_registrations;

CREATE TABLE course_registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(150) NOT NULL,
    student_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    registration_date DATE NOT NULL,
    learning_method VARCHAR(30) NOT NULL,
    fee DECIMAL(12,2) NOT NULL DEFAULT 0,
    status TINYINT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

-- Dữ liệu mẫu
INSERT INTO course_registrations
(course_name, student_name, phone, registration_date, learning_method, fee, status)
VALUES
('Lập trình Web với PHP', 'Nguyễn Minh Anh', '0912345678', '2026-09-01', 'Trực tiếp', 2500000, 1),
('Lập trình Web với PHP', 'Trần Hoàng Nam', '0987654321', '2026-09-03', 'Trực tuyến', 2200000, 0),
('Cơ sở dữ liệu MySQL', 'Lê Thu Hà', '0905123456', '2026-09-05', 'Trực tiếp', 1800000, 1),
('Lập trình C# .NET', 'Phạm Quang Huy', '0938123456', '2026-09-06', 'Trực tuyến', 2800000, 0),
('Phân tích dữ liệu với Python', 'Vũ Ngọc Lan', '0977123456', '2026-09-08', 'Trực tiếp', 3000000, 1),
('Lập trình Web với PHP', 'Đỗ Đức Anh', '0963456789', '2026-09-10', 'Trực tuyến', 2200000, 2),
('Cơ sở dữ liệu MySQL', 'Nguyễn Thị Mai', '0918765432', '2026-09-12', 'Trực tiếp', 1800000, 0),
('Lập trình C# .NET', 'Hoàng Văn Bình', '0981234567', '2026-09-14', 'Trực tiếp', 2800000, 1);

-- Quy ước status:
-- 0 = Chờ duyệt
-- 1 = Đã duyệt
-- 2 = Đã hủy
