function fill_table(){
    table = document.getElementById("targets_table");
    if (table == null || selected_tracker == null) {
        return;
    } else {
        let targetRows = table.childNodes;
        for (let i = targetRows.length - 1; i > 1 ; i--) {
               targetRows[i].remove();
        }
        const options = {
            method: 'POST',
            body: JSON.stringify({trackerid: selected_tracker.trackerid}),
            headers: {
                'Content-Type': 'application/json'
            }
        }
        let res = fetch('/opa/db/get_selected_targets.php', options)
                    .then((res) => res.json())
                    .then(response => {
                        response.forEach(target => {
                            let tr = document.createElement("tr");
                            tr.setAttribute("class","target");
                            table.appendChild(tr);
                            target.forEach(attribute => {
                                let td = document.createElement("td");
                                td.innerHTML = attribute;
                                tr.appendChild(td);
                            });
                        });
                    })
                    .catch(error => console.log(error));
    }
}

function exportCSV(){
    let arrayHeader = ["SN","Lat","Lng","Time GMT","Battery %","Sig GSM","Sig GPS"];
    let header = arrayHeader.join(",") + '\n';
    let csv = header;
    var data = [];
    var table = document.getElementById("targets_table");
    var rows = table.querySelectorAll("tr");
				
    for (var i = 0; i < rows.length; i++) {
	var row = [], cols = rows[i].querySelectorAll("td, th");
							
	for (var j = 0; j < cols.length; j++) {
    	    row.push(cols[j].innerText);
        }
					        
	data.push(row.join(",")); 		
    }

    let csvData = new Blob([data.join("\n")], { type: 'text/csv' });  
    let csvUrl = URL.createObjectURL(csvData);

    let hiddenElement = document.createElement('a');
    hiddenElement.href = csvUrl;
    hiddenElement.target = '_blank';
    hiddenElement.download = "fileName" + '.csv';
    hiddenElement.click();
}
