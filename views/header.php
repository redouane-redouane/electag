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