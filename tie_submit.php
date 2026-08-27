<?php
session_start();

include 'db.php';

$team = $_SESSION['tie_team'];
$answers = $_SESSION['tie_answers'];
$score = 0;

foreach($answers as $qid => $ans){
    $res = $conn->query("SELECT correct_option FROM tie_questions WHERE id=$qid");
    $row = $res->fetch_assoc();
    if($row['correct_option'] == $ans){
        $score++;
    }
}

$stmt = $conn->prepare("INSERT INTO tie_results (team_name, score) VALUES (?,?)");
$stmt->bind_param("si",$team,$score);
$stmt->execute();

/* Clear tie session */
unset($_SESSION['tie_questions'], $_SESSION['tie_index'], $_SESSION['tie_answers'], $_SESSION['tie_team'], $_SESSION['tie_start_time']);

header("Location: tie_thankyou.php");
exit;
