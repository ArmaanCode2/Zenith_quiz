<?php



session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
]);

session_start();

include 'db.php';



if (
    !isset($_SESSION['tie_active']) ||
    $_SESSION['tie_active'] !== true ||
    !isset($_SESSION['tie_questions']) ||
    !isset($_SESSION['tie_index']) ||
    !isset($_SESSION['tie_end_time']) ||
    !isset($_SESSION['tie_submission_token'])
) {
    header("Location: tie_start.php");
    exit;
}



if (
    isset($_SESSION['tie_submitted']) &&
    $_SESSION['tie_submitted'] === true
) {
    header("Location: tie_thankyou.php");
    exit;
}



$qIndex = (int)$_SESSION['tie_index'];

$total = count($_SESSION['tie_questions']);



if ($qIndex >= $total) {

    header("Location: tie_submit.php");
    exit;
}



$remainingSeconds = max(
    0,
    (int)$_SESSION['tie_end_time'] - time()
);



$question =
    $_SESSION['tie_questions'][$qIndex];



$currentQuestionId =
    (int)$question['id'];



$storageKey =
    "tie_quiz_backup_" .
    $_SESSION['tie_submission_token'];



$csrfToken =
    $_SESSION['tie_csrf_token'];

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

#timer{
    color:red;
    font-weight:bold;
    text-align:right;
}

button{
    background:#c33764;
    color:#fff;
    padding:10px 25px;
    border:none;
    border-radius:8px;
    font-size:16px;
}

button:disabled{
    opacity:0.7;
    cursor:not-allowed;
}

#connectionStatus{
    display:none;
    margin:15px 0;
    padding:10px;
    border-radius:8px;
    background:#fff3cd;
    color:#664d03;
    text-align:center;
    font-weight:bold;
}

</style>

<script>



const TIE_STORAGE_KEY =
    <?= json_encode($storageKey) ?>;

const CURRENT_QUESTION_ID =
    <?= (int)$currentQuestionId ?>;

const CSRF_TOKEN =
    <?= json_encode($csrfToken) ?>;

let remainingSeconds =
    <?= (int)$remainingSeconds ?>;

let timerInterval = null;

let submitting = false;

let autoSubmitting = false;

let retryCount = 0;

let retryTimer = null;



function saveTieBackup() {

    const form =
        document.getElementById("quizForm");

    if (!form) {
        return;
    }


    let backup = {
        team_name:
            <?= json_encode($_SESSION['tie_team']) ?>,

        answers: {},

        saved_at: Date.now()
    };


    
    try {

        const existing =
            localStorage.getItem(
                TIE_STORAGE_KEY
            );

        if (existing) {

            const parsed =
                JSON.parse(existing);

            if (
                parsed &&
                parsed.answers
            ) {

                backup.answers =
                    parsed.answers;

            }

        }

    } catch (error) {

        console.warn(
            "Could not read tie backup:",
            error
        );

    }


    
    const selected =
        form.querySelector(
            'input[name="answer"]:checked'
        );


    if (selected) {

        backup.answers[
            String(CURRENT_QUESTION_ID)
        ] = selected.value;

    }


    
    try {

        localStorage.setItem(
            TIE_STORAGE_KEY,
            JSON.stringify(backup)
        );

    } catch (error) {

        console.warn(
            "Could not save tie backup:",
            error
        );

    }
}



function restoreTieBackup() {

    let raw;

    try {

        raw =
            localStorage.getItem(
                TIE_STORAGE_KEY
            );

    } catch (error) {

        return;

    }


    if (!raw) {
        return;
    }


    try {

        const backup =
            JSON.parse(raw);

        if (
            !backup ||
            !backup.answers
        ) {
            return;
        }


        const answer =
            backup.answers[
                String(CURRENT_QUESTION_ID)
            ];


        if (!answer) {
            return;
        }


        const radio =
            document.querySelector(
                `input[name="answer"][value="${CSS.escape(answer)}"]`
            );


        if (radio) {

            radio.checked = true;

        }

    } catch (error) {

        console.warn(
            "Could not restore tie backup:",
            error
        );

    }
}



function showStatus(message) {

    const status =
        document.getElementById(
            "connectionStatus"
        );

    status.style.display = "block";

    status.textContent = message;
}


function hideStatus() {

    const status =
        document.getElementById(
            "connectionStatus"
        );

    status.style.display = "none";
}



async function submitCurrentAnswer() {

    if (submitting) {
        return;
    }


    const form =
        document.getElementById("quizForm");


    const selected =
        form.querySelector(
            'input[name="answer"]:checked'
        );


    if (!selected) {

        alert(
            "Please select an answer."
        );

        return;

    }


    
    saveTieBackup();


    submitting = true;

    retryCount = 0;


    const formData =
        new FormData(form);


    await sendNextRequest(formData);
}



async function sendNextRequest(formData) {

    try {

        const response =
            await fetch(
                "tie_next.php",
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
                "HTTP " + response.status
            );

        }


        const result =
            await response.json();


        if (result.success === true) {

            
            hideStatus();

            window.location.href =
                result.redirect;

            return;

        }


        throw new Error(
            result.message ||
            "The server could not save the answer."
        );


    } catch (error) {

        retryCount++;


        
        if (retryCount <= 5) {

            const delay =
                Math.min(
                    2000 *
                    Math.pow(
                        2,
                        retryCount - 1
                    ),
                    10000
                );


            showStatus(
                "Connection problem. Your answer is saved on this device. " +
                `Retrying in ${Math.ceil(delay / 1000)} seconds...`
            );


            clearTimeout(retryTimer);


            retryTimer =
                setTimeout(
                    function () {

                        sendNextRequest(
                            formData
                        );

                    },
                    delay
                );


            return;
        }


        
        submitting = false;


        showStatus(
            "Unable to contact the quiz server. " +
            "Your answer is still saved on this device. " +
            "Please press Next again."
        );

    }

}



function startTimer() {

    const timer =
        document.getElementById("timer");


    function updateTimer() {

        if (remainingSeconds <= 0) {

            clearInterval(timerInterval);

            timer.innerHTML =
                "0m 0s";


            if (!autoSubmitting) {

                autoSubmitting = true;

                saveTieBackup();


                showStatus(
                    "Time is up. Saving your answers..."
                );


                
                const form =
                    document.getElementById(
                        "quizForm"
                    );


                const selected =
                    form.querySelector(
                        'input[name="answer"]:checked'
                    );


                if (selected) {

                    
                    submitCurrentAnswer();

                } else {

                    
                    window.location.href =
                        "tie_submit.php";

                }

            }

            return;
        }


        const m =
            Math.floor(
                remainingSeconds / 60
            );


        const s =
            remainingSeconds % 60;


        timer.innerHTML =
            m +
            "m " +
            (s < 10 ? "0" : "") +
            s +
            "s";


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

        restoreTieBackup();

        startTimer();

    }
);



document.addEventListener(
    "change",
    function (event) {

        if (
            event.target.matches(
                'input[name="answer"]'
            )
        ) {

            saveTieBackup();

        }

    }
);



document.addEventListener(
    "DOMContentLoaded",
    function () {

        const form =
            document.getElementById(
                "quizForm"
            );


        form.addEventListener(
            "submit",
            function (event) {

                event.preventDefault();

                submitCurrentAnswer();

            }
        );

    }
);



window.addEventListener(
    "beforeunload",
    function () {

        if (!submitting) {

            saveTieBackup();

        }

    }
);

</script>

</head>

<body>

<div class="box">

<h2 style="text-align:center;">
    🔥 TIE BREAKER ROUND 🔥
</h2>

<div id="timer"></div>

<div id="connectionStatus"></div>

<form
    method="post"
    action="tie_next.php"
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

    <h3>

        Q<?= $qIndex + 1 ?>.

        <?= htmlspecialchars(
            $question['question_text'],
            ENT_QUOTES,
            'UTF-8'
        ) ?>

    </h3>


    <?php foreach (
        ['A','B','C','D']
        as $o
    ): ?>

        <label>

            <input
                type="radio"
                name="answer"
                value="<?= $o ?>"
                required
            >

            <?= htmlspecialchars(
                $question[
                    'option_' .
                    strtolower($o)
                ],
                ENT_QUOTES,
                'UTF-8'
            ) ?>

        </label>

        <br>

    <?php endforeach; ?>


    <input
        type="hidden"
        name="qid"
        value="<?= (int)$question['id'] ?>"
    >


    <br>

    <button
        type="submit"
        id="nextButton"
    >

        <?= (
            $qIndex + 1 ===
            count($_SESSION['tie_questions'])
        )
            ? "Submit Tie Breaker"
            : "Next →"
        ?>

    </button>

</form>

</div>

</body>

</html>