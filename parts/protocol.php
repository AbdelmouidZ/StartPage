<?php
if(isset($_GET[0])){
    $all_getties = $_GET[0];
    $decrypted_getties = decrypt($all_getties, $decrypt_password);

    if($decrypted_getties !== false){
        $getties_array = explode("&", $decrypted_getties);

        foreach($getties_array as $pair){
            $key_value = explode("=", $pair, 2);

            if(count($key_value) == 2){
                $getties[$key_value[0]] = $key_value[1];
            }
        }
    }
}

if(isset($_SESSION['UUID'])){
    if(isset($getties['protocol'])){
        $protocol = $getties['protocol'];
    }else{
        $protocol = "page.start";
    }
}else{
    if(isset($getties['protocol'])){
        $protocol = "auth.register";
    }else{
        $protocol = "auth.login";
    }
}
?>
