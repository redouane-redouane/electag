function get_trackers(){
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/get_trackers_table.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // get the trackers table in the configs
            let table = document.getElementById("trackers_table");
                    
            // delete trackers in the table to update the trackers list
            if(table != null){
                let trackerRows = table.childNodes;
                for (let i = trackerRows.length - 1; i > 1 ; i--) {
                    trackerRows[i].remove();
                }
            }

            // add each tracker in a different line in the table
            if(this.responseText != ""){
                const trackers = this.responseText.split(",");
                trackers.forEach(tracker => {
                    tracker_info = tracker.split("/");
                    row = document.createElement("tr");
    
                    column = document.createElement("td");
                    column.innerHTML = tracker_info[0];
                    row.appendChild(column);
    
                    column = document.createElement("td");
                    column.innerHTML = tracker_info[1];
                    row.appendChild(column);

                    column = document.createElement("td");
                    column.innerHTML = tracker_info[2];
                    row.appendChild(column);

                    column = document.createElement("td");
                    column.innerHTML = tracker_info[3];
                    row.appendChild(column);

                    column = document.createElement("td");
                    column.innerHTML = tracker_info[4];
                    row.appendChild(column);

                    column = document.createElement("td");
                    column.innerHTML = tracker_info[5];
                    row.appendChild(column);

                    column = document.createElement("td");
                    column.innerHTML = tracker_info[6];
                    row.appendChild(column);

                    column = document.createElement("td");
                    tracker_edit_button = document.createElement("button");
                    tracker_edit_button.innerHTML = "edit this tracker";
                    tracker_edit_button.setAttribute('value', tracker_info[0]);
                    tracker_edit_button.onclick = function(event){
                        fill_configuration_form(event.target.value);
                    }
                    column.appendChild(tracker_edit_button);
                    row.appendChild(column);

                    column = document.createElement("td");
                    tracker_delete_button = document.createElement("button");
                    tracker_delete_button.innerHTML = "delete this tracker";
                    tracker_delete_button.setAttribute('value', tracker_info[0]);
                    tracker_delete_button.onclick = function(event){
                        delete_tracker(event.target.value);
                        get_trackers();
                    }
                    column.appendChild(tracker_delete_button);
                    row.appendChild(column);

                    table.appendChild(row);
                });
            }
            else{
                row = document.createElement("tr");

                column = document.createElement("td");
                column.innerHTML = "No";
                row.appendChild(column);

                column = document.createElement("td");
                column.innerHTML = "trackers";

                column = document.createElement("td");
                column.innerHTML = "for";
                
                column = document.createElement("td");
                column.innerHTML = "this";

                column = document.createElement("td");
                column.innerHTML = "user";

                row.appendChild(column);
                table.appendChild(row);
            }
        }
    }
    xhttp.send();
}

// This function fills the configuration form after choosing a device from the table
// in the config page
function fill_configuration_form(serial_number){
    trackers.forEach(tracker => {
        if(tracker.serial_number == serial_number){
            // Dispositif configuration
            document.getElementById("serial_number").innerHTML = tracker.serial_number;
            document.getElementById("apn").innerHTML = tracker.apn;
            document.getElementById("ccid").innerHTML = tracker.ccid;
            document.getElementById("phone_number").value = tracker.phone_number;
            document.getElementById("pin_code").value = tracker.pin_code;
            document.getElementById("imsi").innerHTML = tracker.imsi;
            document.getElementById("operator").innerHTML = tracker.operator;
            document.getElementById("device").innerHTML = tracker.device;
            document.getElementById("firmware").innerHTML = tracker.firmware;
            document.getElementById("bootloader").innerHTML = tracker.bootloader;
            
            // Général configuration
            let select = document.getElementById("select_time_zone");
            for(var i = 0; i < select.options.length; i++){
                if(select.options[i].value == tracker.time_zone ){
                    select.options[i].selected = true;
                    break;
                }
            }
            
            document.getElementById("check_battery_20").checked = (tracker.low_battery == "1");
            document.getElementById("check_battery_10").checked = (tracker.empty_battery == "1");

            document.getElementById("battery_threshold").value = tracker.battery_threshold;
            
            let modes = document.getElementsByName("mode");
            switch (tracker.mode){
                case "0":
                    modes[0].checked = true;
                    select = document.getElementById("select_hours");
                    for(var i = 0;i < select.options.length;i++){
                        if(select.options[i].value == tracker.sleeping_hours ){
                            select.options[i].selected = true;
                            break;
                        }
                    }
                    
                    select = document.getElementById("select_minutes");
                    for(var i = 0;i < select.options.length;i++){
                        if(select.options[i].value == tracker.sleeping_minutes ){
                            select.options[i].selected = true;
                            break;
                        }
                    }
                    
                    select = document.getElementById("select_seconds");
                    for(var i = 0;i < select.options.length;i++){
                        if(select.options[i].value == tracker.activation_delay){
                            select.options[i].selected = true;
                            break;
                        }
                    }

                    document.getElementById("gsm_permanent").checked = (tracker.gsm_active == "1");
                    break;
                case "1":
                    modes[1].checked = true;
                    break;
                case "2":
                    modes[2].checked = true;
                    break;
                default:
                    break;
            }
            
            // Tracking configuration
            document.getElementById("frequency").value = tracker.frequency;
            document.getElementById("wait").value = tracker.wait;
            
            document.getElementById("threshold").value = tracker.threshold;
            
            document.getElementById("stop").value = tracker.stop;
            document.getElementById("alert").checked = (tracker.alert_mvt == "1");

            // Zone configuration
            // Destroy map if already initialized
            if(zone_map != null){
                zone_map.remove();
            }
            zone_map = L.map('zone_map').setView([35.204449, -0.630484], 10);

            L.tileLayer('https://b.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1
            }).addTo(zone_map);
        
            var drawnItems = new L.FeatureGroup();
            zone_map.addLayer(drawnItems);
            var drawControl = new L.Control.Draw({
                edit: {
                    featureGroup: drawnItems
                }
            });
            zone_map.addControl(drawControl);
        
            zone_map.on(L.Draw.Event.CREATED, function (e) {
                var type = e.layerType,
                    layer = e.layer;
                if (type === 'marker') {
                    // Do marker specific actions
                }else if (type === 'polygon') {
                    request = "" + serial_number;
                    // request += "," + document.getElementById("zone_name").innerHTML;

                    var latlngs = layer.getLatLngs().toString()
                                                    .replace(/[atLng() ]/g, '')
                                                    .split(",");
                    
                    for (let index = 0; index < latlngs.length; index++) {
                        i = index + 1;
                        request += "," + latlngs[index];
                    }

                    document.getElementById("zone_form").style.display='block';
                    document.getElementById("zone_form_confirm").setAttribute("onclick","insert_zone(" + request + ");");
                }
                drawnItems.addLayer(layer);
            });

            

            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "db/get_zones.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // get the zones table in the configs
                    let table = document.getElementById("zones_table");
                    
                    // delete zones in the table to update the zones list
                    let zoneRows = table.childNodes;
                    for (let i = zoneRows.length - 1; i > 1 ; i--) {
                            zoneRows[i].remove();
                    }

                    // add each zone in a different line in the table
                    if(this.responseText != ""){
                        const zones = this.responseText.split(",");
                        zones.forEach(zone => {
                            zone_info = zone.split("/");
                            row = document.createElement("tr");
            
                            column = document.createElement("td");
                            column.innerHTML = zone_info[0];
                            row.appendChild(column);
            
                            column = document.createElement("td");
                            column.innerHTML = zone_info[1];
                            row.appendChild(column);
            
                            column = document.createElement("td");
                            column.innerHTML = zone_info[2];
                            row.appendChild(column);
            
                            column = document.createElement("td");
                            column.innerHTML = zone_info[3];
                            row.appendChild(column);

                            column = document.createElement("td");
                            zone_delete_button = document.createElement("button");
                            zone_delete_button.innerHTML = "delete this zone";
                            zone_delete_button.value = zone_info[0];
                            zone_delete_button.onclick = function(event){
                                delete_zone(event.target.value);
                                fill_configuration_form(serial_number);
                            }
                            column.appendChild(zone_delete_button);
                            row.appendChild(column);

                            var latlngs = [
                                            [zone_info[5], zone_info[6]],
                                            [zone_info[7], zone_info[8]],
                                            [zone_info[9], zone_info[10]],
                                            [zone_info[11], zone_info[12]]
                                        ];                     
                            L.polygon(latlngs, {color: 'red'}).bindPopup(zone_info[1]).addTo(zone_map);
                            table.appendChild(row);
                        });
                    }
                    else{
                        row = document.createElement("tr");
            
                        column = document.createElement("td");
                        column.innerHTML = "There";
                        row.appendChild(column);
        
                        column = document.createElement("td");
                        column.innerHTML = "are";
                        row.appendChild(column);
        
                        column = document.createElement("td");
                        column.innerHTML = "no";
                        row.appendChild(column);
        
                        column = document.createElement("td");
                        column.innerHTML = "zones";
                        row.appendChild(column);
                        table.appendChild(row);
                    }
                }
            }
            xhttp.send("serial_number=" + serial_number);
        }
    });
    // Necessary to display the map in the zone tab of the configuration form in config page
    window.dispatchEvent(new Event('resize'));
    document.getElementById('config_form').style.display='block';
}

function delete_tracker(serial_number){
	    var xhttp = new XMLHttpRequest();
	    xhttp.open("POST", "db/delete_device.php", true);
	    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    xhttp.onreadystatechange = function() {
		    if (this.readyState == 4 && this.status == 200) {
                load_trackers();
                get_trackers();
			}
		}
	    xhttp.send("serial_number=" + serial_number);
}

function edit_tracker(){
    // Dispositif configuration
    let serial_number = document.getElementById("serial_number").innerHTML;
    let phone_number = document.getElementById("phone_number").value;
    let pin_code = document.getElementById("pin_code").value;
    
    // Général configuration
    let time_zone = document.getElementById("select_time_zone").value;   
    let battery_20 = document.getElementById("check_battery_20").checked;
    let battery_10 = document.getElementById("check_battery_10").checked;
    let battery_threshold = document.getElementById("battery_threshold").value;
    
    let request = "serial_number=" + serial_number + "&phone_number=" + phone_number 
                + "&pin_code=" + pin_code + "&time_zone=" + time_zone 
                + "&battery_20=" + battery_20 + "&battery_10=" + battery_10 
                + "&battery_threshold=" + battery_threshold;

    let modes = document.getElementsByName("mode");
    let mode = 0;
    if (modes[0].checked){
        let sleeping_hours = document.getElementById("select_hours").value;
        let sleeping_minutes = document.getElementById("select_minutes").value;
        let activation_delay = document.getElementById("select_seconds").value;
        let gsm_permanent = document.getElementById("gsm_permanent").checked;

        request += "&sleeping_hours=" + sleeping_hours + "&sleeping_minutes=" + sleeping_minutes
                    + "&activation_delay=" + activation_delay + "&gsm_permanent=" + gsm_permanent;
    }else if(modes[1].checked){
        mode = 1;

    }else if(modes[2].checked){
        mode = 2;
    }
    
    // Tracking configuration
    let frequency = document.getElementById("frequency").value;
    let wait = document.getElementById("wait").value;
    let threshold = document.getElementById("threshold").value;
    let stop = document.getElementById("stop").value;
    let alert = document.getElementById("alert").checked;

    request += "&mode=" + mode + "&frequency=" + frequency + "&wait=" + wait
                + "&threshold=" + threshold + "&stop=" + stop + "&alert=" + alert; 

    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/edit_tracker.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
	        load_trackers();
            get_trackers();
        }
    }
    xhttp.send(request);
}

function insert_configuration(){
    phone_num = document.getElementById("phone_num").value;
    pin_code = document.getElementById("pin_code").value;
    document.getElementById("phone_num").value = "";
    document.getElementById("pin_code").value = "";
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            response = this.responseXML;
        }
    };
    xmlhttp.open("GET", "db/insert_config.php?type=dis&sn=" + serial_number + "&phone=" + phone_num + "&pin=" + pin_code, true);
    xmlhttp.send();
}

function insert_config_general(){
    let time_zone = document.getElementById("select_time_zone").options;
    timez = time_zone[time_zone.selectedIndex].text;
    if(timez[0] == '+'){
       timez = '%2B' + timez.slice(1,2);
    }

    low_battery = document.getElementById("check_battery_20").checked;
    empty_battery = document.getElementById("check_battery_10").checked;
    battery_threshold = document.getElementById("battery_threshold").value;
    let modes = document.getElementsByName("mode");
    for (let i = 0; i < modes.length; i++) {
        if (modes[i].checked) {
            mode = i;
            break;
        }
    }
    link = "db/insert_config.php?type=gen&sn=" + serial_number + "&time_zone=" + timez + "&low_battery=" + low_battery + "&empty_battery=" + empty_battery + "&battery_threshold=" + battery_threshold + "&mode=" + mode;
    
    if(mode == 0){
        sleeping_hours = document.getElementById("select_hours").value;
        sleeping_minutes = document.getElementById("select_minutes").value;
        activation_delay = document.getElementById("select_seconds").value;
        gsm_permanent = document.getElementById("gsm_permanent").checked;
        link += "&hours=" + sleeping_hours + "&minutes=" + sleeping_minutes + "&seconds=" + activation_delay + "&gsm_active=" + gsm_permanent;
    }
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            response = this.responseXML;
        }
    };
    xmlhttp.open("GET", "db/insert_config.php?type=gen&sn=868926035393161&time_zone=-11&low_battery=true&empty_battery=false&battery_threshold=15&mode=2", true);
    xmlhttp.send();
}

function insert_config_tracking(){
    let frequency_opt = document.getElementById("frequency").options;
    frequency = frequency_opt[frequency_opt.selectedIndex].text;

    let wait_opt = document.getElementById("wait").options;
    wait = wait_opt[wait_opt.selectedIndex].text;

    threshold = document.getElementById("threshold").value;

    let stop_opt = document.getElementById("stop").options;
    stop = stop_opt[stop_opt.selectedIndex].text;

    alert_mvt = document.getElementById("alert").checked;
    alert("db/insert_config.php?type=gps&sn=" + serial_number + "&frequency=" + frequency + 
        "&wait=" + wait + "&threshold=" + threshold + "&stop=" + stop + "&alert=" + alert_mvt);
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            response = this.responseXML;
        }
    };
    
    xmlhttp.open("GET", "db/insert_config.php?type=gps&sn=" + tracker.serial_number 
                + "&frequency=" + tracker.gps_frequency + "&wait=" + tracker.gps_waiting_time + "&threshold=" 
                + tracker.detection_threshold + "&stop=" + tracker.halt_alert + "&alert=" 
                + tracker.movement_alert, true);
    xmlhttp.send();
}
