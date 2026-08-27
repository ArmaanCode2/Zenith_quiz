<?php
session_start();

include 'db.php';

$qid = $_POST['qid'];
$ans = $_POST['answer'];

$_SESSION['tie_answers'][$qid] = $ans;
$_SESSION['tie_index']++;

header("Location: tie_breaker.php");
exit;
