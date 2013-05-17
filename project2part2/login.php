<?php
// login.php: Functions for checking auth and displaying login page

// Return true on registration success, otherwise set $login_error
function validate_registration(&$user) {
  global $login_error;
  $success = false;
  $username = $_POST['login_username'];
  $password = $_POST['login_password'];
  if(!$username) 
    $login_error = "You must supply a username to register.";
  else if(!$password) 
    $login_error = "You must supply a password to register.";
  else if(!$user->_addRegistration($username, $password)) 
    $login_error = "Registration failed.";
  else $success = true;
  return $success;
}

// Return true on login success, otherwise set $login_error
function validate_login(&$user) {
  global $login_error;
  $success = false;
  $username = $_POST['login_username'];
  $password = $_POST['login_password'];
  if(!$username) 
    $login_error = "You must supply a username to log in.";
  else if(!$password) 
    $login_error = "You must supply a password to log in.";
  else if(!$user->_checkLogin($username, $password)) 
    $login_error = "Invalid username or password.";
  else $success = true;
  return $success;
}

// Return true if the user is valid, otherwise return false
function validate_user(&$user)
{
  if (isset($_POST['submit_registration']) && 
      validate_registration($user)) { 
    return true;  // Successful registration
  } else if(isset($_POST['submit_login']) && validate_login($user)) {
    return true;  // Successful login
  } else if($user->id > 0) {
    return true;  // Already logged in
  } else {
    return false;  // Request credentials
  } 
}

function display_login()
{
  nav_start_outer("Login");
?>
<div id="login" class="centerpiece">
<form name=loginform method=POST action="<?php echo $_SERVER['PHP_SELF']?>">
<table>
<tr>
   <td>Username:</td>
  <td><input type=text name=login_username size=30 autocomplete=no value=<?php 
    echo htmlspecialchars($_POST['login_username']); ?>></td>
</tr>
<tr>
   <td>Password:</td>
  <td colspan=2><input type=password name=login_password size=30 autocomplete=no>
  <input type=submit name=submit_login value="Log in">
  <input type=submit name=submit_registration value="Register"></td>
</tr>
</table>
</form>
</div>
<div class="footer warning">
<?php global $login_error; echo $login_error; ?>
</div>
<script>document.loginform.login_username.focus();</script>
<?php
  nav_end_outer();
} ?>
