<?php
if(isset($_GET['protocol'])){
    if(isset($_SESSION['UUID'])){
        $protocol = $_GET['protocol'];
    }else{
        $protocol = "auth.login";
    }
}else{
    if(isset($_SESSION['UUID'])){
        $protocol = "page.start";
    }else{
        $protocol = "auth.login";
    }
}
?>