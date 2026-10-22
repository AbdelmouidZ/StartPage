<?php
$getties = array();
if(!empty($_SERVER['QUERY_STRING'])){
    $all_getties = urldecode($_SERVER['QUERY_STRING']);
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

$logged_protocols = array("page.start", "page.edit");

if(isset($_SESSION['UUID'])){
    if(isset($getties['protocol']) && in_array($getties['protocol'], $logged_protocols)){
        $protocol = $getties['protocol'];
    }else{
        $protocol = "page.start";
    }
}else{
    if(isset($getties['protocol']) && $getties['protocol'] == "auth.register"){
        $protocol = "auth.register";
    }else{
        $protocol = "auth.login";
    }
}
?>
