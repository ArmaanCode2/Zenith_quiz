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



if (
    isset($_SESSION['tie_submitted']) &&
    $_SESSION['tie_submitted'] === true
) {

    
    if (
        isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    ) {

        jsonResponse(
            true,
            "Tie breaker already submitted.",
            "tie_thankyou.php"
        );

    } else {

        header("Location: tie_thankyou.php");
        exit;

    }
}



if (
    !isset($_SESSION['tie_active']) ||
    $_SESSION['tie_active'] !== true ||
    !isset($_SESSION['tie_questions']) ||
    !isset($_SESSION['tie_answers']) ||
    !isset($_SESSION['tie_team']) ||
    !isset($_SESSION['tie_submission_token'])
) {

    if (
        isset($_SESSION['tie_submitted']) &&
        $_SESSION['tie_submitted'] === true
    ) {

        header("Location: tie_thankyou.php");
        exit;
    }


    die(
        "This tie breaker attempt is no longer active."
    );
}



$team =
    trim($_SESSION['tie_team']);

$answers =
    $_SESSION['tie_answers'];

$questions =
    $_SESSION['tie_questions'];

$submissionToken =
    $_SESSION['tie_submission_token'];


if ($team === '') {
    die("Invalid team.");
}



$questionMap = [];

foreach (
    $questions
    as $question
) {

    $questionMap[
        (int)$question['id']
    ] = $question;

}


$score = 0;

$totalQuestions =
    count($questionMap);



foreach (
    $answers
    as $qid => $answer
) {

    $qid =
        (int)$qid;


    if (
        !isset($questionMap[$qid])
    ) {
        continue;
    }


    if (
        !is_string($answer) ||
        !in_array(
            $answer,
            ['A','B','C','D'],
            true
        )
    ) {
        continue;
    }


    if (
        $answer ===
        $questionMap[$qid]['correct_option']
    ) {

        $score++;

    }
}



try {

    $conn->begin_transaction();


    
    $existingStmt =
        $conn->prepare("
            SELECT id
            FROM tie_results
            WHERE submission_token = ?
            LIMIT 1
        ");


    $existingStmt->bind_param(
        "s",
        $submissionToken
    );


    $existingStmt->execute();


    $existingResult =
        $existingStmt->get_result();


    if (
        $existingResult->num_rows > 0
    ) {

        $existingStmt->close();

        $conn->commit();


        $_SESSION['tie_submitted'] =
            true;

        $_SESSION['tie_active'] =
            false;


        if (
            isset(
                $_SERVER[
                    'HTTP_X_REQUESTED_WITH'
                ]
            )
        ) {

            jsonResponse(
                true,
                "Tie breaker already saved.",
                "tie_thankyou.php"
            );

        } else {

            header(
                "Location: tie_thankyou.php"
            );

            exit;
        }
    }


    $existingStmt->close();


    
    $stmt =
        $conn->prepare("
            INSERT INTO tie_results
                (
                    team_name,
                    score,
                    submission_token
                )
            VALUES
                (?, ?, ?)
        ");


    $stmt->bind_param(
        "sis",
        $team,
        $score,
        $submissionToken
    );


    $stmt->execute();


    $stmt->close();


    
    $conn->commit();


} catch (Throwable $e) {

    try {

        $conn->rollback();

    } catch (Throwable $rollbackError) {

        

    }


    
    if (
        isset(
            $_SERVER[
                'HTTP_X_REQUESTED_WITH'
            ]
        )
    ) {

        jsonResponse(
            false,
            "The tie breaker result could not be confirmed. Retrying..."
        );

    }


    die(
        "The tie breaker result could not be saved. Please try again."
    );
}



$_SESSION['tie_submitted'] =
    true;

$_SESSION['tie_active'] =
    false;



$_SESSION['tie_completed_team'] =
    $team;



unset(
    $_SESSION['tie_questions'],
    $_SESSION['tie_index'],
    $_SESSION['tie_answers'],
    $_SESSION['tie_team'],
    $_SESSION['tie_start_time'],
    $_SESSION['tie_end_time'],
    $_SESSION['tie_csrf_token'],
    $_SESSION['tie_submission_token']
);



if (
    isset(
        $_SERVER[
            'HTTP_X_REQUESTED_WITH'
        ]
    )
) {

    jsonResponse(
        true,
        "Tie breaker submitted successfully.",
        "tie_thankyou.php"
    );
}



header(
    "Location: tie_thankyou.php"
);

exit;