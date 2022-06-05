<?php
    if(isset($_SESSION['username'])){
        header("Location: ../opa/index.php#home");
        exit();
    }
?>
<button class="form_button" onclick="exportCSV();">Export this table to CSV file</button>
<table id="targets_table">
    <tr>
        <th>Acquisition</th>
        <th>Reception</th>
        <th>Action</th>
        <th>Precision</th>
        <th>Speed</th>
        <th>Geotype</th>
        <th>CBattery</th>
        <th>Status</th>
        <th>CSQ</th>
        <th>Zone</th>
        <th>Lat</th>
        <th>Lon</th>
    </tr>
</table>
