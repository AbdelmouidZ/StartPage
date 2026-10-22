
<?php
    foreach($links as $label => $link){
        ?>
            <a href="<?php echo $link; ?>"><?php echo htmlspecialchars($label, ENT_QUOTES, "UTF-8"); ?></a>
        <?php
    }
?>