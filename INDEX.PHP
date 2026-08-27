<?php



session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
]);

session_start();

include 'db.php';

const QUIZ_DURATION = 20 * 60; 



if (
    isset($_SESSION['quiz_submitted']) &&
    $_SESSION['quiz_submitted'] === true
) {
    header("Location: THANKYOU.PHP");
    exit;
}



if (
    !isset($_SESSION['questions']) ||
    !isset($_SESSION['quiz_end_time']) ||
    !isset($_SESSION['submission_token'])
) {

    
    unset($_SESSION['quiz_submitted']);

    
    $result = $conn->query("
        SELECT
            id,
            question_text,
            option_a,
            option_b,
            option_c,
            option_d,
            correct_option
        FROM questions
        ORDER BY id ASC
    ");

    if (!$result) {
        http_response_code(503);
        die("Unable to load quiz questions.");
    }

    $questions = [];

    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }

    if (count($questions) === 0) {
        die("No quiz questions are available.");
    }


    
    shuffle($questions);

    $_SESSION['questions'] = $questions;


    
    $_SESSION['option_orders'] = [];

    foreach ($questions as $q) {

        $keys = ['A', 'B', 'C', 'D'];

        shuffle($keys);

        $_SESSION['option_orders'][$q['id']] = $keys;
    }


    
    $_SESSION['quiz_start_time'] = time();

    $_SESSION['quiz_end_time'] =
        $_SESSION['quiz_start_time'] + QUIZ_DURATION;


    
    $_SESSION['quiz_active'] = true;

    unset($_SESSION['quiz_submitted']);


    
    $_SESSION['submission_token'] = bin2hex(random_bytes(32));


    
    $_SESSION['quiz_csrf_token'] = bin2hex(random_bytes(32));
}



$questions = $_SESSION['questions'];

$serverEndTime = (int)$_SESSION['quiz_end_time'];

$remainingSeconds = max(
    0,
    $serverEndTime - time()
);

$csrfToken = $_SESSION['quiz_csrf_token'];

$submissionToken = $_SESSION['submission_token'];



$storageKey = "quiz_backup_" . $submissionToken;

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>College Quiz</title>


<style>

* {
    box-sizing: border-box;
}

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
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
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

#timer.warning {
    background: #d97706;
}

#timer.danger {
    background: #b91c1c;
    animation: none;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.05);
    }

    100% {
        transform: scale(1);
    }
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

.team-box input:focus {
    box-shadow: 0 0 0 3px rgba(29,38,113,0.12);
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

input[type=submit]:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

#connectionStatus {
    display: none;
    max-width: 700px;
    margin: 0 auto 20px;
    padding: 12px 16px;
    border-radius: 10px;
    text-align: center;
    font-weight: 600;
    background: #fff3cd;
    color: #664d03;
    border: 1px solid #ffecb5;
}

@media (max-width: 600px) {

    body {
        padding: 15px;
    }

    .quiz-container {
        padding: 20px;
    }

    .team-box input {
        width: 100%;
    }

    .quiz-header h2 {
        font-size: 21px;
    }

    .quiz-header h3 {
        font-size: 15px;
    }
}

</style>


<script>



const QUIZ_STORAGE_KEY =
    <?= json_encode($storageKey) ?>;

const QUIZ_SUBMISSION_TOKEN =
    <?= json_encode($submissionToken) ?>;

let remainingSeconds =
    <?= (int)$remainingSeconds ?>;

let timerInterval = null;

let submitting = false;

let autoSubmitStarted = false;

let retryTimer = null;



function saveQuizBackup() {

    const form = document.getElementById("quizForm");

    if (!form) {
        return;
    }

    const data = {
        team_name:
            form.querySelector('[name="user_name"]').value,

        answers: {},

        saved_at: Date.now()
    };


    
    form.querySelectorAll(
        'input[type="radio"][name^="answer["]:checked'
    ).forEach(function (radio) {

        const match =
            radio.name.match(/^answer\[(\d+)\]$/);

        if (!match) {
            return;
        }

        data.answers[match[1]] = radio.value;
    });


    try {

        localStorage.setItem(
            QUIZ_STORAGE_KEY,
            JSON.stringify(data)
        );

    } catch (error) {

        

        console.warn(
            "Quiz backup unavailable:",
            error
        );
    }
}



function restoreQuizBackup() {

    let raw;

    try {

        raw =
            localStorage.getItem(QUIZ_STORAGE_KEY);

    } catch (error) {

        return;
    }

    if (!raw) {
        return;
    }

    let data;

    try {

        data = JSON.parse(raw);

    } catch (error) {

        localStorage.removeItem(QUIZ_STORAGE_KEY);

        return;
    }


    const form =
        document.getElementById("quizForm");

    if (!form) {
        return;
    }


    
    const teamInput =
        form.querySelector('[name="user_name"]');

    if (
        teamInput &&
        typeof data.team_name === "string" &&
        data.team_name.length > 0
    ) {

        teamInput.value = data.team_name;
    }


    
    if (
        data.answers &&
        typeof data.answers === "object"
    ) {

        Object.entries(data.answers)
            .forEach(function ([questionId, answer]) {

                const selector =
                    `input[name="answer[${questionId}]"][value="${CSS.escape(answer)}"]`;

                const radio =
                    form.querySelector(selector);

                if (radio) {
                    radio.checked = true;
                }

            });
    }
}



function clearQuizBackup() {

    try {

        localStorage.removeItem(
            QUIZ_STORAGE_KEY
        );

    } catch (error) {
        console.warn(
            "Could not clear quiz backup:",
            error
        );
    }
}



function showConnectionStatus(message) {

    const status =
        document.getElementById("connectionStatus");

    if (!status) {
        return;
    }

    status.style.display = "block";

    status.textContent = message;
}



function hideConnectionStatus() {

    const status =
        document.getElementById("connectionStatus");

    if (!status) {
        return;
    }

    status.style.display = "none";
}



function disableQuizForSubmission() {

    const form =
        document.getElementById("quizForm");

    if (!form) {
        return;
    }

    form.querySelectorAll(
        'input[type="radio"], input[name="user_name"]'
    ).forEach(function (input) {

        input.disabled = true;

    });


    const submitButton =
        form.querySelector('input[type="submit"]');

    if (submitButton) {

        submitButton.disabled = true;

        submitButton.value =
            "Submitting...";
    }
}



async function submitQuiz(retryNumber = 0) {

    if (submitting) {
        return;
    }

    submitting = true;


    const form =
        document.getElementById("quizForm");


    
    saveQuizBackup();


    
    const formData =
        new FormData(form);


    
    try {

        const response =
            await fetch(
                "SUBMIT.PHP",
                {
                    method: "POST",
                    body: formData,
                    credentials: "same-origin",
                    cache: "no-store",
                    headers: {
                        "X-Requested-With":
                            "XMLHttpRequest"
                    }
                }
            );


        
        if (!response.ok) {

            throw new Error(
                `Server returned HTTP ${response.status}`
            );
        }


        
        const result =
            await response.json();


        
        if (result.success === true) {

            clearQuizBackup();

            window.location.href =
                result.redirect;

            return;
        }


        
        throw new Error(
            result.message ||
            "The server could not confirm submission."
        );


    } catch (error) {

        submitting = false;


        
        const maxRetries = 5;


        if (retryNumber < maxRetries) {

            const delay =
                Math.min(
                    2000 * Math.pow(2, retryNumber),
                    15000
                );


            showConnectionStatus(
                "Connection problem. " +
                "Your answers are saved on this device. " +
                `Retrying in ${Math.ceil(delay / 1000)} seconds...`
            );


            clearTimeout(retryTimer);


            retryTimer =
                setTimeout(function () {

                    submitQuiz(
                        retryNumber + 1
                    );

                }, delay);


            return;
        }


        
        showConnectionStatus(
            "We could not contact the quiz server. " +
            "YOUR ANSWERS ARE STILL SAVED ON THIS DEVICE. " +
            "Please stay on this page and try Submit again."
        );


        const submitButton =
            form.querySelector('input[type="submit"]');

        if (submitButton) {

            submitButton.disabled = false;

            submitButton.value =
                "Submit Quiz";
        }
    }
}



function startTimer() {

    const timer =
        document.getElementById("timer");


    function updateTimer() {

        
        if (remainingSeconds <= 0) {

            clearInterval(timerInterval);

            timer.innerHTML =
                "0m : 00s";

            timer.classList.add("danger");


            if (!autoSubmitStarted) {

                autoSubmitStarted = true;

                saveQuizBackup();

                showConnectionStatus(
                    "Time is up. Saving your answers..."
                );


                
                submitQuiz();
            }

            return;
        }


        const minutes =
            Math.floor(
                remainingSeconds / 60
            );

        const seconds =
            remainingSeconds % 60;


        timer.innerHTML =
            `${minutes}m : ${
                seconds < 10 ? "0" : ""
            }${seconds}s`;


        
        timer.classList.remove(
            "warning",
            "danger"
        );


        if (remainingSeconds <= 60) {

            timer.classList.add("danger");

        } else if (remainingSeconds <= 300) {

            timer.classList.add("warning");

        }


        remainingSeconds--;
    }


    updateTimer();

    timerInterval =
        setInterval(
            updateTimer,
            1000
        );
}



window.addEventListener(
    "load",
    function () {

        restoreQuizBackup();

        startTimer();

    }
);



document.addEventListener(
    "change",
    function (event) {

        if (
            event.target.matches(
                'input[type="radio"]'
            )
        ) {

            saveQuizBackup();

        }

    }
);



document.addEventListener(
    "input",
    function (event) {

        if (
            event.target.name === "user_name"
        ) {

            saveQuizBackup();

        }

    }
);



document.addEventListener(
    "DOMContentLoaded",
    function () {

        const form =
            document.getElementById("quizForm");

        form.addEventListener(
            "submit",
            function (event) {

                event.preventDefault();

                if (submitting) {
                    return;
                }

                
                saveQuizBackup();

                submitQuiz();

            }
        );

    }
);



window.addEventListener(
    "beforeunload",
    function (event) {

        if (!submitting) {

            saveQuizBackup();

            event.preventDefault();

            event.returnValue = "";

        }

    }
);

</script>

</head>


<body>

<div class="quiz-container">

    <div class="quiz-header">

        <h2>
            Computer Science department of SACCM
        </h2>

    </div>


    <div id="timer"></div>


    <div id="connectionStatus"></div>


    <form
        method="post"
        action="SUBMIT.PHP"
        id="quizForm"
    >

        <input
            type="hidden"
            name="csrf_token"
            value="<?= htmlspecialchars(
                $csrfToken,
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
        >


        <input
            type="hidden"
            name="submission_token"
            value="<?= htmlspecialchars(
                $submissionToken,
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
        >


        <div class="team-box">

            <input
                type="text"
                name="user_name"
                placeholder="Enter Your Team Name"
                maxlength="100"
                autocomplete="off"
                required
            >

        </div>


        <?php

        foreach (
            $questions
            as $index => $q
        ):

            $options = [

                "A" => $q['option_a'],

                "B" => $q['option_b'],

                "C" => $q['option_c'],

                "D" => $q['option_d']

            ];


            $keys =
                $_SESSION['option_orders'][$q['id']]
                ?? ['A', 'B', 'C', 'D'];

        ?>


        <div class="question">

            <strong>

                Q<?= $index + 1 ?>.

                <?= htmlspecialchars(
                    $q['question_text'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>

            </strong>


            <div class="options">

                <?php foreach (
                    $keys
                    as $i => $k
                ): ?>

                    <label>

                        <input
                            type="radio"
                            name="answer[<?= (int)$q['id'] ?>]"
                            value="<?= htmlspecialchars(
                                $k,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>"
                            <?= $i === 0 ? 'required' : '' ?>
                        >

                        <?= htmlspecialchars(
                            $options[$k],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>

                    </label>

                <?php endforeach; ?>

            </div>

        </div>


        <?php endforeach; ?>


        <input
            type="submit"
            value="Submit Quiz"
        >

    </form>

</div>

</body>
</html>