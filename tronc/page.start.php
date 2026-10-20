<span class="right_button">
    <a href="<?php echo make_link("protocol=page.edit", $decrypt_password); ?>">Edit links</a>
</span>
<?php
    foreach($links as $label => $link){
        ?>
            <a href="<?php echo $link; ?>"><?php echo htmlspecialchars($label, ENT_QUOTES, "UTF-8"); ?></a>
        <?php
    }
?>