<?php

require("Database.php");

session_start();

const SETTINGS_TEST_MODE = 'test_mode';
const SETTINGS_NORMAL_SPEED = 'normal_speed';
const SETTINGS_TURBO_SPEED = 'turbo_speed';

$db = new Database();

function getAllSettings($db)
{
    $settings = [];
    $result = $db->query("SELECT * FROM settings");
    while ($row = $result->fetch_assoc()) {
        $settings[$row['name']] = $row['content'];
    }

    return $settings;
}

$allSettings = getAllSettings($db);

function mySessionsRecords($db)
{
    $session_id = session_id();
    $mySessionRecords = [];
    $result = $db->query("SELECT * FROM sessions WHERE `session_id` = '$session_id' ORDER BY record_time ASC LIMIT 5");
    while ($row = $result->fetch_assoc()) {
        $mySessionRecords[] = $row['record_time'];
    }
    return $mySessionRecords;
}

$mySessionRecords = mySessionsRecords($db);