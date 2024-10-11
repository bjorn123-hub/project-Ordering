<?php

if(isset($_POST['fname']) &&
   isset($_POST['uname']) &&
   isset($_POST['pass'])) {
   
    include "../db_conn.php";

    $fname = $_POST['fname'];
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];

    $data = "fname=".$fname."&uname=".$uname;

    if (empty($fname)) {
        $em = "Full name is required";
        header("Location: ../home.php?error=$em&$data");
        exit;
    } else if (empty($uname)) {
        $em = "User name is required";
        header("Location: ../home.php?error=$em&$data");
        exit;
    } else if (empty($pass)) {
        $em = "Password is required";
        header("Location: ../home.php?error=$em&$data");
        exit;
    } else {
        // Hashing the password
        $pass = password_hash($pass, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user(fname, username, password) VALUES(?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$fname, $uname, $pass]);

        header("Location: ../home.php?success=Your account has been created successfully");
        exit;
    }
} else {
    header("Location: ../index.php?error=error");
    exit;
}
?>
