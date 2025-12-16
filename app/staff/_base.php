<?php

require '../db.php';

function req_trim($key) {
    return isset($_REQUEST[$key]) ? trim($_REQUEST[$key]) : null;
}

?>
