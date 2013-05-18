<?php 
require_once("includes/common.php"); 
nav_start_outer("Users");
nav_start_inner();

if($_GET['user'] && !ctype_alnum($_GET['user'])){
    echo '<p class="warning" id="baduser">Invalid username</p>';
    exit;
}
$safeUser = _sanitize($_GET['user']);
?>
<form name="profileform" method="GET" action="<?php echo $_SERVER['PHP_SELF']?>">
    <nobr>User:
    <input type="text" name="user" size=10 value="<?php echo $safeUser; ?>">
    <input type="submit" value="View"></nobr>
</form>
<div id="profileheader"><!-- user data appears here --></div>
<?php 
$sql = "SELECT Profile, Username, Zoobars FROM Person " . 
    "WHERE Username='$safeUser'";
$rs = $db->executeQuery($sql);
if ( $rs->next() ) { // Sanitize and display profile
    list($profile, $username, $zoobars) = $rs->getCurrentValues();
    echo "<div class=profilecontainer><b>Profile</b>";
    $allowed_tags = 
        '<a><br><b><h1><h2><h3><h4><i><img><li><ol><p><strong><table>' .
        '<tr><td><th><u><ul><em><span>';
    $profile = strip_tags($profile, $allowed_tags);
    $disallowed = 
        'javascript:|window|eval|setTimeout|setInterval|target|'.
        'onAbort|onBlur|onChange|onClick|onDblClick|'.
        'onDragDrop|onError|onFocus|onKeyDown|onKeyPress|'.
        'onKeyUp|onLoad|onMouseDown|onMouseMove|onMouseOut|'.
        'onMouseOver|onMouseUp|onMove|onReset|onResize|'.
        'onSelect|onSubmit|onUnload';
    $taggedProfile = applyTags($profile);
    echo "<p id=profile>$taggedProfile</p></div>";
    $zoobars = ($zoobars > 0) ? $zoobars : 0;
    echo "<span id='zoobars' class='$zoobars'/>";	
?>
    <script type="text/javascript">
    var total = <?php echo $zoobars ?>;
    function showZoobars(zoobars) {
        document.getElementById("profileheader").innerHTML = "<?php echo $safeUser ?>'s zoobars:" + zoobars;
        if (zoobars < total) {
            setTimeout("showZoobars(" + (zoobars + 1) + ")", 100);
        }
    }
    if (total > 0) showZoobars(0);  // count up to total
    </script>

<?php
} else if($safeUser) {  // user parameter present but user not found
    echo '<p class="warning" id="baduser">Cannot find that user.</p>';
}
?>
<?php 
nav_end_inner();
nav_end_outer(); 
?>
