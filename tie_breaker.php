<?php

session_start();

include 'db.php';

if(!isset($_SESSION['tie_questions'])){
    $res = $conn->query("SELECT * FROM tie_questions ORDER BY RAND()");
    $_SESSION['tie_questions'] = $res->fetch_all(MYSQLI_ASSOC);
    $_SESSION['tie_index'] = 0;
    $_SESSION['tie_answers'] = [];
}

$qIndex = $_SESSION['tie_index'];
$total = count($_SESSION['tie_questions']);

if ($qIndex >= $total) {
    header("Location: tie_submit.php"); 
    exit;
}

$question = $_SESSION['tie_questions'][$qIndex];

?>

<!DOCTYPE html>
<html>
<head>
<title>TIE BREAKER</title>
<style>
body{
    font-family:Poppins,Arial;
    background:linear-gradient(135deg,#1d2671,#c33764);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}
.box{
    background:#fff;
    width:650px;
    padding:30px;
    border-radius:20px;
}
#timer{color:red;font-weight:bold;text-align:right;}
button{
    background:#c33764;color:#fff;
    padding:10px 25px;border:none;
    border-radius:8px;font-size:16px;
}
</style>

<script>
let time = 300; // 5 minutes
setInterval(()=>{
    let m = Math.floor(time/60);
    let s = time%60;
    document.getElementById("timer").innerHTML = m+"m "+s+"s";
    time--;
    if(time<0) document.getElementById("quizForm").submit();
},1000);
</script>
</head>

<body>
<div class="box">
<h2 style="text-align:center;">🔥 TIE BREAKER ROUND 🔥</h2>
<div id="timer"></div>

<form method="post" action="tie_next.php" id="quizForm">
    <h3>Q<?= $qIndex+1 ?>. <?= $question['question_text'] ?></h3>

    <?php foreach(['A','B','C','D'] as $o): ?>
        <label>
            <input type="radio" name="answer" value="<?= $o ?>" required>
            <?= $question['option_'.strtolower($o)] ?>
        </label><br>
    <?php endforeach; ?>

    <input type="hidden" name="qid" value="<?= $question['id'] ?>">

    <br>
    <button type="submit">
        <?= ($qIndex+1 == count($_SESSION['tie_questions'])) ? "Submit Tie Breaker" : "Next →" ?>
    </button>
</form>
</div>
</body>
</html>
