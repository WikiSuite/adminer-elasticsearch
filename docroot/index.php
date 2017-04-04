<?php
function adminer_object() {
    include_once "./plugins/plugin.php";
    
    foreach (glob("../plugins/*.php") as $filename) {
        include_once "./$filename";
    }
    
    $plugins = array(
       new AdminerElasticsearch(),
    );
    
    return new AdminerPlugin($plugins);
}

include "../adminer-4.3.0.php";
?>
