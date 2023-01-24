<?php
    if(isset($_GET['action']) && $_GET['action'] === 'edit' && $_GET['id'] === $id){
        include "access.php";
        $query = "SELECT id, name, kana, tel, email, body FROM contacts WHERE id = $id;";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($result);
        $id = $row["id"];
        $name = $row["name"];
        $kana = $row["kana"];
        $tel = $row["tel"];
        $email = $row["email"];
        $body = $row["body"];      

        $_SESSION['id'] = $id;
        $_SESSION['name'] = $name;
        $_SESSION['kana']= $kana;
        $_SESSION['tel']= $tel;
        $_SESSION['email']= $email;
        $_SESSION['body']= $body; 
    };
    if(isset($_GET['action']) && $_GET['action'] === 'cfmedit' && $_GET['id'] === $id){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id = $_SESSION['id'];
        $name = $_SESSION['name'];
        $kana = $_SESSION['kana'];
        $tel = $_SESSION['tel'];
        $email = $_SESSION['email'];
        $body = $_SESSION['body'];
        // session_destroy();
    };
?>