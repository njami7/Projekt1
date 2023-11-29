<?php
session_start();

print '
<ul>
    <li><a href="index.php?menu=1">Home</a></li>
    <li><a href="index.php?menu=2">News</a></li>
    <li><a href="index.php?menu=3">Contact</a></li>
    <li><a href="index.php?menu=4">About</a></li>
    <li><a href="index.php?menu=5">Gallery</a></li>';

if (!isset($_SESSION['user_id'])) {
    
    print '
    <li><a href="index.php?menu=6">Register</a></li>
    <li><a href="index.php?menu=7">Login</a></li>';
} else {
  
    if (isset($_SESSION['role']) && $_SESSION['role'] == 0) {
        
        print '<li><a href="index.php?menu=9">Admin Panel</a></li>';
    }

   
    echo '<li>User Role: ' . $_SESSION['role'] . '</li>';

   
    print '
    <li><a href="logout.php">Logout</a></li>
    <li><a href="index.php?menu=8">API</a></li>';
}

print '
</ul>';
?>
