
<form method="POST">
    <input type="text" name="login" placeholder="Choose your login" required>
    <input type="password" name="pwd" placeholder="Choose your password" required>
    <input type="password" name="confirm_pwd" placeholder="Confirm your password" required>
    <input type="submit" name="go" value="Register">

<?php
if(isset($_POST["go"])){
    $login = trim($_POST["login"]);
    $pwd = $_POST["pwd"];
    $confirm_pwd = $_POST["confirm_pwd"];

    if($login == "" || $pwd == ""){
        echo "<span class='red_box'>Please fill in all fields</span>";
    }else{
        if($pwd != $confirm_pwd){
            echo "<span class='red_box'>Passwords do not match</span>";
        }else{
            if(strlen($pwd) < 12){
                echo "<span class='red_box'>Password must have at least 12 characters</span>";
            }else{
                $login = mysqli_real_escape_string($connect, $login);

                $check_login = mysqli_query($connect, "SELECT `id` FROM `users` WHERE `login`='$login' LIMIT 1") or die(mysqli_error($connect));

                if(mysqli_num_rows($check_login) == 0){
                    $uuid = bin2hex(random_bytes(16));
                    $hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);

                    $register = mysqli_query($connect, "INSERT INTO `users` (`UUID`, `login`, `pwd`) VALUES ('$uuid', '$login', '$hashed_pwd')");

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
    }
}
?>
</form>
