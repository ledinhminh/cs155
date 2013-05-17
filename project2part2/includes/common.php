<?php

// txt-db-api library: http://www.c-worker.ch/txtdbapi/index_eng.php
require_once("txt-db-api/txt-db-api.php");
require_once("login.php");
require_once("auth.php");
require_once("navigation.php");

// Allow users to use the back button without reposting data
header ("Cache-Control: private");

// Init global variables
$db = new Database("zoobar");
$user = new User($db);

?>

<script>
        // Imperfect framebusting
        if(top.location != self.location){
                parent.location = self.location;
        }
</script>

<?php

// Check for logout and maybe display login page
if($_GET['action'] == 'logout') { 
  $user->_logout();
  display_login();
  exit();
}

// Validate user and maybe display login page
if(!validate_user($user)) {
  display_login();
  exit();
}

?>
