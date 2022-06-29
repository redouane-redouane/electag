<button class="tablink" onclick="openTab('Users', this);get_users();">Users</button>
<button class="tablink" onclick="openTab('Groups', this);get_groups();">Groups</button>
<button class="tablink" onclick="openTab('Folders', this);get_folders();">Folders</button>
<button class="tablink" onclick="openTab('Devices', this);get_devices();">Devices</button>
<button class="tablink" onclick="openTab('Vehicles', this);get_vehicles();">Vehicles</button>
<button class="tablink" onclick="openTab('Détenus', this);get_detenus();">Détenus</button>

<div id="Users" class="tabcontent" style="display: block;">
    <input type="text" class="filterSearch" id="admin_users" onkeyup="filterSearch('admin_users','admin_users_table','tr')" style="width:70%;" placeholder="Search...">
    <button class="form_button" onclick="document.getElementById('user_form').style.display='block';">Add user</button>
    <table>
        <tbody id="admin_users_table">
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>E-mail</th>
                <th>Username</th>
                <th>Group</th>
                <th>Edit user</th>
                <th>Delete user</th>
            </tr>
        </tbody>   
    </table>
    <div id="user_form" class="modal">
        <div class="modal-content animate">
            <div class="imgcontainer">
                <span onclick="document.getElementById('user_form').style.display='none'" class="close">&times;</span>
                <h2 class="avatar">Add user</h2>
            </div>
            <div style="padding: 20px 20px;">
                <table class="form_table">
                    <tr class="form_table">
                        <td class="form_table"><label>First name:</label></td>
                        <td class="form_table"><input class="form_input" id="firstname"></td>
                    </tr>
                    <tr class="form_table">
                        <td class="form_table"><label>Last name:</label></td>
                        <td class="form_table"><input class="form_input" id="lastname"></td>
                    </tr>
                    <tr class="form_table">
                        <td class="form_table"><label>E-mail:</label></td>
                        <td class="form_table"><input class="form_input" id="email"></td>
                    </tr>
                    <tr class="form_table">
                        <td class="form_table"><label>Username:</label></td>
                        <td class="form_table"><input class="form_input" id="username"></td>
                    </tr>
                    <tr class="form_table">
                        <td class="form_table"><label>Group:</label></td>
                        <td class="form_table"><input class="form_input" id="group"></td>
                    </tr>
                    <tr class="form_table">
                        <td class="form_table"><label>Password:</label></td>
                        <td class="form_table"><input class="form_input" id="password"></td>
                    </tr>
                    <tr class="form_table">
                        <td class="form_table"><label>Confirm password:</label></td>
                        <td class="form_table"><input class="form_input" id="password_confirm"></td>
                    </tr>
                </table>
                <button class="form_button" onclick="
                        insert_user(
                            document.getElementById('firstname').value, 
                            document.getElementById('lastname').value, 
                            document.getElementById('email').value, 
                            document.getElementById('username').value, 
                            document.getElementById('group').value, 
                            document.getElementById('password').value, 
                            document.getElementById('password_confirm').value
                        );
                        ">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<div id="Groups" class="tabcontent">
    <input type="text" class="filterSearch" id="admin_groups" onkeyup="filterSearch('admin_groups','admin_groups_table','tr')" style="width:70%;" placeholder="Search...">
    <button class="form_button" onclick="document.getElementById('group_form').style.display='block';">Add group</button>
    <table id="admin_groups_table">
        <tbody id="admin_groups_table">
            <tr>
                <th>Group name</th>
                <th>Edit group</th>
                <th>Delete group</th>
            </tr>
        </tbody>
    </table>
    <div id="group_form" class="modal">
        <div class="modal-content animate">
            <div class="imgcontainer">
                <span onclick="document.getElementById('group_form').style.display='none'" class="close">&times;</span>
                <h2 class="avatar">Add group</h2>
            </div>
            <div style="padding: 20px 20px;">
                <table class="form_table">
                    <tr class="form_table">
                        <td class="form_table"><label>Group name:</label></td>    
                        <td class="form_table"><input class="form_input" id="groupname"></td>
                    </tr>
                </table>
                
                <button class="form_button" onclick="insert_group(document.getElementById('groupname').value);">Confirm</button>
            </div>
        </div>
    </div>
</div>

<div id="Folders" class="tabcontent">
    <input type="text" class="filterSearch" id="admin_folders" onkeyup="filterSearch('admin_folders','admin_folders_table','tr')" style="width:70%;" placeholder="Search...">
    <button class="form_button" onclick="fill_add_folder_form();">Add folder</button>
    <table>
        <tbody id="admin_folders_table">
            <tr>
                <th>Folder name</th>
                <th>Edit folder</th>
                <th>Delete folder</th>
            </tr>
        </tbody>
    </table>
    <div id="folder_form" class="modal">
        <div class="modal-content animate">
            <div class="imgcontainer">
                <span onclick="document.getElementById('folder_form').style.display='none'" class="close">&times;</span>
                <h2 class="avatar">Add folder</h2>
            </div>
            <div style="padding: 20px 20px;">
                <table class="form_table">
                    <tr class="form_table">
                        <td class="form_table"><label>Folder name:</label></td>    
                        <td class="form_table"><input class="form_input" id="foldername"></td>
                    </tr>    
                    <tr class="form_table">
                        <td class="form_table"><label>Owner:</label></td>    
                        <td class="form_table"><select class="form_input" id="folder_owner"></td>
                    </tr>
                </table>
                
                <button class="form_button" onclick="insert_folder(document.getElementById('foldername').value)">Confirm</button>
            </div>
        </div>
    </div>
    <div id="edit_folder_form" class="modal">
        <div class="modal-content animate">
            <div class="imgcontainer">
                <span onclick="document.getElementById('edit_folder_form').style.display='none'" class="close">&times;</span>
                <h2 class="avatar">Edit folder</h2>
            </div>
            <div style="padding: 20px 20px;">
                <div style="display: block;">
                    <table class="form_table">
                        <tr class="form_table">
                            <td class="form_table"><label>Folder name:</label></td>    
                            <td class="form_table"><input class="form_input" id="edit_foldername"></td>
                        </tr>    
                        <tr class="form_table">
                            <td class="form_table"><label>Owner:</label></td>    
                            <td class="form_table"><select class="form_input" id="username_folder"></select></td>
                        </tr>   
                    </table>
                </div>
                <button class="form_button" onclick="insert_user_folder(document.getElementById('username_folder').value, document.getElementById('edit_foldername').value)">Confirm</button>
            </div>
        </div>
    </div>
</div>

<div id="Devices" class="tabcontent">
    <input type="text" class="filterSearch" id="admin_devices" onkeyup="filterSearch('admin_devices','admin_devices_table','tr')" style="width:70%;" placeholder="Search...">
    <button class="form_button" onclick="document.getElementById('device_form').style.display='block';">Add device</button>
    <table>
        <tbody id="admin_devices_table">
            <tr>
                <th>Type</th>
                <th>Serial number</th>
                <th>Name</th>
                <th>Folder</th>
                <th>Associated to</th>
                <th>Edit device</th>
                <th>Delete device</th>
            </tr>
        </tbody>
    </table>
    <div id="device_form" class="modal">
        <div class="modal-content animate">
            <div class="imgcontainer">
                <span onclick="document.getElementById('device_form').style.display='none'" class="close">&times;</span>
                <h2 class="avatar">Edit device</h2>
            </div>
            <div style="padding: 20px 20px;">
                <table class="form_table">
                    <tr class="form_table">
                        <td class="form_table"><label>Serial number:</label></td>    
                        <td class="form_table"><label id="serial_number"></label></td>
                    </tr>    
                    <tr class="form_table">
                        <td class="form_table"><label>Name:</label></td>    
                        <td class="form_table"><input class="form_input" id="device_name"></td>
                    </tr>    
                    <tr class="form_table">
                        <td class="form_table"><label>User:</label></td>    
                        <td class="form_table">
                            <select class="form_input" id="user_name" onchange="fill_user_folders(document.getElementById('user_name').value)">
                                <?php
                                    require '../db/get_device_users.php';
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr class="form_table">
                        <td class="form_table"><label>Folder:</label></td>    
                        <td class="form_table"><select class="form_input" id="folder_name"></select></td>
                    </tr>    
                    <tr class="form_table">
                        <td class="form_table"><label>Type:</label></td>    
                        <td class="form_table">
                            <select class="form_input" id="device_type" onchange="fill_associations(document.getElementById('device_type').value)">
                                <option value="balise">Balise</option>
                                <option value="bracelet">Bracelet</option>
                            </select>
                        </td>
                    </tr>    
                    <tr class="form_table">
                        <td class="form_table"><label>Associated To:</label></td>    
                        <td class="form_table">
                            <select class="form_input" id="associated_to">
                            </select>
                        </td>
                    </tr>    
                </table>
        
                <button class="form_button" onclick="edit_device(document.getElementById('serial_number').value, document.getElementById('device_name').value, document.getElementById('folder_name').value, document.getElementById('device_type').value)">Confirm</button>
            </div>
        </div>
    </div>
</div>

<div id="Vehicles" class="tabcontent">
    <input type="text" class="filterSearch" id="admin_vehicles" onkeyup="filterSearch('admin_vehicles','admin_vehicles_table','tr')" style="width:70%;" placeholder="Search...">
    <button class="form_button" onclick="document.getElementById('vehicles_form').style.display='block';">Add vehicle</button>
    <table id="admin_vehicles_table">
        <tr>
            <th>ID</th>
            <th>Brand</th>
            <th>Name</th>
            <th>Licence plate</th>
            <th>Color</th>
            <th>Associated to</th>
            <th>Edit vehicle</th>
            <th>Delete vehicle</th>
        </tr>
        <?php
            require '../db/get_vehicles.php';
        ?>
    </table>
    <div id="vehicles_form" class="modal">
        <div class="modal-content animate">
            <div class="imgcontainer">
                <span onclick="document.getElementById('vehicles_form').style.display='none'" class="close">&times;</span>
                <h2 class="avatar">Add vehicle</h2>
            </div>
            <div style="padding: 20px 20px;">
                <table class="form_table">
                    <tr class="form_table">
                        <td class="form_table"><label>Brand:</label></td>    
                        <td class="form_table"><input class="form_input" id="brand"></td>
                    </tr>    
                    <tr class="form_table">
                        <td class="form_table"><label>Name:</label></td>    
                        <td class="form_table"><input class="form_input" id="name"></td>
                    </tr>    
                    <tr class="form_table">
                        <td class="form_table"><label>plate:</label></td>    
                        <td class="form_table"><input class="form_input" id="plate"></td>
                    </tr>
                    <tr class="form_table">
                        <td class="form_table"><label>Color:</label></td>    
                        <td class="form_table"><input class="form_input" id="color"></td>
                    </tr>
                </table>
                
                <button class="form_button"  onclick="insert_vehicle(document.getElementById('brand').value, document.getElementById('name').value, document.getElementById('plate').value, document.getElementById('color').value)">Confirm</button>
            </div>
        </div>
    </div>
</div>

<div id="Détenus" class="tabcontent">
    <input type="text" class="filterSearch" id="admin_detenus" onkeyup="filterSearch('admin_detenus','admin_detenus_table','tr')" style="width:70%;" placeholder="Search...">
    <button class="form_button" onclick="document.getElementById('detenus_form').style.display='block';">Add detenu</button>
    <table id="admin_detenus_table">
        <tr>
            <th>ID</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Address</th>
            <th>Duration</th>
            <th>Associated to</th>
            <th>Edit détenu</th>
            <th>Delete détenu</th>
        </tr>
        <?php
            require '../db/get_detenus.php';
        ?>
    </table>
    <div id="detenus_form" class="modal">
        <div class="modal-content animate">
            <div class="imgcontainer">
                <span onclick="document.getElementById('detenus_form').style.display='none'" class="close">&times;</span>
                <h2 class="avatar">Add détenu</h2>
            </div>
            <div style="padding: 20px 20px;">
                <table class="form_table">
                    <tr class="form_table">
                        <td class="form_table"><label>Firstname:</label></td>    
                        <td class="form_table"><input class="form_input" id="firstname_detenu"></td>
                    </tr>    
                    <tr class="form_table">
                        <td class="form_table"><label>Lastname:</label></td>    
                        <td class="form_table"><input class="form_input" id="lastname_detenu"></td>
                    </tr>    
                    <tr class="form_table">
                        <td class="form_table"><label>Address:</label></td>    
                        <td class="form_table"><input class="form_input" id="address"></td>
                    </tr>
                    <tr class="form_table">
                        <td class="form_table"><label>Duration:</label></td>    
                        <td class="form_table"><input class="form_input" id="duration"></td>
                    </tr>
                </table>
                
                <button class="form_button"  onclick="insert_detenu(document.getElementById('firstname_detenu').value, document.getElementById('lastname_detenu').value, document.getElementById('address').value, document.getElementById('duration').value)">Confirm</button>
            </div>
        </div>
    </div>
</div>