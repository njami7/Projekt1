<?php
// API URL
$api_url = 'https://fantasy.premierleague.com/api/leagues-classic/1090021/standings/';


$json_data = file_get_contents($api_url);


if ($json_data === FALSE) {
    die('Error fetching data from the API');
}


$data = json_decode($json_data, true);

if ($data === null) {
    die('Error decoding JSON data');
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fantasy League Standings</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>League Standings</h2>

<table>
    <tr>
        <th>Rank</th>
        <th>Player Name</th>
        <th>Total Points</th>
    </tr>

    <?php
  
    foreach ($data['standings']['results'] as $standing) {
        ?>
        <tr>
            <td><?= $standing['rank'] ?></td>
            <td><?= $standing['player_name'] ?></td>
            <td><?= $standing['total'] ?></td>
        </tr>
        <?php
    }
    ?>
</table>

</body>
</html>
