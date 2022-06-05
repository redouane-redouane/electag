<?php
    if(!isset($_SESSION['username'])){
        header("Location: ../opa/index.php#home");
        exit();
    }
?>
<input type="text" class="filterSearch" id="logsList" onkeyup="filterSearch('logsList','logs_table','tr')" placeholder="Search logs...">
<table id="logs_table">
    <tr>
        <th>IP Address</th>
        <th>User</th>
        <th>Date</th>
        <th>Action</th>
    </tr>
    <?php
        require '../db/get_logs.php'
    ?>
</table>