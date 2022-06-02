class Zone {
    constructor(zoneid, zonename, trackerid, lat1, lng1,
                lat2, lng2, lat3, lng3, lat4, lng4, start_time, end_time) {
        
        this.zoneid = zoneid;
        this.zonename = zonename;
        this.trackerid = trackerid;
        this.lat1 = lat1;
        this.lng1 = lng1;
        this.lat2 = lat2;
        this.lng2 = lng2;
        this.lat3 = lat3;
        this.lng3 = lng3;
        this.lat4 = lat4;
        this.lng4 = lng4;
        this.start_time = start_time;
        this.end_time = end_time;
    }
}

class Target {
    constructor(targetid, tracker, aquisition, reception,
                action, accuracy, speed, geotype, cbattery,
                gps, csq, zone, lat, lng, zone_entry, zone_exit) {
        this.targetid = targetid;
        this.tracker = tracker;
        this.aquisition	= aquisition;
        this.reception = reception;
        this.action	= action;
        this.accuracy = accuracy;
        this.speed = speed;
        this.geotype = geotype;
        this.cbattery = cbattery;
        this.gps = gps;
        this.csq = csq;
        this.zone = zone;
        this.lat = lat;
        this.lng = lng;
	this.zone_entry = zone_entry;
	this.zone_exit = zone_exit;
    }
}

class Tracker {
    constructor(trackerid, foldername, serial_number, trackername,
                apn, ccid, phone_number, imsi, pin_code, operator,
                device, firmware, bootloader, time_zone,
                low_battery, empty_battery, battery_threshold, alert_mvt,
                mode, sleeping_hours, sleeping_minutes, activation_delay,
                gsm_active, frequency, wait, threshold, stop){
                  
        this.trackerid = trackerid;
        this.foldername = foldername;
        this.serial_number = serial_number;
        this.trackername = trackername;
        this.apn = apn;
        this.ccid = ccid;
        this.phone_number = phone_number;
        this.imsi = imsi;
        this.pin_code = pin_code;
        this.operator = operator;
        this.device = device;
        this.firmware = firmware;
        this.bootloader = bootloader;
        this.time_zone = time_zone;
        this.low_battery = low_battery;
        this.empty_battery = empty_battery;
        this.battery_threshold = battery_threshold;
        this.alert_mvt = alert_mvt;
        this.mode = mode;
        this.sleeping_hours = sleeping_hours;
        this.sleeping_minutes = sleeping_minutes;
        this.activation_delay = activation_delay;
        this.gsm_active = gsm_active;this.current_position.zone
        this.frequency = frequency;
        this.wait = wait;
        this.threshold = threshold;
        this.stop = stop;
        this.serial_number = serial_number;
        this.marker = L.marker();
        this.current_position;
        this.targets = new Array();
        this.zones = new Array();
    }

    update_current_position(time){
        if(map.hasLayer(this.marker)){
            map.removeLayer(this.marker)
        }
        this.marker.setLatLng([this.current_position.lat, this.current_position.lng])
                   .addTo(map)
                   .bindPopup("Trackername: " + this.trackername + "<br />" 
			   + "Serial number: " + this.serial_number + "<br />" 
			   + "Time: " + this.current_position.aquisition + "<br />" 
			   + "Action: " + this.current_position.action + "<br />" 
			   + "Zone: " + this.current_position.zone + "<br />"
               + "Source: " + this.current_position.geotype);
    }

    display_zones(){
    	let xhttp = new XMLHttpRequest();
        xhttp.open("POST", "db/get_zones.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.onreadystatechange = function() {
	        if (this.readyState == 4 && this.status == 200) {
			if(this.responseText != ""){
				if(selected_tracker != null && selected_tracker.zones != null){
				        while(selected_tracker.zones.length > 0){
				                let zone = selected_tracker.zones.pop();
				                if(map != null && map.hasLayer(zone)){
				                        map.removeLayer(zone);
				                }
				        }
				}

                        	const zones = this.responseText.split(",");
                        	zones.forEach(zone => {
                            		var zone_info = zone.split("/");

                            		var latlngs = [
                                            [zone_info[5], zone_info[6]],
                                            [zone_info[7], zone_info[8]],
                                            [zone_info[9], zone_info[10]],
                                            [zone_info[11], zone_info[12]]
                                        ];                     
                            		selected_tracker.zones.push(new L.polygon(latlngs, {color: 'red'}).bindPopup(zone_info[1]).addTo(map));
                            		
                        	});
                    	}
                }
        }
        xhttp.send("serial_number=" + this.serial_number);
    }
}

class SelectedTracker extends Tracker {
    constructor(trackerid, foldername, serial_number, trackername,
                apn, ccid, phone_number, imsi, pin_code, operator,
                device, firmware, bootloader, time_zone,
                low_battery, empty_battery, battery_threshold, alert_mvt,
                mode, sleeping_hours, sleeping_minutes, activation_delay,
                gsm_active, frequency, wait, threshold, stop){
        
        super(trackerid, foldername, serial_number, trackername,
            apn, ccid, phone_number, imsi, pin_code, operator,
            device, firmware, bootloader, time_zone, low_battery, 
            empty_battery, battery_threshold, alert_mvt, mode, 
            sleeping_hours, sleeping_minutes, activation_delay,
            gsm_active, frequency, wait, threshold, stop);        
    }
}
