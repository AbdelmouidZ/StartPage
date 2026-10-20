<form method="POST">
    <input type="text" name="login" placeholder="Please choose your login" required>
    <input type="password" name="pwd" placeholder="Please choose your password" required>
    <input type="password" name="confirm_pwd" placeholder="Please confirm your password" required>
    <input type="submit" name="go" value="Register">
    <a href="index.php">Login</a>

<?php
    if(isset($_POST["go"])){
        $login = trim($_POST["login"]);
        $pwd = $_POST["pwd"];
        $confirm_pwd = $_POST["confirm_pwd"];

        if($login == "" || $pwd == ""){
            echo "<span class='red_box'>Please fill in all fields</span>";
        }elseif($pwd != $confirm_pwd){
            echo "<span class='red_box'>Passwords do not match</span>";
        }else{
            $login = mysqli_real_escape_string($connect, $login);

            $check_login = mysqli_query($connect, "SELECT `id` FROM `users` WHERE `login`='$login' LIMIT 1") or die(mysqli_error($connect));

            if(mysqli_num_rows($check_login) == 0){
                $uuid = make_uuid();
                $uuid_user = make_uuid();
                $hashed_pwd = mysqli_real_escape_string($connect, password_hash($pwd, PASSWORD_DEFAULT));

                $register = mysqli_query($connect, "INSERT INTO `users` (`UUID`, `uuid_user`, `login`, `pwd`) VALUES ('$uuid', '$uuid_user', '$login', '$hashed_pwd')");

                if($register){
                    echo "<span>Registration successful. You can now log in.</span>";
                }else{
                    echo "<span class='red_box'>Registration failed</span>";
                }
            }else{
                echo "<span class='red_box'>This login already exists</span>";
            }
        }
    }
?>
</form>
