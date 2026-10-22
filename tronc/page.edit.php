<h2>Manage links</h2>

<a href="<?php echo make_link("protocol=page.start", $decrypt_password); ?>" class="right_button">Back to start page</a>

<form method="POST">
    <h3>Add a link</h3>
    <input type="text" name="label" placeholder="Label" maxlength="150">
    <input type="url" name="link" placeholder="https://example.com">
    <input type="checkbox" name="start_page" value="1">Show on start page
    <input type="submit" name="go" value="Add link">
</form>

<?php
if(isset($_POST['go'])){
    $label = trim($_POST['label']);
    $url = trim($_POST['link']);

    if($label == "" || !filter_var($url, FILTER_VALIDATE_URL)){
        echo "<p>Please enter a valid label and URL.</p>";
    }else{
        $link_uuid = make_uuid();
        $safe_label = mysqli_real_escape_string($connect, $label);
        $safe_url = mysqli_real_escape_string($connect, $url);

        mysqli_query($connect, "INSERT INTO `links` (`UUID`, `uuid_user`, `label`, `link`) VALUES ('$link_uuid', '$uuid_user', '$safe_label', '$safe_url')") or die(mysqli_error($connect));

        if(isset($_POST['start_page'])){
            $favorite_uuid = make_uuid();
            mysqli_query($connect, "INSERT INTO `top10` (`UUID`, `UUID_general_link`) VALUES ('$favorite_uuid', '$link_uuid')") or die(mysqli_error($connect));
        }

        echo "<p>Link added.</p>";
    }
}

if(isset($_POST['delete'])){
    $link_uuid = mysqli_real_escape_string($connect, $_POST['delete']);

    mysqli_query($connect, "DELETE links, top10 FROM `links` LEFT JOIN `top10` ON top10.`UUID_general_link` = links.`UUID` WHERE links.`UUID`='$link_uuid' AND links.`uuid_user`='$uuid_user'") or die(mysqli_error($connect));

    echo "<p>Link deleted.</p>";
}
?>

<h3>Existing links</h3>

<form method="POST">
<?php
$get_links = mysqli_query($connect, "SELECT links.`UUID`, links.`label`, links.`link`, top10.`UUID` AS favorite_uuid FROM `links` LEFT JOIN `top10` ON links.`UUID` = top10.`UUID_general_link` WHERE links.`uuid_user`='$uuid_user' ORDER BY links.`label`") or die(mysqli_error($connect));

if(mysqli_num_rows($get_links) == 0){
    echo "<p>No links added yet.</p>";
}

while($get_links_1 = mysqli_fetch_assoc($get_links)){
    $item_uuid = htmlspecialchars($get_links_1['UUID'], ENT_QUOTES, "UTF-8");
    $item_label = htmlspecialchars($get_links_1['label'], ENT_QUOTES, "UTF-8");
    $item_link = htmlspecialchars($get_links_1['link'], ENT_QUOTES, "UTF-8");

    if($get_links_1['favorite_uuid'] != null){
        echo "★ ";
    }
    echo "$item_label ($item_link) ";
    echo "<button type=\"submit\" name=\"delete\" value=\"$item_uuid\" onclick=\"return confirm('Delete this link?');\">Delete</button><br>";
}
?>
</form>
