function insert_zone(serial_number, lat1, lng1, lat2, lng2, lat3, lng3, lat4, lng4){
    zone_name = document.getElementById("zonename").value;
    document.getElementById("zonename").value = "";
    
    start_time = document.getElementById("start_time").value;
    document.getElementById("start_time").value = "";
    
    end_time = document.getElementById("end_time").value; 
    document.getElementById("end_time").value = "";
    
    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/insert_zone.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("zone_form").style.display='none';
            fill_configuration_form(serial_number);
        }
    }
    xhttp.send("serial_number=" + serial_number + "&zonename=" + zone_name 
        + "&lat1=" + lat1 + "&lng1=" + lng1 + "&lat2=" + lat2 + "&lng2=" + lng2 
        + "&lat3=" + lat3 + "&lng3=" + lng3 + "&lat4=" + lat4 + "&lng4=" + lng4
        + "&start=" + start_time + "&end=" + end_time);
}

function delete_zone(zone_id){
    serial_number = document.getElementById("serial_number").innerHTML;
    
    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/delete_zone.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("zoneid=" + zone_id + "&serial_number=" + serial_number);
}