<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vote = $_POST['vote']; 

    $file = 'votes.txt';
    $votes = file_exists($file) ? unserialize(file_get_contents($file)) : array('Rosary Bea' => 0, 'Be-ann' => 0, 'Daniel' => 0, 'Ciara May' => 0, 'Jose Gabriel' => 0);

    if (array_key_exists($vote, $votes)) {
        $votes[$vote]++;
    }

    file_put_contents($file, serialize($votes));
    header("Location: index.php");
    exit();
}
?>
