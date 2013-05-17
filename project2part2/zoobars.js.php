<?php

    // txt-db-api library: http://www.c-worker.ch/txtdbapi/index_eng.php
    require_once("txt-db-api/txt-db-api.php");
    require_once("login.php");
    require_once("includes/auth.php");
    require_once("includes/navigation.php");
    
    // Init global variables
    $db = new Database("zoobar");
    $user = new User($db);
    
    if(validate_user($user)) {
?>
    
    var myZoobars = <?php 
          $sql = "SELECT Zoobars FROM Person WHERE PersonID=$user->id";
          $rs = $db->executeQuery($sql);
          $balance = $rs->getValueByNr(0,0);
          echo $balance > 0 ? $balance : 0;
        ?>;
    var div = document.getElementById("myZoobars");
    
    if (div != null)
    {
        div.innerHTML = myZoobars;
    }
<?php
    }
?>
