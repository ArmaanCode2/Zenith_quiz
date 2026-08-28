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

    header('Content-Type: application/json; charset=utf-8');

    echo json_encode([
        'success' => $success,
        'message' => $message,
        'redirect' => $redirect
    ]);

    exit;
}



if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: index.php");

    exit;
}



if (
    !isset($_SESSION['quiz_active']) ||
    $_SESSION['quiz_active'] !== true ||
    !isset($_SESSION['questions']) ||
    !isset($_SESSION['quiz_end_time']) ||
    !isset($_SESSION['submission_token'])
) {

    
    if (
        isset($_SESSION['quiz_submitted']) &&
        $_SESSION['quiz_submitted'] === true
    ) {

        jsonResponse(
            true,
            "Quiz already submitted.",
            "thankyou.php"
        );
    }


    jsonResponse(
        false,
        "This quiz attempt is no longer active."
    );
}



$csrfToken =
    $_POST['csrf_token'] ?? '';

if (
    empty($_SESSION['quiz_csrf_token']) ||
    !is_string($csrfToken) ||
    !hash_equals(
        $_SESSION['quiz_csrf_token'],
        $csrfToken
    )
) {

    jsonResponse(
        false,
        "Invalid quiz request."
    );
}



$submissionToken =
    $_POST['submission_token'] ?? '';

if (
    !is_string($submissionToken) ||
    !preg_match(
        '/^[a-f0-9]{64}$/',
        $submissionToken
    ) ||
    !hash_equals(
        $_SESSION['submission_token'],
        $submissionToken
    )
) {

    jsonResponse(
        false,
        "Invalid submission."
    );
}



try {

    $existingStmt =
        $conn->prepare("
            SELECT id
            FROM results
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

    $alreadySubmitted =
        $existingResult->num_rows > 0;

    $existingStmt->close();


    if ($alreadySubmitted) {

        $_SESSION['quiz_submitted'] = true;
        $_SESSION['quiz_active'] = false;

        jsonResponse(
            true,
            "Quiz already saved successfully.",
            "thankyou.php"
        );
    }

} catch (Throwable $e) {

    
    jsonResponse(
        false,
        "The quiz server could not be reached. Please retry."
    );
}



$user_name =
    trim($_POST['user_name'] ?? '');

if ($user_name === '') {

    jsonResponse(
        false,
        "Team name is required."
    );
}

if (mb_strlen($user_name) > 100) {

    jsonResponse(
        false,
        "Team name is too long."
    );
}



$answers =
    $_POST['answer'] ?? [];

if (!is_array($answers)) {
    $answers = [];
}



$timeExpired =
    time() > (int)$_SESSION['quiz_end_time'];



$validQuestions = [];

foreach (
    $_SESSION['questions']
    as $question
) {

    $validQuestions[
        (int)$question['id']
    ] = $question;
}


$total_questions =
    count($validQuestions);

$score = 0;



foreach (
    $answers
    as $q_id => $selected
) {

    $q_id = (int)$q_id;


    if (
        !isset($validQuestions[$q_id])
    ) {

        continue;

    }


    if (
        !is_string($selected) ||
        !in_array(
            $selected,
            ['A', 'B', 'C', 'D'],
            true
        )
    ) {

        continue;

    }


    $correctOption =
        $validQuestions[$q_id]['correct_option'];


    if (
        $selected === $correctOption
    ) {

        $score++;

    }
}



try {

    $conn->begin_transaction();


    
    $existingStmt =
        $conn->prepare("
            SELECT id
            FROM results
            WHERE submission_token = ?
            LIMIT 1
            FOR UPDATE
        ");

    $existingStmt->bind_param(
        "s",
        $submissionToken
    );

    $existingStmt->execute();

    $existingResult =
        $existingStmt->get_result();


    if ($existingResult->num_rows > 0) {

        $existingStmt->close();

        $conn->commit();

        $_SESSION['quiz_submitted'] = true;
        $_SESSION['quiz_active'] = false;

        jsonResponse(
            true,
            "Quiz already saved successfully.",
            "thankyou.php"
        );
    }

    $existingStmt->close();


    
    $responseStmt =
        $conn->prepare("
            INSERT INTO responses
                (
                    user_name,
                    question_id,
                    selected_option,
                    is_correct
                )
            VALUES
                (?, ?, ?, ?)
        ");


    foreach (
        $answers
        as $q_id => $selected
    ) {

        $q_id = (int)$q_id;


        if (
            !isset($validQuestions[$q_id])
        ) {

            continue;

        }


        if (
            !is_string($selected) ||
            !in_array(
                $selected,
                ['A', 'B', 'C', 'D'],
                true
            )
        ) {

            continue;

        }


        $correctOption =
            $validQuestions[$q_id]['correct_option'];


        $isCorrect =
            ($selected === $correctOption)
            ? 1
            : 0;


        $responseStmt->bind_param(
            "sisi",
            $user_name,
            $q_id,
            $selected,
            $isCorrect
        );


        $responseStmt->execute();

    }


    $responseStmt->close();


    
    $resultStmt =
        $conn->prepare("
            INSERT INTO results
                (
                    user_name,
                    score,
                    total_questions,
                    submission_token
                )
            VALUES
                (?, ?, ?, ?)
        ");


    $resultStmt->bind_param(
        "siis",
        $user_name,
        $score,
        $total_questions,
        $submissionToken
    );


    $resultStmt->execute();

    $resultStmt->close();


    
    $conn->commit();


} catch (Throwable $e) {

    
    try {

        $conn->rollback();

    } catch (Throwable $rollbackError) {

        

    }


    
    jsonResponse(
        false,
        "Your answers could not be confirmed by the server. Retrying..."
    );
}



$_SESSION['quiz_submitted'] = true;

$_SESSION['quiz_active'] = false;

$_SESSION['submitted_team'] = $user_name;

$_SESSION['submission_time'] = time();



unset(
    $_SESSION['questions'],
    $_SESSION['option_orders'],
    $_SESSION['quiz_start_time'],
    $_SESSION['quiz_end_time'],
    $_SESSION['quiz_csrf_token'],
    $_SESSION['submission_token']
);



jsonResponse(
    true,
    $timeExpired
        ? "Time expired. Your answered questions were saved."
        : "Quiz submitted successfully.",
    "thankyou.php"
);