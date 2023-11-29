<?php
include("dbconn.php");


$username = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo '<p>Generated country: ' . $_POST['country'] . '</p>';
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $username = strtolower(substr($fname, 0, 1) . $lname);

    echo '<p>Generated Username: ' . $username . '</p>';

    
    $query  = "SELECT * FROM korisnici WHERE email = ? OR username = ?";
    $stmt = mysqli_prepare($MySQL, $query);
    mysqli_stmt_bind_param($stmt, "ss", $email, $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($row) {
            
            echo '<p>User with this email or username already exists!</p>';
        } else {
            

           
            $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]);

            
            $query  = "INSERT INTO korisnici (first_name, last_name, email, username, country_id, city, street, date_of_birth, password, role)";
            $query .= " VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 3)"; // Default role set to 0
            $stmt = mysqli_prepare($MySQL, $query);

            mysqli_stmt_bind_param($stmt, "sssssssss", $fname, $lname, $email, $username, $_POST['country'], $_POST['city'], $_POST['street'], $_POST['date'], $pass_hash);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                echo '<p>' . ucfirst(strtolower($fname)) . ' ' . ucfirst(strtolower($lname)) . ', thank you for registration </p><hr>';
            } else {
                
                echo '<p>Error executing query: ' . mysqli_error($MySQL) . '</p>';
            }

            mysqli_stmt_close($stmt);
        }
    } else {
        
        echo '<p>Error executing query: ' . mysqli_error($MySQL) . '</p>';
    }
}
?>



<div class="naslov">
    <h1>Greatness comes from everywhere</h1>
</div>

<section>
    <form action="" id="registration" name="registration" method="POST">
        <label for="fname">First name:</label><br>
        <input type="text" id="fname" name="fname" value="John" required><br>

        <label for="lname">Last name:</label><br>
        <input type="text" id="lname" name="lname" value="Doe" required><br>

        <label for="email">Enter your email:</label><br>
        <input type="email" id="email" name="email"><br>

        <label for="country">Choose a country:</label><br>
        <select name="country" id="country">
        <option value="">molimo odaberite</option>
            <?php
                $query  = "SELECT * FROM countries";
                 $result = @mysqli_query($MySQL, $query);
                while ($row = @mysqli_fetch_array($result)) {
                print '<option value="' . $row['id'] . '">' . $row['country_name'] . '</option>';
             }
             ?>
</select><br>
<br>

        <label for="city">City:</label><br>
        <input type="text" id="city" name="city"><br>

        <label for="street">Street:</label><br>
        <input type="text" id="street" name="street"><br>

        <label for="date">DoB</label><br>
        <input type="date" id="date" name="date"><br>

        <label for="password">Password</label><br>
        <input type="password" id="password" name="password"><br><br>

        
        <input type="hidden" id="username" name="username" value="<?php echo $username; ?>">

        <input type="submit">
    </form>
</section>

<p style="margin-bottom: 0;">Social media:</p>
<a href="https://www.facebook.com/premierleague/" target="_blank"><img src="img/icons8-facebook.svg" alt="Linkedin" title="Linkedin" style="width:24px;"></a>
<a href="https://twitter.com/premierleague" target="_blank"><img src="img/icons8-twitter.svg" alt="Twitter" title="Twitter" style="width:24px;"></a>
<a href="https://www.instagram.com/premierleague/" target="_blank"><img src="img/icons8-instagram-30.png" alt="Google+" title="Google+" style="width:24px;"></a>
</main>
</body>
</html>
