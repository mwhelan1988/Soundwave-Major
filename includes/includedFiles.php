<?php

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
    include("includes/conn.php");
    include("includes/classes/Artist.php");
    include("includes/classes/Album.php");
    include("includes/classes/Song.php");

} else {
    include("includes/members-area-header.php");
    include("includes/members-area-footer.php");


$url = $_SERVER['REQUEST_URI'];
    echo "<script>openPage('$url')</script>";
exit();
}
?>