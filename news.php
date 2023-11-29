<?php
include("dbconn.php");


$isLogged = isset($_SESSION['user_id']);
$isAdmin = $isLogged && isset($_SESSION['role']) && $_SESSION['role'] == 0;
$isEditor = $isLogged && isset($_SESSION['role']) && $_SESSION['role'] == 1;
$isUser = $isLogged && isset($_SESSION['role']) && $_SESSION['role'] == 2;


if ($isAdmin && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['naslov']) && isset($_POST['tekst']) && isset($_POST['datum_unosa'])) {
    $naslov = $_POST['naslov'];
    $tekst = $_POST['tekst'];
    $datum_unosa = $_POST['datum_unosa'];

    $query = "INSERT INTO vijesti (naslov, tekst, datum_unosa) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($MySQL, $query);
    mysqli_stmt_bind_param($stmt, "sss", $naslov, $tekst, $datum_unosa);
    mysqli_stmt_execute($stmt);

    $vijest_id = mysqli_insert_id($MySQL);

    
    $img_directory = "img";
    if (!is_dir($img_directory)) {
        mkdir($img_directory, 0755, true);
    }

    foreach ($_FILES['slike']['tmp_name'] as $key => $tmp_name) {
        $slika_name = $_FILES['slike']['name'][$key];
        $slika_path = $img_directory . "/" . $slika_name;
        move_uploaded_file($tmp_name, $slika_path);

        $query = "INSERT INTO slike (vijest_id, slika_path) VALUES (?, ?)";
        $stmt = mysqli_prepare($MySQL, $query);
        mysqli_stmt_bind_param($stmt, "is", $vijest_id, $slika_name);
        mysqli_stmt_execute($stmt);
    }
}


if (($isAdmin || $isEditor) && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_id'])) {
    $update_id = $_POST['update_id'];
    $naslov = $_POST['naslov_edit'];
    $tekst = $_POST['tekst_edit'];
    $datum_unosa = $_POST['datum_unosa_edit'];

    $update_query = "UPDATE vijesti SET naslov = ?, tekst = ?, datum_unosa = ? WHERE id = ?";
    $update_stmt = mysqli_prepare($MySQL, $update_query);
    mysqli_stmt_bind_param($update_stmt, "sssi", $naslov, $tekst, $datum_unosa, $update_id);
    mysqli_stmt_execute($update_stmt);
}


if ($isAdmin && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    
    $delete_query = "DELETE FROM vijesti WHERE id = ?";
    $delete_stmt = mysqli_prepare($MySQL, $delete_query);
    mysqli_stmt_bind_param($delete_stmt, "i", $delete_id);
    mysqli_stmt_execute($delete_stmt);
}


$query = "SELECT v.*, s.slika_path FROM vijesti v LEFT JOIN slike s ON v.id = s.vijest_id";
$result = mysqli_query($MySQL, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Premier League</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Marijano Prodanić">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <style>
  
    .news {
        display: flex;
        flex-wrap: wrap;
    }

    .article1 {
        width: 48%;
        margin: 1%;
        position: relative;
    }

    .article1 img {
        width: 100%;
        height: 200px; 
        object-fit: cover; 
    }

    .article1 h3 {
        margin-top: 10px;
        margin-left: 0;
    }

    .article1 p.date {
        position: absolute;
        bottom: 0;
        left: 0;
        background-color: rgba(255, 255, 255, 0.8);
        padding: 5px;
        width: 100%;
    }

    .article1 p.description {
        margin-top: 10px;
        margin-left: 180px;
        transform: translateX(-50%);
        width: 50%;
    }

    
    .delete-form,
    .edit-form {
        display: inline-block;
        margin-top: 10px;
    }

    .edit-form input,
    .edit-form textarea,
    .edit-form button,
    .edit-form select {
        width: 100%;
        box-sizing: border-box;
    }

    .edit-form {
        display: none;
    }

    .edit-form.show {
        display: block;
    }

    .edit-form-toggle:checked + .edit-form {
        display: block;
    }

    
    <?php if ($isUser): ?>
        .delete-form,
        .edit-form,
        .forma {
            display: none;
        }
    <?php endif; ?>

    <?php if ($isUser): ?>
        .edit-form-toggle {
            display: none;
        }
    <?php endif; ?>

    <?php if ($isUser): ?>
        .editext {
            display: none;
        }
    <?php endif; ?>
</style>
</head>
<body>
    <main>
        
        <?php if ($isAdmin): ?>
            <div class="forma">
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="naslov">Naslov:</label>
                    <input type="text" name="naslov" required>

                    <label for="tekst">Tekst:</label>
                    <textarea name="tekst" rows="4" required></textarea>

                    <label for="datum_unosa">Datum unosa:</label>
                    <input type="date" name="datum_unosa" required>

                    <label for="slike">Slike:</label>
                    <input type="file" name="slike[]" multiple accept="image/*">

                    <input type="submit" value="Unesi vijest">
                </form>
            </div>
        <?php endif; ?>

       
        <p class="editext">Edit</p>
        <input type="checkbox" id="edit-form-toggle" class="edit-form-toggle">
        <div class="edit-form">
            <form action="" method="post">
                <label for="update_id">Izaberite vijest za uređivanje:</label>
                <select name="update_id" required>
                    <?php
                    $edit_query = "SELECT id, naslov FROM vijesti";
                    $edit_result = mysqli_query($MySQL, $edit_query);

                    while ($edit_row = mysqli_fetch_assoc($edit_result)) {
                        echo '<option value="' . $edit_row['id'] . '">' . $edit_row['naslov'] . '</option>';
                    }
                    ?>
                </select>

                <label for="naslov_edit">Naslov:</label>
                <input type="text" name="naslov_edit" required>

                <label for="tekst_edit">Tekst:</label>
                <textarea name="tekst_edit" rows="4" required></textarea>

                <label for="datum_unosa_edit">Datum unosa:</label>
                <input type="date" name="datum_unosa_edit" required>

                <button type="submit">Update</button>
            </form>
        </div>

        
        <h2>NEWS</h2>
        <div class="news">
            <?php
            $img_directory = "img"; 
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<article class="article1">';
                echo '<a href="#"><img src="' . $img_directory . '/' . $row['slika_path'] . '?v=' . time() . '" alt="' . $row['naslov'] . '" title="' . $row['naslov'] . '"></a>';
                echo '<h3>' . $row['naslov'] . '</h3>';
                echo '<p class="date">' . $row['datum_unosa'] . '</p>';
                echo '<a href="#">More...</a>';
                
               
                echo '<p class="description">' . $row['tekst'] . '</p>';
                
                
                if ($isAdmin || ($isEditor  == $_SESSION['user_id'])) {
                    echo '<form action="" method="post" class="edit-form-toggle" style="display:inline-block;">';
                    echo '<div class="edit-form">';
                    echo '<input type="hidden" name="update_id" value="' . $row['id'] . '">';
                    echo '<button type="submit">Update</button>';
                    echo '</div>';
                    echo '</form>';
                }

                
                if ($isAdmin) {
                    echo '<form class="delete-form" action="" method="post" style="display:inline-block;">';
                    echo '<input type="hidden" name="delete_id" value="' . $row['id'] . '">';
                    echo '<button type="submit">Delete</button>';
                    echo '</form>';
                }

                echo '</article>';
            }
            ?>
        </div>
    </main>
</body>
</html>