<?php
if(isset($_SESSION['username'])){
    header("Location: #home");
    exit();
}
?>
<div id="map"></div>