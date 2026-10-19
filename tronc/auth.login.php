<form method="POST">
    <input type="text" name="login" placeholder="Please enter your login">
    <input type="password" name="pwd" placeholder="Please enter your password">
    <input type="submit" name="go" value="Login">
<?php
    if(isset($_POST["go"])){
        $login = $_POST["login"];
        $pwd = $_POST["pwd"];
        $count_logins = mysqli_query($connect, "SELECT COUNT(id) FROM `users` WHERE `login`='$login'")or die(mysqli_error());
        while($count_logins_1 = mysqli_fetch_assoc($count_logins)){
            if($count_logins_1 == 1){
                $collect_uuid_and_pwd = mysqli_query($connect, "SELECT `UUID`, `pwd` FROM `users` WHERE `login`='$login'")or die(mysqli_error());
                while($collect_uuid_and_pwd_1 = mysqli_fetch_assoc($collect_uuid_and_pwd)){
                        $temp_uuid = $collect_uuid_and_pwd_1["uuid"];
                        $temp_pwd = $collect_uuid_and_pwd_1["pwd"];
                        if(password_verify($pwd,$temp_pwd)){
                            $_SESSION["UUID"] = $temp_uuid;
                            ?>
                                <meta http-equiv="refresh" content="0; url=index.php">
                            <?php
                        }
                }
                while($count_logins_1 = mysqli_fetch_assoc($count_logins)){
            }else{
                echo "<span class='red_box'>Login or passwords is incorrect</span>"
            }
        }
    } 
?>
</form>