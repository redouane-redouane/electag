function getContent(fragmentId, callback){
    var pages = {
        home: "home.php",
        map: "map.php",
        table: "table.php",
        config: "config.php",
        admin: "admin.php",
        logs: "logs.php"
    };

    var request = new XMLHttpRequest();
    request.open("GET", "views/" + pages[fragmentId], true);
    request.send(null);
    request.onreadystatechange = function() {
        if (request.readyState == 4){
            callback(request.responseText);
            switch(pages[fragmentId]) {
                case "map.php":
                    document.getElementsByTagName("body")[0].style.backgroundImage = "";
                    loadmap();
                    break;
                case "table.php":
                    document.getElementsByTagName("body")[0].style.backgroundImage = "";
                    fill_table();
                    break;
                case "config.php":
                    document.getElementsByTagName("body")[0].style.backgroundImage = "";
                    config_form();
                    get_trackers();
                    break;
                case "admin.php":
                    document.getElementsByTagName("body")[0].style.backgroundImage = "";
                    get_users();
                    break;
                case "logs.php":
                    document.getElementsByTagName("body")[0].style.backgroundImage = "";
                    break;
                case "home.php":
                    document.getElementsByTagName("body")[0].style.backgroundImage = "url('img/flag.jpg')";
                    break;
                default:
                  // code block
            }
        }
    };
}
  
function loadContent(){
    var contentDiv = document.getElementById("main"),
        fragmentId = location.hash.substr(1);
  
    getContent(fragmentId, function (content) {
        contentDiv.innerHTML = content;
    });
}
  
if(!location.hash) {
    location.hash = "#home";
}
loadContent();   
window.addEventListener("hashchange", loadContent)
