<?php
// Function to check user credentials
function checkUser($user, $pass) {
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['role'];
    } else {
        return 0;
    }
}

// Function to get user information
function getUserInfo($user, $pass) {
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();
    $userInfo = array();
    while ($row = $result->fetch_assoc()) {
        $userInfo[] = $row;
    }
    return $userInfo;
}

// Function to establish MySQLi connection
function connectDB() {
    $host = "localhost";
    $username = "your_username";
    $password = "your_password";
    $dbname = "boardgame";

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Không thể kết nối " . $conn->connect_error);
    }

    return $conn;
}
?>
