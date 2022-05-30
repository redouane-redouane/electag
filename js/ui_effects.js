function collapse_navbar() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        // x.className += " responsive";
        x.className = "sidepanel";
    } else {
        x.className = "topnav";
    }
}

function collapse_side_navbar() {
    alert(document.getElementsByTagName("body")[0].style.width);
    var x = document.getElementById("myTopnav");
    if (x.style.width == "0px") {
        x.style.width = "250px";
    } else {
        x.style.width = "0px";
    }
}

function openTab(tabName, elmnt) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
  
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].style.backgroundColor = "";
    }

    document.getElementById(tabName).style.display = "block";
}

function filterSearch(inputId, contentId, filterTag) {
    console.log("entering filter");
    var input, filter, tag;
    // input = document.getElementById("trackerSearch");
    input = document.getElementById(inputId);
    filter = input.value.toUpperCase();
    // div = document.getElementById("trackerDropdown");
    div = document.getElementById(contentId);
    // a = div.getElementsByTagName("a");
    tag = div.getElementsByTagName(filterTag);
    
    // for tables i starts from 1 to always display table header row
    let i = 0;
    if(tag != "a")
        i = 1;

    for ( ; i < tag.length; i++) {
        txtValue = tag[i].textContent || tag[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tag[i].style.display = "";
        } else {
            tag[i].style.display = "none";
        }
    }
}

function filterSearchTrackers() {
    var input, filter, i;
    input = document.getElementById("trackerList");
    filter = input.value.toUpperCase();
    table = document.getElementById("trackers_table");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {
        txtValue = tr[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}

function filterSearchLogs() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("logsList");
    filter = input.value.toUpperCase();
    table = document.getElementById("logs_table");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {
        txtValue = tr[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}

function config_form(){
    // Get the modal
    var modal = document.getElementById('config_form');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}