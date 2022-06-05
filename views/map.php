<?php
    if(!isset($_SESSION['username'])){
        header("Location: ../opa/index.php#home");
        exit();
    }
?>
<div id="map"></div>