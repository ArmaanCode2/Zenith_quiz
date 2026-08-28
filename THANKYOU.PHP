<?php

session_start();

$teamName =
    $_SESSION['submitted_team']
    ?? '';

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Quiz Submitted</title>

<style>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

body{

    font-family:'Poppins',sans-serif;

    background: #232b2b;

    display:flex;

    justify-content:center;

    align-items:center;

    min-height:100vh;

    margin:0;

    padding:20px;

}

.message-box{

    background:#fff;

    padding:50px;

    border-radius:20px;

    box-shadow:
        0 25px 50px rgba(0,0,0,0.25);

    text-align:center;

    max-width:600px;

    width:100%;

    animation:fadeIn 1s ease-in-out;

}

.message-box h2{

    color:#1d2671;

    margin-bottom:20px;

    font-size:28px;

}

.message-box p{

    font-size:18px;

    color:#444;

    line-height:1.6;

}

.suspense{

    color:#c33764;

    font-weight:700;

    font-size:20px;

    margin-top:20px;

    animation:blink 1.2s infinite;

}

@keyframes fadeIn{

    0%{

        opacity:0;

        transform:translateY(-20px);

    }

    100%{

        opacity:1;

        transform:translateY(0);

    }

}

@keyframes blink{

    0%,50%,100%{

        opacity:1;

    }

    25%,75%{

        opacity:0;

    }

}

</style>

</head>


<body>

<div class="message-box">

    <h2>
        Quiz Submitted Successfully ✅
    </h2>


    <?php if ($teamName !== ''): ?>

        <p>

            Thank you for participating,

            <b>
                <?= htmlspecialchars(
                    $teamName,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </b>!

            Your responses have been recorded safely.

        </p>

    <?php else: ?>

        <p>
            Your quiz response has been recorded safely.
        </p>

    <?php endif; ?>


    <p class="suspense">

        The results will be revealed soon…

        Keep your eyes glued to our
        <b>Instagram page</b>
        for the big announcement! 📣

    </p>


    <p>

        Who will emerge as the champion?

        The suspense is real… 👀🔥

    </p>

</div>

</body>

</html>