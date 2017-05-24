<?php
function adminer_object() {
    include_once "../plugins/plugin.php";
    
    foreach (glob("../plugins/*.php") as $filename) {
        include_once "./$filename";
    }
    
    $plugins = array(
       new AdminerElasticsearch(),
    );
    
    return new AdminerPlugin($plugins);
}

session_save_path('/var/lib/webconfig/session');

include "../adminer.php";

?>
