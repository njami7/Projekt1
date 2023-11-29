<?php
include("dbconn.php");


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 0) {
    die('You do not have permission to access this page.');
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id']) && isset($_POST['new_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['new_role'];

    
    error_log("Received POST data: user_id=$user_id, new_role=$new_role");


    $query = "SELECT * FROM korisnici WHERE id = ?";
    $stmt = mysqli_prepare($MySQL, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            
            error_log("User found: " . print_r($user, true));

           
            $update_query = "UPDATE korisnici SET role = ? WHERE id = ?";
            $update_stmt = mysqli_prepare($MySQL, $update_query);
            mysqli_stmt_bind_param($update_stmt, "ii", $new_role, $user_id);
            $update_result = mysqli_stmt_execute($update_stmt);

            if ($update_result) {
                echo '<p>Role updated successfully!</p>';
            } else {
                echo '<p>Error updating role: ' . mysqli_error($MySQL) . '</p>';
            }
        } else {
            echo '<p>Selected user does not exist.</p>';
        }
    } else {
        echo '<p>Error executing query: ' . mysqli_error($MySQL) . '</p>';
    }
}


$user_query = "SELECT id, username FROM korisnici";
$user_result = mysqli_query($MySQL, $user_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>

<h2>Admin Panel</h2>


<form action="" method="post">
    <label for="user_id">Select User:</label>
    <select name="user_id" id="user_id" required>
        <?php
        while ($row = mysqli_fetch_assoc($user_result)) {
            echo '<option value="' . $row['id'] . '">' . $row['username'] . '</option>';
        }
        ?>
    </select>

    <label for="new_role">Select New Role:</label>
    <select name="new_role" id="new_role" required>
        <option value="0">Admin</option>
        <option value="1">Editor</option>
        <option value="2">User</option>
    </select>

    <input type="submit" value="Update Role">
</form>

</body>
</html>
