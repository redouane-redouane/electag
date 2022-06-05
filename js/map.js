function loadmap(){
    map = L.map('map').setView([35.204449, -0.630484], 10);

    L.tileLayer('https://b.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
    }).addTo(map);
    
    if(selected_tracker != null){
		selected_tracker.targets.forEach(target => {
			target.addTo(map);
		})
    }

    get_data();
    window.setInterval(get_data, 10000);
}

function select_tracker(selected_serial_number){
    if(selected_tracker != null && selected_tracker.targets != null){
        selected_tracker.targets.forEach(target => {
            if(map != null && map.hasLayer(target)){
                map.removeLayer(target);
            }
        });

        while(selected_tracker.targets.length > 0 ){
            selected_tracker.targets.pop();
        }

		selected_tracker.marker.setIcon(blueIcon);
    }

    if(selected_tracker != null && selected_tracker.zones != null){    
		while(selected_tracker.zones.length > 0){
			zone = selected_tracker.zones.pop();
			if(map != null && map.hasLayer(zone)){
				map.removeLayer(zone);
			}
		}
    }

    if (map == null) {
        return;
    } else {
        trackers.forEach(tracker => {
            if(tracker.serial_number == selected_serial_number){
                const options = {
                    method: 'POST',
                    body: JSON.stringify({trackerid: tracker.trackerid}),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }
                let res = fetch('/opa/db/get_selected_targets.php', options)
                            .then((res) => res.json())
                            .then(response => {
                                response.forEach(target => {
                                    circle_marker = L.circleMarker([target[10],target[11]], {
                                                        radius: 6,
                                                        fillColor: "#ff0000",
                                                        color: "#000000",
                                                        weight: 1,
                                                        opacity: 1,
                                                        fillOpacity: 1
                                                    }).addTo(map)
                                        	    	.bindPopup("<b>Trackername: </b>" + tracker.trackername + "<br />"
						    								+ "<b>Serial number: </b>" + tracker.serial_number + "<br />"
                                                    		+ "<b>Sime: </b>" + target[0] + "<br />" 
                                                            + "<b>Action: </b>" + target[2] + "<br />" 
                                                            + "<b>Zone: </b>" + target[9] + "<br />"
															+ "<b>Source: </b>" + target[5]
                                                    );
                                    tracker.targets.push(circle_marker);
                                });

                                selected_tracker = tracker; 

								tracker.display_zones();
								selected_tracker.marker.setIcon(greenIcon);

								if(selected_tracker.current_position != null)
									map.setView([selected_tracker.current_position.lat, selected_tracker.current_position.lng], 16);

								btn = document.getElementById("select_tracker_btn");
								btn.innerHTML = selected_tracker.trackername + '/' + selected_serial_number + 
													'<svg width="10" height="6" viewBox="0 0 10 6" fill="none"> \
														<path d="M1 1L5 5L9 1" stroke="#fff" data-v-4704f900=""></path> \
													</svg>';
                            })
                            .catch(error => console.log(error));
            }
        });       
    }
}

function get_data(){
    if (trackers.length == 0) {
        return;
    } else {
        data = [];
        trackers.forEach(tracker => {
            data.push(tracker.trackerid);
        });
        const options = {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json'
            }
        }
        let res = fetch('/opa/db/get_targets.php', options)
                    .then((res) => res.json())
                    .then(response => {
                        response.forEach(target => {
                            trackers.forEach(tracker => {
                                if(target[1] == tracker.trackerid){
								    if(tracker.current_position == null || (tracker.current_position != null && Date.parse(target[3]) > Date.parse(tracker.current_position.reception))){
								    	if(selected_tracker != null && selected_tracker.trackerid == tracker.trackerid){
											circle_marker = L.circleMarker([target[12],target[13]], {
																radius: 6,
																fillColor: "#ff0000",
																color: "#000000",
																weight: 1,
																opacity: 1,
																fillOpacity: 1
															}).addTo(map)
															.bindPopup("<b>Trackername: </b>" + selected_tracker.trackername + "<br />"
																		+ "<b>Serial number: </b>" + selected_tracker.serial_number + "<br />"
																		+ "<b>Time: </b>" + target[0] + "<br />" 
																		+ "<b>Action: </b>" + target[2] + "<br />"
																		+ "<b>Zone: </b>" + target[9] + "<br />"
																		+ "<b>Source: </b>" + target[7]
															);
											tracker.targets.push(circle_marker);

											table = document.getElementById("targets_table");
											
											if(table != null){
												let tr = document.createElement("tr");
												tr.setAttribute("class","target");
												table.firstElementChild.after(tr);
												for (let index = 2; index < 14; index++) {
													let td = document.createElement("td");
													td.innerHTML = target[index];
													tr.appendChild(td);
												}
											}

											if(selected_tracker.current_position != null)
												map.setView([selected_tracker.current_position.lat, selected_tracker.current_position.lng]);
                                		}

                                    	tracker.current_position = new Target(
                                                                    target[0],target[1],target[2],
                                                                    target[3],target[4],target[5],
                                                                    target[6],target[7],target[8],
                                                                    target[9],target[10],target[11],
                                                                    target[12],target[13]
                                                                );
                 		    			if(target[15] == "1"){
				    						Toastify({
												text: target[2] + " " + tracker.trackername + " is now outside of: " + target[11],
						      					duration: -1,
												destination: "",
												newWindow: true,
												close: true,
												gravity: "top", // `top` or `bottom`
												position: "right", // `left`, `center` or `right`
												stopOnFocus: true, // Prevents dismissing of toast on hover
												style: {
														background: "#ff0000",
													},
												offset: {
													x: 0, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
													y: '10em' // vertical axis - can be a number or a string indicating unity. eg: '2em'
												},
						      					onClick: function(){} // Callback after click
				    						}).showToast();
				    					} else{
											if(target[14] == "1"){
				    							Toastify({
													text: target[2] + " " + tracker.trackername + " is now inside: " + target[11],
													duration: -1,
													destination: "",
													newWindow: true,
													close: true,
													gravity: "top", // `top` or `bottom`
													position: "right", // `left`, `center` or `right`
													stopOnFocus: true, // Prevents dismissing of toast on hover
													style: {
														background: "#00ff00",
													},
													offset: {
														x: 0, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
														y: '10em' // vertical axis - can be a number or a string indicating unity. eg: '2em'
													},
													onClick: function(){} // Callback after click
												}).showToast();
											}
										}
				    				}

                                    tracker.update_current_position(target[2]);
								}
                            });
                        });
						if(selected_tracker != null)
							selected_tracker.display_zones();
                    })
                    .catch(error => console.log(error));
    }
}

function load_trackers(){
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "db/get_trackers_list.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			while(trackers.length > 0) {
				    trackers.pop();
			}
			// get the trackers dropdown menu
	        let table = document.getElementById("trackers_menu");
				                        
			// delete trackers in the table to update the trackers list
			let trackerRows = table.childNodes;
			for (let i = trackerRows.length - 1; i > 1 ; i--) {
				trackerRows[i].remove();
			}

		    // add each tracker in a different line in the table
			if(this.responseText != ""){
				folder_div = document.createElement("div");
				folder_div.className = "sub-dropdown";
				// separate folders
				const folders = this.responseText.split(";");
				folders.forEach(folder => {
					folder_info = folder.split(":");
					// get foldername
					foldername = folder_info[0];
												
					folder_a = document.createElement("a");
					folder_a.innerHTML = foldername + ">>";
					folder_div.appendChild(folder_a);

					trackers_div = document.createElement("div");
					trackers_div.className = "sub-dropdown-content";
					folder_div.appendChild(trackers_div);

					// get trackers
					trackers_string = folder_info[1];
					trackers_list = trackers_string.split(",");
					trackers_list.forEach(tracker => {
						tracker_info = tracker.split("/");
						trackers.unshift(new Tracker(tracker_info[0], tracker_info[1],
		                                			tracker_info[2], tracker_info[3],
	                	                			tracker_info[4], tracker_info[5],
	                                				tracker_info[6], tracker_info[7],
	                                				tracker_info[8], tracker_info[9],
	                                				tracker_info[10], tracker_info[11],
	                                				tracker_info[12], tracker_info[13],
	                                				tracker_info[14], tracker_info[15],
	                                				tracker_info[16], tracker_info[17],
	                                				tracker_info[18], tracker_info[19],
	                                				tracker_info[20], tracker_info[21],
	                                				tracker_info[22], tracker_info[23],
	                                				tracker_info[24], tracker_info[25],
	                                				tracker_info[26],
                                				)
										);
						tracker_a = document.createElement("a");
						tracker_a.value = tracker_info[2];
						tracker_a.innerHTML = tracker_info[3] + ' / ' + tracker_info[2];
						tracker_a.onclick = function(event){
							select_tracker(event.target.value);
						}
						trackers_div.appendChild(tracker_a);
                    });
                });
              	
				table.appendChild(folder_div);
    		} else{
				row = document.createElement("a");
				row.innerHTML = "No trackers";

				table.appendChild(row);
       		}
		}
 	}
	xhttp.send();    
}
