<?php

require("Database.php");

session_start();

$db = new Database();

function saveSession($db, $recordTime)
{
    $sessionId = session_id();
    $sql = "INSERT INTO sessions (`session_id`, `record_time`) VALUES ('$sessionId', '$recordTime')";
    $db->query($sql);
}

$recordTime = htmlspecialchars($_POST["time"]);

saveSession($db, $recordTime); // db is from Database.php
