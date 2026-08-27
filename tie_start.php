<?php



session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
]);

session_start();

include 'db.php';

const TIE_DURATION = 5 * 60; 



if (
    isset($_SESSION['tie_active']) &&
    $_SESSION['tie_active'] === true
) {
    header("Location: tie_breaker.php");
    exit;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $team_name = trim($_POST['team_name'] ?? '');

    if ($team_name === '') {
        die("Team name is required.");
    }

    if (mb_strlen($team_name) > 100) {
        die("Team name is too long.");
    }


    
    $res = $conn->query("
        SELECT
            id,
            question_text,
            option_a,
            option_b,
            option_c,
            option_d,
            correct_option
        FROM tie_questions
        ORDER BY RAND()
    ");

    if (!$res) {
        die("Unable to load tie breaker questions.");
    }

    $questions = $res->fetch_all(MYSQLI_ASSOC);

    if (count($questions) === 0) {
        die("No tie breaker questions are available.");
    }


    
    $_SESSION['tie_questions'] = $questions;
    $_SESSION['tie_index'] = 0;
    $_SESSION['tie_answers'] = [];
    $_SESSION['tie_team'] = $team_name;


    
    $_SESSION['tie_start_time'] = time();

    $_SESSION['tie_end_time'] =
        $_SESSION['tie_start_time'] + TIE_DURATION;


    
    $_SESSION['tie_active'] = true;

    unset($_SESSION['tie_submitted']);


    $_SESSION['tie_submission_token'] =
        bin2hex(random_bytes(32));


    $_SESSION['tie_csrf_token'] =
        bin2hex(random_bytes(32));
    header("Location: tie_breaker.php");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Tie Breaker Entry</title>

<style>

body{
    background:linear-gradient(135deg,#1d2671,#c33764);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:Poppins;
}

.box{
    background:#fff;
    padding:30px;
    border-radius:20px;
    width:400px;
    text-align:center;
}

input{
    width:100%;
    padding:12px;
    margin:15px 0;
    border-radius:8px;
    border:1px solid #ccc;
}

button{
    background:#c33764;
    color:#fff;
    padding:12px 30px;
    border:none;
    border-radius:10px;
    font-size:16px;
}

</style>

</head>

<body>

<div class="box">

<h2>🔥 Tie Breaker Round 🔥</h2>

<p>Enter your <b>Team Name</b> to begin</p>

<form method="post">

    <input
        type="text"
        name="team_name"
        placeholder="Team Name"
        maxlength="100"
        autocomplete="off"
        required
    >

    <button type="submit">
        Start Tie Breaker
    </button>

</form>

</div>

</body>

</html>