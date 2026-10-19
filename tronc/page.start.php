<?php
if(isset($links)){
    foreach($links as $label=>$link){
        ?>
            <a href="<?php echo $link; ?>"><?php echo $label; ?></a>
        <?php
    }
}
?>