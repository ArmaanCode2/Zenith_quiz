<?php
session_start();

include 'db.php';

/* ===== FETCH & SHUFFLE QUESTIONS (ONCE PER SESSION) ===== */
if (!isset($_SESSION['questions'])) {
    $result = $conn->query("SELECT * FROM questions");
    $questions = [];

    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }

    shuffle($questions);
    $_SESSION['questions'] = $questions;
} else {
    $questions = $_SESSION['questions'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>College Quiz</title>

<!-- ===== STYLES ===== -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

* { box-sizing: border-box; }

body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #1d2671, #c33764);
    min-height: 100vh;
    padding: 30px;
}

.quiz-container {
    max-width: 900px;
    margin: auto;
    background: #ffffff;
    padding: 30px;
    border-radius: 18px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.25);
    animation: fadeIn 0.6s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.quiz-header {
    text-align: center;
    margin-bottom: 20px;
}

.quiz-header h2 {
    margin: 0;
    font-weight: 700;
    color: #1d2671;
}

.quiz-header h3 {
    margin-top: 5px;
    color: #444;
    font-weight: 500;
}

#timer {
    background: #c33764;
    color: #fff;
    padding: 10px 20px;
    border-radius: 25px;
    font-weight: 600;
    width: fit-content;
    margin: 15px auto 25px;
    box-shadow: 0 8px 18px rgba(195,55,100,0.4);
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.team-box {
    text-align: center;
    margin-bottom: 30px;
}

.team-box input {
    padding: 12px 20px;
    width: 70%;
    border-radius: 30px;
    border: 2px solid #1d2671;
    font-size: 16px;
    outline: none;
}

.question {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    border-left: 6px solid #1d2671;
    transition: 0.25s;
}

.question:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
}

.question strong {
    color: #1d2671;
    font-size: 17px;
}

.options label {
    display: block;
    padding: 10px 14px;
    margin-top: 10px;
    background: #ffffff;
    border-radius: 8px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: 0.25s;
}

.options label:hover {
    border-color: #c33764;
    background: #fff0f5;
}

.options input {
    margin-right: 10px;
    accent-color: #c33764;
}

input[type=submit] {
    display: block;
    margin: 30px auto 10px;
    padding: 14px 45px;
    font-size: 18px;
    font-weight: 600;
    border-radius: 30px;
    border: none;
    color: #fff;
    background: linear-gradient(135deg, #1d2671, #c33764);
    cursor: pointer;
    box-shadow: 0 10px 25px rgba(29,38,113,0.4);
    transition: 0.25s;
}

input[type=submit]:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 35px rgba(29,38,113,0.5);
}
</style>


<!-- ===== TIMER SCRIPT ===== -->
<script>
const QUIZ_DURATION = 20 * 60; // 20 minutes in seconds
const STORAGE_KEY = "quiz_timer_end";

let endTime = localStorage.getItem(STORAGE_KEY);

if (!endTime) {
    endTime = Date.now() + QUIZ_DURATION * 1000;
    localStorage.setItem(STORAGE_KEY, endTime);
} else {
    endTime = parseInt(endTime);
}

/* ===== TIMER LOOP ===== */
function startTimer() {
    const timer = document.getElementById("timer");

    const interval = setInterval(() => {
        const remaining = Math.floor((endTime - Date.now()) / 1000);

        if (remaining <= 0) {
            clearInterval(interval);
            localStorage.removeItem(STORAGE_KEY);
            timer.innerHTML = "0m : 00s";
            alert("Time is up! Submitting quiz...");
            document.getElementById("quizForm").submit();
            return;
        }

        const m = Math.floor(remaining / 60);
        const s = remaining % 60;
        timer.innerHTML = `${m}m : ${s < 10 ? "0" : ""}${s}s`;

    }, 1000);
}

window.onload = startTimer;
</script>
<!-- ===== TIMER SCRIPT ===== -->



</head>

<body>

<div class="quiz-container">

    <div class="quiz-header">
        <h2>SACCM ZENITH CS CLUB</h2>
        <h3>CASE FILES: CAMPUS EDITION (<b>PRELIMS ROUND</b>)</h3>
    </div>

    <div id="timer"></div>

    <form method="post" action="submit.php" id="quizForm">

        <div class="team-box">
            <input type="text" name="user_name" placeholder="Enter Your Team Name" required>
        </div>

        <?php
        foreach ($questions as $index => $q):
            $options = [
                "A" => $q['option_a'],
                "B" => $q['option_b'],
                "C" => $q['option_c'],
                "D" => $q['option_d']
            ];
            $keys = array_keys($options);
            shuffle($keys);
        ?>

        <div class="question">
            <strong>
                Q<?= $index + 1 ?>.
                <?= htmlspecialchars($q['question_text']) ?>
            </strong>

            <div class="options">
                <?php foreach ($keys as $i => $k): ?>
                <label>
                    <input type="radio"
                           name="answer[<?= $q['id'] ?>]"
                           value="<?= $k ?>"
                           <?= $i == 0 ? 'required' : '' ?>>
                    <?= htmlspecialchars($options[$k]) ?>
                </label>
                <?php endforeach; ?>
            </div>
        </div>

        <?php endforeach; ?>

        <input type="submit" value="Submit Quiz">

    </form>
</div>

</body>
</html>
