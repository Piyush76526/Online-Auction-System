<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";


    if ($name == "" || $email == "" || $password == "" || $confirm_password == "") {

        die("Please fill all fields.");

    }


    if ($password !== $confirm_password) {

        die("Passwords do not match.");

    }


    $checkSql = "SELECT id FROM users WHERE email = ?";

    $checkStmt = $conn->prepare($checkSql);

    if (!$checkStmt) {
        die("Prepare Error: " . $conn->error);
    }

    $checkStmt->bind_param("s", $email);

    $checkStmt->execute();

    $checkStmt->store_result();


    if ($checkStmt->num_rows > 0) {

        die("Email already registered.");

    }

    $checkStmt->close();


    $hashedPassword = password_hash(
        $password,
        PASSWORD_DEFAULT
    );


    $sql = "INSERT INTO users
            (name, email, password)
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare Error: " . $conn->error);
    }

    $stmt->bind_param(
        "sss",
        $name,
        $email,
        $hashedPassword
    );


    if ($stmt->execute()) {

        echo "<h1>Registration Successful!</h1>";
        echo "<p>Welcome, " . htmlspecialchars($name) . "</p>";
        echo '<a href="login.html">Go to Login</a>';

    } else {

        die("Registration Error: " . $stmt->error);

    }


    $stmt->close();
    $conn->close();

} else {

    echo "Invalid request.";

}

?>
