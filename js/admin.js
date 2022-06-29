// This function gets all users from DB and displays them in the users tab in the admin page
function get_users(){
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/get_users.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // get the users table in the configs
            let table = document.getElementById("admin_users_table");
                    
            // delete users in the table to update the users list
            let userRows = table.childNodes;
            for (let i = userRows.length - 1; i > 1 ; i--) {
                    userRows[i].remove();
            }

            // add each user in a different line in the table
            if(this.responseText != ""){
                const users = this.responseText.split(",");
                users.forEach(user => {
                    user_info = user.split("/");
                    row = document.createElement("tr");
    
                    column = document.createElement("td");
                    column.innerHTML = user_info[0];
                    row.appendChild(column);
    
                    column = document.createElement("td");
                    column.innerHTML = user_info[1];
                    row.appendChild(column);
    
                    column = document.createElement("td");
                    column.innerHTML = user_info[2];
                    row.appendChild(column);
    
                    column = document.createElement("td");
                    column.innerHTML = user_info[3];
                    row.appendChild(column);

                    column = document.createElement("td");
                    column.innerHTML = user_info[4];
                    row.appendChild(column);

                    column = document.createElement("td");
                    user_edit_button = document.createElement("button");
                    user_edit_button.innerHTML = "edit this user";
                    user_edit_button.value = user_info[3]; 
                    user_edit_button.onclick = function(event){
                        fill_edit_user_form(event.target.value);
                    }
                    column.appendChild(user_edit_button);
                    row.appendChild(column);

                    column = document.createElement("td");
                    user_delete_button = document.createElement("button");
                    user_delete_button.innerHTML = "delete this user";
                    user_delete_button.value = user_info[3];
                    user_delete_button.onclick = function(event){
                        delete_user(event.target.value);
                        get_users();
                    }
                    column.appendChild(user_delete_button);
                    row.appendChild(column);

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
                column.innerHTML = "users";
                row.appendChild(column);
                table.appendChild(row);
            }
        }
    }
    xhttp.send();
}

// This function inserts a user in the DB after confirming the form in users tab in the admin page
function insert_user(firstname, lastname, email, username, group, password, password_confirm){
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/insert_user.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            get_users();
        }
    }
    xhttp.send("firstname=" + firstname + "&lastname=" + lastname + "&email=" + email + "&username=" + username + "&group=" + group + "&password=" + password + "&password_confirm=" + password_confirm);
}
// This function deletes a user from the DB after clicking delete a row in users tab in the admin page
function delete_user(username){
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/delete_user.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            get_users();
        }
    }
    xhttp.send("username=" + username);
}

function get_groups(){
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/get_groups.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // get the groups table in the configs
            let table = document.getElementById("admin_groups_table");
                    
            // delete groups in the table to update the groups list
            let groupRows = document.getElementsByClassName("groupRow");

            for (let i = groupRows.length - 1; i >= 0 ; i--) {
                groupRows[i].remove();
            }

            // add each group in a different line in the table
            if(this.responseText != ""){
                const groups = this.responseText.split(",");
                groups.forEach(group => {
                    row = document.createElement("tr");
                    row.className = "groupRow";

                    column = document.createElement("td");
                    column.innerHTML = group;
                    row.appendChild(column);

                    column = document.createElement("td");
                    group_edit_button = document.createElement("button");
                    group_edit_button.innerHTML = "edit this group";
                    group_edit_button.setAttribute("value", group);
                    group_edit_button.onclick = function(event){
                        fill_edit_group_form(event.target.value);
                    }
                    column.appendChild(group_edit_button);
                    row.appendChild(column);

                    column = document.createElement("td");
                    group_delete_button = document.createElement("button");
                    group_delete_button.innerHTML = "delete this group";
                    group_delete_button.setAttribute("value", group);
                    group_delete_button.onclick = function(event){
                        delete_group(event.target.value);
                    }
                    column.appendChild(group_delete_button);
                    row.appendChild(column);

                    table.appendChild(row);
                });
            }
            else{
                row = document.createElement("tr");
                row.className = "groupRow";
                
                column = document.createElement("td");
                column.innerHTML = "No";
                row.appendChild(column);

                column = document.createElement("td");
                column.innerHTML = "groups";
                row.appendChild(column);
                table.appendChild(row);
            }
        }
    }
    xhttp.send();
}

function insert_group(groupname){
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/insert_group.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            get_groups();
        }
    }
    xhttp.send("groupname=" + groupname);
}

function delete_group(groupname){
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/delete_group.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            get_groups();
        }
    }
    console.log("groupname=" + groupname);
    xhttp.send("groupname=" + groupname);
}

function get_folders(){
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/get_folders.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // get the folders table in the configs
            let table = document.getElementById("admin_folders_table");
                    
            // delete folders in the table to update the folders list
            let folderRows = table.childNodes;
            for (let i = folderRows.length - 1; i > 1 ; i--) {
                folderRows[i].remove();
            }

            // add each folder in a different line in the table
            if(this.responseText != ""){
                const folders = this.responseText.split(",");
                folders.forEach(folder => {
                    row = document.createElement("tr");
    
                    column = document.createElement("td");
                    column.innerHTML = folder;
                    row.appendChild(column);

                    column = document.createElement("td");
                    folder_edit_button = document.createElement("button");
                    folder_edit_button.innerHTML = "edit this folder";
                    folder_edit_button.setAttribute('value', folder);
                    folder_edit_button.onclick = function(event){
                        fill_edit_folder_form(event.target.value);
                    }
                    column.appendChild(folder_edit_button);
                    row.appendChild(column);

                    column = document.createElement("td");
                    folder_delete_button = document.createElement("button");
                    folder_delete_button.innerHTML = "delete this folder";
                    folder_delete_button.setAttribute('value', folder);
                    folder_delete_button.onclick = function(event){
                        delete_folder(event.target.value);
                        get_folders();
                    }
                    column.appendChild(folder_delete_button);
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
                column.innerHTML = "Folders";
                row.appendChild(column);
                table.appendChild(row);
            }
        }
    }
    xhttp.send();
}

function insert_folder(foldername){
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/insert_folder.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            get_folders();
        }
    }
    xhttp.send("foldername=" + foldername);
}

function fill_user_folders(userid){
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/get_user_folders.php", true);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const folderNames = this.responseText.split(",");
            let select = document.getElementById("folder_name");
            select.innerHTML = "";
            folderNames.forEach(folder => {
                if(folder != ""){
                    let option = document.createElement("option");
                    option.setAttribute("value",folder);
                    option.innerHTML = folder;
                    select.appendChild(option);
                }
            });
            get_folders();
        }
    }
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("userid=" + userid);
}

function delete_folder(foldername){
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/delete_folder.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            get_folders();
        }
    }
    xhttp.send("foldername=" + foldername);
}

function fill_edit_folder_form(foldername){
    document.getElementById("edit_foldername").value = foldername;
    select = document.getElementById("username_folder");
    select.innerHTML = "";
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/get_folder_users.php", true);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const users = this.responseText.split(",");
            selected = users[0].split(":");
            selectedid = selected[1];
            no_user_selected = true;
            users.shift();
            users.forEach(user => {
                user_info = user.split(":");
                option = document.createElement("option");
                option.setAttribute("value",user_info[0]);
                option.innerHTML = user_info[1] + " " + user_info[2];
                select.appendChild(option);
                if(user_info[0] == selectedid){    
                    option.selected = true;
                    no_user_selected = false;
                }
            });
            option = document.createElement("option");
            option.setAttribute("value","");
            option.innerHTML = "";
            select.appendChild(option);
            if(no_user_selected){
                option.selected = true;
            }
        }
    }
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("foldername=" + foldername);
    document.getElementById("edit_folder_form").style.display = "block";
}

function fill_add_folder_form(){
    select = document.getElementById("username_folder");
    select.innerHTML = "";
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/get_users.php", true);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const users = this.responseText.split(",");

            option = document.createElement("option");
            option.setAttribute("value","");
            option.innerHTML = "";
            select.appendChild(option);
    
            users.forEach(user => {
                user_info = user.split(":");
                option = document.createElement("option");
                option.setAttribute("value",user_info[5]);
                option.innerHTML = user_info[0] + " " + user_info[1];
                select.appendChild(option);
            });
        }
    }
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
    document.getElementById("folder_form").style.display = "block";
}

function insert_user_folder(userid, foldername){
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/insert_user_folder.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("userid=" + userid + "&foldername=" + foldername);
}

function get_devices(){
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/get_devices.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // get the devices table in the configs
            let table = document.getElementById("admin_devices_table");
                    
            // delete devices in the table to update the devices list
            let deviceRows = table.childNodes;
            for (let i = deviceRows.length - 1; i > 1 ; i--) {
                deviceRows[i].remove();
            }

            // add each device in a different line in the table
            if(this.responseText != ""){
                const devices = this.responseText.split(",");
                devices.forEach(device => {
                    device_info = device.split("/");
                    row = document.createElement("tr");

                    column = document.createElement("td");
                    column.innerHTML = "BAGEO";
                    row.appendChild(column);
    
                    column = document.createElement("td");
                    column.innerHTML = device_info[0];
                    row.appendChild(column);
    
                    column = document.createElement("td");
                    column.innerHTML = device_info[1];
                    row.appendChild(column);

                    column = document.createElement("td");
                    column.innerHTML = device_info[2];
                    row.appendChild(column);

                    column = document.createElement("td");
                    column.innerHTML = "Not associated";
                    row.appendChild(column);

                    column = document.createElement("td");
                    device_edit_button = document.createElement("button");
                    device_edit_button.innerHTML = "edit this device";
                    device_edit_button.onclick = function(){
                        fill_edit_device_form("BAGEO",device_info[0],device_info[1],device_info[2]);
                    }
                    column.appendChild(device_edit_button);
                    row.appendChild(column);

                    column = document.createElement("td");
                    device_delete_button = document.createElement("button");
                    device_delete_button.innerHTML = "delete this device";
                    device_delete_button.onclick = function(){
                        delete_device(device_info[0]);
                        get_devices();
                    }
                    column.appendChild(device_delete_button);
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
                column.innerHTML = "devices";
                row.appendChild(column);
                table.appendChild(row);
            }
        }
    }
    xhttp.send();
}

function edit_device(serial_number, device_name, folder_name, device_type){
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/edit_device.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            get_devices();
        }
    }
    xhttp.send("serial_number=" + serial_number + "&device_name=" + device_name + "&folder_name=" + folder_name + "&device_type=" + device_type);
}

function delete_device(serial_number){
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/delete_device.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            get_devices();
        }
    }
    console.log("serial_number=" + serial_number);
    xhttp.send("serial_number=" + serial_number);
}

function insert_vehicle(brand, name, plate, color){
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/insert_vehicle.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("brand=" + brand + "&name=" + name + "&plate=" + plate + "&color=" + color);
}

function insert_detenu(firstname, lastname, address, duration){
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/insert_detenu.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("firstname=" + firstname + "&lastname=" + lastname + "&address=" + address + "&duration=" + duration);
}

function fill_edit_device_form(type, serial_number, trackername, foldername){
    document.getElementById("serial_number").innerHTML = serial_number;
    document.getElementById("device_name").value = trackername;
    document.getElementById("folder_name").value = foldername;
    
    let select = document.getElementById("device_type");
    for(var i = 0; i < select.options.length; i++){
        select.options[i].selected = true;
    }
    document.getElementById("associated_to").value = "not yet";
    document.getElementById('device_form').style.display='block';
    
    // document.getElementById("check_time_zone").checked = (tracker.time_zone != '0');
}

function fill_associations(type){
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "db/get_associations.php", true);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const associations = this.responseText.split(",");
            let select = document.getElementById("associated_to");
            select.innerHTML = "";
            associations.forEach(association => {
                if(association != ""){
                    const assoc_info = association.split(" ");
                    let option = document.createElement("option");
                    option.setAttribute("value",assoc_info[0]);
                    option.innerHTML = association;
                    select.appendChild(option);
                }
            });
        }   
    }
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("type=" + type);
}

