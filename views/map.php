<?php
if(!isset($_SESSION['username'])){
    header("Location: ../index.php#home");
    exit();
}
?>
<div id="map"></div>