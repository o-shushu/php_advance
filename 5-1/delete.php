<?php
    if(!isset($_GET['action']) && $_GET['id'] === $id){
        include "access.php";
        $query = "DELETE FROM contacts WHERE id = $id;";
        if (mysqli_query($link, $query)) {
            echo $id." DELETE に成功しました。\n";
        }else{
            echo 'DELETE エラー';
        }
    };
?>