<?php
if(!isset($_SESSION['username'])){
    header("Location: http://105.96.109.54:8888/opa/index.php#home");
    exit();
}
?>
<div id="map"></div>