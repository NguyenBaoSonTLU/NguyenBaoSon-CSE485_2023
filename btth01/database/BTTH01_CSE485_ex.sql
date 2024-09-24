a
SELECT baiviet.ten_bhat
FROM baiviet
INNER JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai
WHERE theloai.ten_tloai = 'Nhạc trữ tình';
b
SELECT baiviet.*
FROM baiviet
INNER JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
WHERE tacgia.ten_tgia = 'Nhacvietplus';
c
SELECT theloai.ten_tloai
FROM theloai
LEFT JOIN baiviet ON theloai.ma_tloai = baiviet.ma_tloai
WHERE baiviet.ma_bviet IS NULL;
d
SELECT baiviet.ma_bviet, baiviet.ma_bviet, baiviet.ten_bhat, tacgia.ten_tgia, theloai.ten_tloai, baiviet.ngayviet
FROM baiviet
INNER JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
INNER JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai;
e
SELECT theloai.ten_tloai, COUNT(baiviet.ma_bviet) AS SoLuongBaiViet
FROM baiviet
INNER JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai
GROUP BY theloai.ten_tloai
ORDER BY SoLuongBaiViet DESC
LIMIT 1;
f
SELECT tacgia.ten_tgia, COUNT(baiviet.ma_bviet) AS SoLuongBaiViet
FROM baiviet
INNER JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
GROUP BY tacgia.ten_tgia
ORDER BY SoLuongBaiViet DESC
LIMIT 2;
g
SELECT *
FROM baiviet
WHERE ten_bhat LIKE '%yêu%' 
   OR ten_bhat LIKE '%thương%'
   OR ten_bhat LIKE '%anh%'
   OR ten_bhat LIKE '%em%';
h
SELECT *
FROM baiviet
WHERE ma_bviet LIKE '%yêu%' 
   OR ma_bviet LIKE '%thương%'
   OR ma_bviet LIKE '%anh%'
   OR ma_bviet LIKE '%em%'
   OR ten_bhat LIKE '%yêu%'
   OR ten_bhat LIKE '%thương%'
   OR ten_bhat LIKE '%anh%'
   OR ten_bhat LIKE '%em%';
i
CREATE VIEW vw_Music AS
SELECT baiviet.ma_bviet, baiviet.ten_bhat, tacgia.ten_tgia, theloai.ten_tloai, baiviet.ngayviet
FROM baiviet
INNER JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
INNER JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai;
j
DELIMITER //
CREATE PROCEDURE sp_DSBaiViet(IN tenTheLoai VARCHAR(255))
BEGIN
    IF (SELECT COUNT(*) FROM theloai WHERE ten_tloai = tenTheLoai) = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Thể loại không tồn tại';
    ELSE
        SELECT baiviet.*
        FROM baiviet
        INNER JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai
        WHERE theloai.ten_tloai = tenTheLoai;
    END IF;
END //
DELIMITER ;
k
DELIMITER $$

CREATE TRIGGER tg_CapNhatTheLoai
AFTER INSERT ON baiviet
FOR EACH ROW
BEGIN
    UPDATE theloai
    SET SLBaiViet = SLBaiViet + 1
    WHERE ma_tloai = NEW.ma_tloai;
END$$

CREATE TRIGGER tg_CapNhatTheLoai_Sua
AFTER UPDATE ON baiviet
FOR EACH ROW
BEGIN
    IF OLD.ma_tloai <> NEW.ma_tloai THEN
        UPDATE theloai
        SET SLBaiViet = SLBaiViet - 1
        WHERE ma_tloai = OLD.ma_tloai;

        UPDATE theloai
        SET SLBaiViet = SLBaiViet + 1
        WHERE ma_tloai = NEW.ma_tloai;
    END IF;
END$$

CREATE TRIGGER tg_CapNhatTheLoai_Xoa
AFTER DELETE ON baiviet
FOR EACH ROW
BEGIN
    UPDATE theloai
    SET SLBaiViet = SLBaiViet - 1
    WHERE ma_tloai = OLD.ma_tloai;
END$$

DELIMITER ;


l
CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);