<?php
    session_start();

    unset($_SESSION['tie_questions'], $_SESSION['tie_index'], $_SESSION['tie_answers'], $_SESSION['tie_team'], $_SESSION['tie_start_time']);

    header("Location: tie_breaker.php");
    exit;
?>