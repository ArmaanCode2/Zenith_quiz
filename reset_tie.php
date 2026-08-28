<?php



session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
]);

session_start();



if (
    !isset($_SESSION['admin']) ||
    $_SESSION['admin'] !== true
) {

    header(
        "Location: tie_start.php"
    );

    exit;
}



unset(
    $_SESSION['tie_questions'],
    $_SESSION['tie_index'],
    $_SESSION['tie_answers'],
    $_SESSION['tie_team'],
    $_SESSION['tie_start_time'],
    $_SESSION['tie_end_time'],
    $_SESSION['tie_csrf_token'],
    $_SESSION['tie_submission_token'],
    $_SESSION['tie_active'],
    $_SESSION['tie_submitted'],
    $_SESSION['tie_completed_team']
);



header(
    "Location: tie_start.php"
);

exit;