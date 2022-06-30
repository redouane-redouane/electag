<?php
if(!isset($_SESSION['username'])){
    header("Location: ../index.php#home");
    exit();
} else{
    echo '<div id="map"></div>';
}
?>