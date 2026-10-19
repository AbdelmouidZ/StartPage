
<form method="POST">
    <input type="text" name="login" placeholder="Please enter your login" required>
    <input type="password" name="pwd" placeholder="Please enter your password" required>
    <input type="submit" name="go" value="Login">
    <a href="index.php?<?php echo encrypt("auth.register", $decrypt_password); ?>">Register</a>

<?php
if(isset($_POST["go"])){
    $login = $_POST["login"];
    $pwd = $_POST["pwd"];

    $login = mysqli_real_escape_string($connect, $login);

    $count_logins = mysqli_query($connect, "SELECT `UUID`, `pwd` FROM `users` WHERE `login`='$login' LIMIT 1") or die(mysqli_error($connect));

    if(mysqli_num_rows($count_logins) == 1){
        while($count_logins_1 = mysqli_fetch_assoc($count_logins)){
            $temp_uuid = $count_logins_1["UUID"];
            $temp_pwd = $count_logins_1["pwd"];

            if(password_verify($pwd, $temp_pwd)){
                session_regenerate_id(true);
                $_SESSION["UUID"] = $temp_uuid;
                ?>
                    <meta http-equiv="refresh" content="0; url=index.php">
                <?php
            }else{
                echo "<span class='red_box'>Login or password is incorrect</span>";
            }
        }
    }else{
        echo "<span class='red_box'>Login or password is incorrect</span>";
    }
}
?>
</form>