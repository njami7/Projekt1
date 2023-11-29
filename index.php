<?php
include("dbconn.php");

print '
<!DOCTYPE html>
<html>
<head>
    <title>Premier League</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Marijano Prodanic">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css?v=' . time() . '">
</head>

<body>

<header>
    <div';
if (!isset($_GET['menu']) || $_GET['menu'] == 1) {
    print ' class="hero-image"';
} else {
    print ' class="hero-subimage"';
}
print '></div>
        <nav>';
include("menu.php");
print '</nav>
</header>
<main>';

if (!isset($_GET['menu']) || $_GET['menu'] == 1) {
    include("home.php");
} else if ($_GET['menu'] == 2) {
    include("news.php");
} else if ($_GET['menu'] == 3) {
    include("contact.php");
} else if ($_GET['menu'] == 4) {
    include("about.php");
} else if ($_GET['menu'] == 5) {
    include("gallery.php");
} else if ($_GET['menu'] == 6) {
    include("register.php");
} else if ($_GET['menu'] == 7) {
    include("login.php");
} else if ($_GET['menu'] == 8) {
    include("api.php");
} else if ($_GET['menu'] == 9) {
    include("admin.php");
}

print '
</main>

<footer>
    <p style="text-align:center;">Premier League &copy; Marijano Prodanic</p>
</footer>

</body>
</html>
';
?>
