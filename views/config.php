<?php
    if(!isset($_SESSION['username'])){
        header("Location: ../index.php#home");
        exit();
    }
?>
<input type="text" class="filterSearch" id="trackerList" onkeyup="filterSearch('trackerList','trackers_table','tr')" placeholder="Search tracker...">
<table id="trackers_table">
    <tr>
        <th>S/N</th>
        <th>Name</th>
        <th>Folder</th>
        <th>Config</th>
        <th>Device</th>
        <th>Firmware</th>
        <th>Operator</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
</table>

<div id="config_form" class="modal">
    <div class="modal-content animate">
        <div class="imgcontainer">
            <span onclick="document.getElementById('config_form').style.display='none'" class="close">&times;</span>
            <h2 class="avatar">Configure Tracker</h2>
        </div>
        <button class="tablink" onclick="openTab('Dispositif', this)">Dispositif</button>
        <button class="tablink" onclick="openTab('Général', this)">Général</button>
        <button class="tablink" onclick="openTab('Tracking', this)">Tracking</button>
        <button class="tablink" onclick="openTab('Zone', this);window.dispatchEvent(new Event('resize'));">Zone</button>
        <button class="tablink" onclick="openTab('Contact', this)">Contact</button>

        <div id="Dispositif" class="tabcontent" style="display: block;">
            <div style="display: block;">
                <label>S/N:  </label>
                <label id="serial_number"></label>
            </div>
            <div style="display: block; text-align:center; margin-top:20px;">
                <h2>Network</h2>
            </div>
            <hr>
            <div class="row">
                <div class="column">
                    <table class="form_table">
                        <tr class="form_table">
                            <td class="form_table"><label>APN:</label></td>    
                            <td class="form_table"><label id="apn"></label></td>
                        </tr>    
                        <tr class="form_table">
                            <td class="form_table"><label>N° Tel:</label></td>    
                            <td class="form_table"><input class="form_input" id="phone_number"></td>
                        </tr>    
                        <tr class="form_table">
                            <td class="form_table"><label>Code Pin:</label></td>    
                            <td class="form_table"><input class="form_input" id="pin_code"></td>
                        </tr>    
                    </table>
                </div>
                <div class="vl" style="height: 130px;"></div>
                <div class="column">
                    <table class="form_table" style=" border-collapse:separate; border-spacing:0 15px;">
                        <tr class="form_table">
                            <td class="form_table"><label>CCID:</label></td>    
                            <td class="form_table"><label id="ccid"></label></td>
                        </tr>    
                        <tr class="form_table" style="margin-top:30px;">
                            <td class="form_table"><label>IMSI:</label></td>    
                            <td class="form_table"><label id="imsi"></label></td>
                        </tr>    
                        <tr class="form_table" style="margin-top:30px;">
                            <td class="form_table"><label>Opérateur: </label></td>
                            <td class="form_table"><label id="operator"></label></td>
                        </tr>    
                    </table>
                </div>
            </div>
            
            <div style="display: block; text-align:center; margin-top:20px;">
                <h2>Version</h2>
            </div>
            <hr>
            <div style="display: flex; justify-content:center;">
                <label>Matériel: </label>
                <label id="device"></label>

                <label style="margin-left:200px;">Firmware: </label>
                <label id="firmware" style="margin-right:200px;"></label>

                <label>Bootloader:   </label>
                <label id="bootloader"></label>
            </div>

            <div style="display: flex; justify-content:center; margin-top:20px;">
                <button type="submit" class="form_button">Submit</button>
                <button type="submit" class="form_button">Import</button>
                <button type="submit" class="form_button" onclick="edit_tracker()">Send</button>    
            </div>
        </div>

        <div id="Général" class="tabcontent">
            <div class="row">
                <div class="column">
                    <div style="display: block;">
                        <h3>Réglage du décalage horaire</h3>
                    </div>

                    <div style="display: block; margin-left: 30px;">
                        <label>Fuseau horaire UTC </label>
                        
                        <select class="form_input" id="select_time_zone">
                            <option>-12</option><option>-11</option><option>-10</option><option>-9</option>
                            <option>-8</option><option>-7</option><option>-6</option><option>-5</option>
                            <option>-4</option><option>-3</option><option>-2</option><option>-1</option>
                            <option selected="selected">+0</option><option>+1</option><option>+2</option><option>+3</option>
                            <option>+4</option><option>+5</option><option>+6</option><option>+7</option>
                            <option>+8</option><option>+9</option><option>+10</option><option>+11</option>
                            <option>+12</option>
                        </select>
                    </div>

                    <div style="display: block; margin-top: 20px;">
                        <h3>Alerte de batterie interne</h3>
                    </div>

                    <div style="display: block; margin-left: 30px;">
                        <input class="form_input" type="checkbox" id="check_battery_20">
                        <label>Batterie faible (<20%)</label>
                        <input class="form_input" type="checkbox" id="check_battery_10" style="margin-left: 20px;">
                        <label>Batterie vide (<10%)</label>
                    </div>

                    <div style="display: block; margin-top: 20px;">
                        <h3>Batterie externe</h3>
                    </div>

                    <div style="display: block; margin-left: 30px;">
                        <label>(Les alertes sont envoyées lorsque le seuil est différent de 0)</label>
                        <br>
                        <label>Seuil batterie externe</label>
                        <input class="form_input" id="battery_threshold" value="0">
                        <label>V</label>
                    </div>
                </div>

                <div class="vl" style="height: 270px;"></div>

                <div class="column">
                    <div style="display: block;">
                        <input class="form_input" type="radio" name="mode" value="0">
                        <label>Mode par défaut</label>
                    </div>

                    <div style="display: block; margin-left: 30px;">
                        <label>Période de sommeil</label>
                                    
                        <select class="form_input" id="select_hours">
                            <option selected="selected">0</option><option>1</option>
                            <option>2</option><option>3</option>
                            <option>4</option><option>5</option>
                            <option>6</option><option>7</option>
                            <option>8</option><option>9</option>
                            <option>10</option><option>11</option>
                            <option>12</option><option>13</option>
                        </select>
                                
                        <label> H </label>
                    
                        <select class="form_input" id="select_minutes">
                            <option selected="selected">0</option><option>1</option><option>2</option><option>3</option>
                            <option>4</option><option>5</option><option>6</option><option>7</option>
                            <option>8</option><option>9</option><option>10</option><option>11</option>
                            <option>12</option><option>13</option><option>14</option><option>15</option>
                            <option>16</option><option>17</option><option>18</option><option>19</option>
                            <option>20</option><option>21</option><option>22</option><option>23</option>
                            <option>24</option><option>25</option><option>26</option><option>27</option>
                            <option>28</option><option>29</option><option>30</option><option>31</option>
                            <option>32</option><option>33</option><option>34</option><option>35</option>
                            <option>36</option><option>37</option><option>38</option><option>39</option>
                            <option>40</option><option>41</option><option>42</option><option>43</option>
                            <option>44</option><option>45</option><option>46</option><option>47</option>
                            <option>48</option><option>49</option><option>50</option><option>51</option>
                            <option>52</option><option>53</option><option>54</option><option>55</option>
                            <option>56</option><option>57</option><option>58</option><option>59</option>
                        </select>
                                
                        <label> Mn </label>
                    </div>                
                    <div style="display: block; margin-left: 30px;">
                        <label>Délai d'activation</label>
                     
                        <select class="form_input" id="select_seconds">
                            <option selected="selected">0</option><option>1</option><option>2</option><option>3</option>
                            <option>4</option><option>5</option><option>6</option><option>7</option>
                            <option>8</option><option>9</option><option>10</option><option>11</option>
                            <option>12</option><option>13</option><option>14</option><option>15</option>
                            <option>16</option><option>17</option><option>18</option><option>19</option>
                            <option>20</option><option>21</option><option>22</option><option>23</option>
                            <option>24</option><option>25</option><option>26</option><option>27</option>
                            <option>28</option><option>29</option><option>30</option><option>31</option>
                            <option>32</option><option>33</option><option>34</option><option>35</option>
                            <option>36</option><option>37</option><option>38</option><option>39</option>
                            <option>40</option><option>41</option><option>42</option><option>43</option>
                            <option>44</option><option>45</option><option>46</option><option>47</option>
                            <option>48</option><option>49</option><option>50</option><option>51</option>
                            <option>52</option><option>53</option><option>54</option><option>55</option>
                            <option>56</option><option>57</option><option>58</option><option>59</option>
                        </select>
                            
                        <label> Sec </label>
                    </div>
                        
                    <div style="display: block; margin-left: 30px;">
                        <input class="form_input" type="checkbox" id="gsm_permanent">
                        <label for="email">GSM actif en permanence</label>
                    </div>
                    <div style="display: block; margin-top: 20px;">
                        <input class="form_input" type="radio" name="mode" value="1">
                        <label>Périscope seulement</label>
                    </div>
                    <div style="display: block; margin-top: 20px;">
                        <input class="form_input" type="radio" name="mode" value="2">
                        <label>Activation du transfert périodique</label>    
                    </div>
                </div>
            </div>
            <div style="display: flex; justify-content:center; margin-top:20px;">
                <button type="submit" class="form_button">Submit</button>
                <button type="submit" class="form_button">Import</button>
                <button type="submit" class="form_button" onclick="edit_tracker()">Send</button>
            </div>
        </div>

        <div id="Tracking" class="tabcontent">
            <div style="display: block; text-align:center;">
                <h2 class="control-label bg-info">Paramètres GPS</h2>
            </div>
            <hr>
            <div class="row">
                <div class="column">
                    <div style="display: block;">
                        <label class="control-label">Fréquence des points GPS (HIT)</label>
			<input type="number" class="form_input" id="frequency" min="0" max="180" step="10">
                        <label class="control-label">Sec</label>
                    </div>

                    <div style="display: block;">
                        <label class="control-label">Durée attente point GPS valide</label>
			<input type="number" class="form_input" id="wait" min="0" max="180" step="10">
                        <label class="control-label">Sec</label>
                    </div>
                </div>
                <div class="vl" style="height: 130px;"></div>
                <div class="column">
                    <div style="display: block;">
                        <label class="control-label">Seuil de détection de mouvement</label>
                        <input class="form_input" id="threshold">
                        <label class="control-label">mG</label>
                    </div>

                    <div style="display: block;">
                        <label class="control-label">Attente d'arrêt</label>    
			<input type="number" class="form_input" id="stop" min="0" max="180" step="10">
                        <label class="control-label">Sec</label>
                    </div>
                </div>
            </div>

            <div style="display: block; text-align:center; margin-top:20px;">
                <h2 class="control-label bg-info">Alertes</h2>
            </div>
            <hr>
            <div style="display: block;">
                <h3 class="control-label bg-warning">Zone monde:</h3>
            </div>

            <div style="display: block; margin:10px 30px;">
                <input type="checkbox" name="gender" value="Activation du transfert périodique" id="alert">
                <label>Alerte de mouvement/arrêt</label>    
            </div>

            <div style="display: flex; justify-content:center; margin-top:20px;">    
                <button type="submit" class="form_button">Submit</button>
                <button type="submit" class="form_button">Import</button>
                <button type="submit" class="form_button" onclick="edit_tracker()">Send</button>
            </div>
        </div>

        <div id="Zone" class="tabcontent">
            <table>
                <tbody id="zones_table">
                    <tr>
                        <th>Zone ID</th>
                        <th>Zone name</th>
                        <th>Start time</th>
                        <th>End time</th>
                        <th>Delete zone</th>
                    </tr>
                </tbody>
            </table>
            
            <div id="zone_map" style="height: 500px;"></div>

            <div id="zone_form" style="display:none;">
                <div style="padding: 20px 20px;">
                    <div style="display: block;">
                        <label>Zone name:   </label>
                        <input class="form_input" style="width:15%;" id="zonename">
                    
                        <label>Start time:   </label>
                        <input class="form_input" style="width:10%;" id="start_time">

                        <label>End time:   </label>
                        <input class="form_input" style="width:10%;" id="end_time">

                        <button id="zone_form_confirm" class="form_button">Confirm</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="Contact" class="tabcontent">
            <div class="row">
                <div class="column" style="width:68%;">
                    <table id="contact_table">
                        <tr>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Alert</th>
                            <th>Message</th>
                            <th>Delete</th>
                        </tr>
                    </table>
                </div>
                <div class="vl" style="height: 390px; margin-left:10px"></div>
                <div class="column" style="width:30%;">
                    <ul>
                        <li>
                            <input class="filterSearch" type="text" id="cmdsList" placeholder="Search...">
                        </li>
                        <li>POS</li>
                        <li>CELL</li>
                        <li>BATT</li>
                        <li>ZONE</li>
                        <li>NOW</li>
                        <li>ALERT</li>
                        <li>SPEEDX</li>
                        <li>PERIODX</li>
                        <li>WAITX</li>
                    </ul>
                </div>
            </div>
            <div style="display: flex; justify-content:center; margin-top:20px;">    
                <button type="submit" class="form_button">Submit</button>
                <button type="submit" class="form_button">Import</button>
                <button type="submit" class="form_button" onclick="edit_tracker();">Send</button>
            </div>
        </div>
    </div>

    <!-- <form class="modal-content animate" action="/action_page.php" method="post">
        <div class="imgcontainer">
            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
            <img src="img_avatar2.png" alt="Avatar" class="avatar">
        </div>

        <div class="container">
            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="uname" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" required>
                
            <button type="submit">Login</button>
            <label>
                <input type="checkbox" checked="checked" name="remember"> Remember me
            </label>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
            <span class="psw">Forgot <a href="#">password?</a></span>
        </div>
    </form> -->
</div>
