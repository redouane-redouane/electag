<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>electag</title>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/tabs.css">
    <link rel="stylesheet" href="css/filtersearch.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/dropdown.css">
    <link rel="stylesheet" href="css/responsive.css">

    <!--Leaflet import-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" 
        integrity="sha512-gc3xjCmIy673V6MyOAZhIW93xhM9ei1I+gLbmFjUHIjocENRsLX/QUE1htk5q1XV2D/iie/VQ8DXI6Vu8bexvQ==" 
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js" 
        integrity="sha512-ozq8xQKq6urvuU6jNgkfqAmT7jKN2XumbrX1JiB3TnF7tI48DPI4Gy1GXKD/V3EExgAs1V+pRO7vwtS1LHg0Gw==" 
	crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    
    <script src="js/ui_effects.js"></script>
    <script src="js/global.js"></script>
    <script src="js/map.js"></script>
    <script src="js/zone.js"></script>
    <script src="js/table.js"></script>
    <script src="js/electag.js"></script>
    <script src="js/config.js"></script>
    <script src="js/admin.js"></script>
</head>
<body>
    <?php
    if(isset($_SESSION['username'])){
        echo '
        <div class="topnav" id="myTopnav">
            <a id="close_navbar" href="javascript:void(0)" class="closebtn" onclick="collapse_side_navbar();">&times;</a>
            <div id="trackerDropdown" class="dropdown">
                <button id="select_tracker_btn" class="dropbtn">
                    Select tracker
                    <svg width="10" height="6" viewBox="0 0 10 6" fill="none">
                        <path d="M1 1L5 5L9 1" stroke="#fff" data-v-4704f900=""></path>
                    </svg>
                </button>
                <div id="trackers_menu" class="dropdown-content">
		            <input type="text" placeholder="Search.." id="trackerSearch" onkeyup="filterSearch(\'trackerSearch\',\'trackerDropdown\',\'a\');">
	                <script>
			            load_trackers();
		            </script>
                </div>
            </div>
            <div class="dropdown navlink-right">
                <button class="dropbtn">
                    Time Range
                    <svg width="10" height="6" viewBox="0 0 10 6" fill="none">
                        <path d="M1 1L5 5L9 1" stroke="#fff" data-v-4704f900=""></path>
                    </svg>
                </button>
                <div class="dropdown-content">
                    <a>Last hour</a>
                    <a>Last 24 hours</a>
                    <a>Last 7 days</a>
                    <a>All positions</a>
                </div>
            </div>
            <div class="dropdown navlink-right">
                <button class="dropbtn">
                    Refresh rate
                    <svg width="10" height="6" viewBox="0 0 10 6" fill="none">
                        <path d="M1 1L5 5L9 1" stroke="#fff" data-v-4704f900=""></path>
                    </svg>
                </button>
                <div class="dropdown-content">
                    <a>10 seconds</a>
                    <a>20 seconds</a>
                    <a>1 minute</a>
                    <a>5 minutes</a>
                </div>
            </div>

            <a href="#map">Map</a>
            <a href="#table">Table</a>
            <a href="#config">Config</a>
            <a href="#admin">Admin</a>
            <a href="#logs">Logs</a>

            <a href="db/logout.php" class="navlink-right">Logout</a>
            <a class="navlink-right">User: '.$_SESSION['username'].'</a>
        </div>
        <a class="openbtn" onclick="collapse_side_navbar()">
            <svg viewBox="0 0 100 80" width="40" height="15">
                <rect width="100" height="15" stroke="#fff" fill="#fff"></rect>
                <rect y="30" width="100" height="15" stroke="#fff" fill="#fff"></rect>
                <rect y="60" width="100" height="15" stroke="#fff" fill="#fff"></rect>
            </svg>
        </a> 
        ';
    } else{
        header("Location: ../index.php");
        exit();
    }
    ?>
    
    <div id="main">
        
    </div>
    <script src="js/routing.js"></script>
</body>
</html>
