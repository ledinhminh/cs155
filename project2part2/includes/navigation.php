<?php 
  function nav_start_outer($page_title = null) { 
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3. org/TR/html4/loose.dtd">
<HTML>
<HEAD>
<link rel="stylesheet" type="text/css" href="/static/zoobar.css">
<TITLE><?php echo "$page_title - " ?>Zoobar Foundation
</TITLE>
</HEAD>
<div id="header">
<div>Stanford CS155 Project 2</div>
<div><a href="?action=logout"><?php 
  global $user;
  if($user->id) 
    echo "Log out " . htmlspecialchars($user->username); 
?></a></div>
</div>
<?php
  // Pick a random title for the page. This is funny for about 3 seconds.
  srand();
  $adjectives = array( "Inquisitive", "Responsible", "Patriotic", 
                       "Trustworthy", "Sustainable", "Objective", 
                       "Disciplined", "Sensible", "Ethical", "Vigilant", 
                       "Principled", "Awesome" );
  $nouns = array( "Thinking", "Policy", "Dialogue", "Learning", 
                  "Discourse", "Research", "Advocacy", );
  $adverbs = array( "best", "brightest", "foremost", "leading", 
                    "proven", "loyal", "brave", "meritorious", 
                    "shrewd", "important", "skillful" );
  $pluralnouns = array ( "thinkers", "minds", "students", "soldiers",
                         "advocates", "representatives", "researchers" );
  $concepts = array( "21st century", "next generation", 
                     "new world order", "United States", 
                     "counterinsurgency", "information superhighway" );
  $adjective = $adjectives[array_rand($adjectives)];
  $noun = $nouns[array_rand($nouns)];
  $adverb = $adverbs[array_rand($adverbs)];
  $pluralnoun = $pluralnouns[array_rand($pluralnouns)];
  $concept = $concepts[array_rand($concepts)];
  echo "<h1><a href='index.php'>Zoobar Foundation for " .
       "$adjective $noun</a></h1>";
  echo "<h2>Supporting the $adverb $pluralnoun of the $concept</h2>";

} function nav_start_inner() { ?>

<div id="main" class="centerpiece">
<table>
<tr><td>
<p><?php
// Output a pipe-delimited list of available pages
$pages = array( "Home" => "index.php", 
                "Users" => "users.php", 
                "Transfer" => "transfer.php" );
foreach($pages as $name => $page) {
  $script = $_SERVER['SCRIPT_NAME'];
  if(strpos($script, $page, strlen($script) - strlen($page)) === false) {
    echo "<a href=$page>$name</a>";
  } else {
    echo "<b>$name</b>";
  }
  if($name != "Transfer") echo " | ";
}
?></p>
</td></tr>
<tr><td class=main>

<?php } function nav_end_inner() { ?>

</td></tr>
</table>
</div>

<?php } function nav_end_outer() { ?>

</BODY>
</HTML>

<?php } ?>
