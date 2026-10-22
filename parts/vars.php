<?php
$links = array();

if(isset($_SESSION['UUID'])){
    $uuid_logged = mysqli_real_escape_string($connect, $_SESSION['UUID']);
    $check_user = mysqli_query($connect, "SELECT `uuid_user` FROM `users` WHERE `UUID`='$uuid_logged' LIMIT 1") or die(mysqli_error($connect));

    if(mysqli_num_rows($check_user) == 1){
        $check_user_1 = mysqli_fetch_assoc($check_user);
        $uuid_user = mysqli_real_escape_string($connect, $check_user_1['uuid_user']);

        $top_links = mysqli_query($connect, "SELECT links.`link`, links.`label` FROM `links` INNER JOIN `top10` ON links.`UUID` = top10.`UUID_general_link` WHERE links.`uuid_user` = '$uuid_user'") or die(mysqli_error($connect));
        while($top_links_1 = mysqli_fetch_assoc($top_links)){
            $links[$top_links_1['label']] = $top_links_1['link'];
        }
    }else{
        unset($_SESSION['UUID']);
    }
}
?>
