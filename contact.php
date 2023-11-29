<?php
print'
<!DOCTYPE html>
<html>
<head>
    <title>Premier League</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Marijano Prodanić">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>


    <main>
        <div class="naslov">
            <h1>Greatness comes from everywhere</h1>
        </div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d38007.78482268321!2d-2.318923644802739!3d53.459764064322144!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487bae72e7e47f69%3A0x6c930e96df4455fe!2sOld%20Trafford!5e0!3m2!1shr!2shr!4v1697014603789!5m2!1shr!2shr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        <section>
            <form>
                <label for="fname">First name:</label><br>
                <input type="text" id="fname" name="fname" value="John" required><br>
                <label for="lname">Last name:</label><br>
                <input type="text" id="lname" name="lname" value="Doe" required><br>
                <label for="address">Address</label><br>
                <input type="text" id="address" name="address" value="" required><br>
                <label for="email">Enter your email:</label><br>
                <input type="email" id="email" name="email"><br>
                <label for="country">Choose a country:</label><br>
                <select id="country" name="countrylist" form="countryform">
                    <option value="cro">Croatia</option>
                    <option value="ger">Germany</option>
                    <option value="slo">Slovenia</option>
                    <option value="jap">Japan</option>
                </select><br>
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
'?>