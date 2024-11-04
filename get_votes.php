<?php
$filename = 'votes.txt';

//file_exists
if (!file_exists($filename)) {

    $initialVotes = [
        'Rosary Bea' => 0,
        'Be-ann' => 0,
        'Daniel' => 0,
        'Ciara May' => 0,
        'Jose Gabriel' => 0,
    ];
    //file_put_contents
    file_put_contents($filename, json_encode($initialVotes));
}

// file_get_contents
$votes = json_decode(file_get_contents($filename), true);

if (isset($_POST['vote'])) {
    $votedMember = $_POST['vote'];

    if (isset($votes[$votedMember])) {
        $votes[$votedMember]++;
    }

    // file_put_contents
    file_put_contents($filename, json_encode($votes));

    echo "Thank you for voting for $votedMember!";
}

// file()
$votesArray = file($filename);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group 2: Group Website</title>
</head>
<body>

<h1>Vote for Your Favorite Group Member</h1>

<form method="POST">
    <button name="vote" value="Rosary Bea">Vote for Rosary Bea</button><br>
    <button name="vote" value="Be-ann">Vote for Be-ann</button><br>
    <button name="vote" value="Daniel">Vote for Daniel</button><br>
    <button name="vote" value="Ciara May">Vote for Ciara May</button><br>
    <button name="vote" value="Jose Gabriel">Vote for Jose Gabriel</button><br>
</form>

<h2>Current Votes:</h2>
<ul>
    <?php foreach ($votes as $name => $count): ?>
        <li><?php echo "$name: $count votes"; ?></li>
    <?php endforeach; ?>
</ul>

</body>
</html>

