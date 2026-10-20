<form method="POST">
    <input type="text" name="login" placeholder="Please enter your login" required>
    <input type="password" name="pwd" placeholder="Please enter your password" required>
    <input type="submit" name="go" value="Login">
    <a href="<?php echo make_link("protocol=auth.register", $decrypt_password); ?>">Register</a>

<?php
if(isset($_POST["go"])){
    $login = mysqli_real_escape_string($connect, trim($_POST["login"]));
    $pwd = $_POST["pwd"];

    $check_login = mysqli_query($connect, "SELECT `UUID`, `pwd` FROM `users` WHERE `login`='$login' LIMIT 1") or die(mysqli_error($connect));

    $logged = false;
    if(mysqli_num_rows($check_login) == 1){
        $check_login_1 = mysqli_fetch_assoc($check_login);
        if(password_verify($pwd, $check_login_1["pwd"])){
            session_regenerate_id(true);
            $_SESSION["UUID"] = $check_login_1["UUID"];
            $logged = true;
        }
    }

    if($logged){
        ?>
            <meta http-equiv="refresh" content="0; url=index.php">
        <?php
    }else{
        echo "<span class='red_box'>Login or password is incorrect</span>";
    }
}
?>
</form>
