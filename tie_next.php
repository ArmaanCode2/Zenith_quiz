<?php



session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
]);

session_start();

include 'db.php';


function jsonResponse(
    bool $success,
    string $message = '',
    string $redirect = ''
): void {

    header(
        'Content-Type: application/json; charset=utf-8'
    );

    echo json_encode([
        'success' => $success,
        'message' => $message,
        'redirect' => $redirect
    ]);

    exit;
}



if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: tie_breaker.php");
    exit;
}



if (
    !isset($_SESSION['tie_active']) ||
    $_SESSION['tie_active'] !== true ||
    !isset($_SESSION['tie_questions']) ||
    !isset($_SESSION['tie_index']) ||
    !isset($_SESSION['tie_end_time'])
) {

    jsonResponse(
        false,
        "Tie breaker is no longer active."
    );
}



$csrfToken =
    $_POST['csrf_token'] ?? '';

if (
    empty($_SESSION['tie_csrf_token']) ||
    !is_string($csrfToken) ||
    !hash_equals(
        $_SESSION['tie_csrf_token'],
        $csrfToken
    )
) {

    jsonResponse(
        false,
        "Invalid tie breaker request."
    );
}



$timeExpired =
    time() >
    (int)$_SESSION['tie_end_time'];



$currentIndex =
    (int)$_SESSION['tie_index'];

$total =
    count($_SESSION['tie_questions']);


if ($currentIndex >= $total) {

    jsonResponse(
        true,
        "Tie breaker complete.",
        "tie_submit.php"
    );
}


$currentQuestion =
    $_SESSION['tie_questions'][$currentIndex];

$expectedQid =
    (int)$currentQuestion['id'];



$qid =
    (int)($_POST['qid'] ?? 0);



if ($qid !== $expectedQid) {

    
    if (isset($_SESSION['tie_answers'][$qid])) {

        jsonResponse(
            true,
            "Answer already saved.",
            "tie_breaker.php"
        );
    }


    jsonResponse(
        false,
        "Invalid question submission."
    );
}



$answer =
    $_POST['answer'] ?? '';


if (
    !is_string($answer) ||
    !in_array(
        $answer,
        ['A','B','C','D'],
        true
    )
) {

    jsonResponse(
        false,
        "Invalid answer."
    );
}



if (
    isset($_SESSION['tie_answers'][$qid])
) {

    
    $_SESSION['tie_index'] =
        max(
            $_SESSION['tie_index'],
            $currentIndex + 1
        );

} else {

    
    $_SESSION['tie_answers'][$qid] =
        $answer;


    
    $_SESSION['tie_index'] =
        $currentIndex + 1;
}



if (
    $_SESSION['tie_index'] >= $total
) {

    jsonResponse(
        true,
        $timeExpired
            ? "Time expired."
            : "Answer saved.",
        "tie_submit.php"
    );
}



jsonResponse(
    true,
    "Answer saved.",
    "tie_breaker.php"
);