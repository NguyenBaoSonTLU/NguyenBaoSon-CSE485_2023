<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style_signup.css">
</head>
<body>
<?php
include '../btth01/Connect/db.php';

// Lấy dữ liệu từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
        $user = $_POST['username'];
        $pass = $_POST['password'];
    

        // Bảo mật mật khẩu
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        // Chuẩn bị câu lệnh SQL
        $sql = "INSERT INTO users (username, password) VALUES ('$user', '$hashed_password')";

        // Kiểm tra và thực thi câu lệnh SQL
        if ($conn->query($sql) === TRUE) {
            echo "Đăng ký thành công!";
        } else {
            echo "Lỗi: " . $conn->error;
        }
    } else {
        echo "Vui lòng điền đầy đủ thông tin.";
    }
}
?>



<div class="header">
		<h2>Register</h2>
	</div>
	
	<form method="post" action="signup.php">

		

		<div class="input-group">
			<label>Username</label>
			<input type="text" id="username" name="username" value="">
		</div>
		<div class="input-group">
			<label>Email</label>
			<input type="text" name="email" value="">
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" id="password" name="password">
		</div>
		<div class="input-group">
			<label>Confirm password</label>
			<input type="password" name="password_2">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="reg_user">Register</button>
		</div>
		<p>
			Already a member? <a href="./login.php">Log in</a>
		</p>
	</form>
</body>
</html>