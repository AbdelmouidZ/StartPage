<?php
if(isset($_SESSION['UUID'])){
    $test_uuid_logged = $_SESSION['UUID'];
    $check_if_uuid_exists = mysqli_query($connect, "SELECT COUNT(`id`) FROM `users` WHERE `uuid_user`='$test_uuid_logged'")or die(mysqli_error($connect));
    while($check_if_uuid_exists_1 = mysqli_fetch_assoc($check_if_uuid_exists)){
        $uuid_count = $check_if_uuid_exists_1[0];
        if($uuid_count == 1){
            $uuid_logged = $_SESSION['UUID']; 
            $top_links = mysqli_query($connect, "SELECT links.UUID AS general_link_uuid, top10.UUID AS top_10_link_uuid FROM links INNER JOIN top10 ON links.UUID = top10.UUID_general_link WHERE links.uuid_user = '$uuid_logged'")or die(mysqli_error($connect));
            while($top_links_1 = mysqli_fetch_assoc($top_links)){
                foreach($top_links_1 as $top_link){
                    $general_UUID_result[] = $top_link;
                    $links_request = mysqli_query($connect, "SELECT `link`, `label` FROM `links` WHERE `UUID` = '$top_link'") or die(mysqli_error($connect));
                    while($links_request_1 = mysqli_fetch_assoc($links_request)){
                        foreach($links_request_1 as $key => $value){
                            $links[$links_request_1['label']] = $links_request_1['link'];
                        }
                    }
                }
            }
        }
    }
}
?>