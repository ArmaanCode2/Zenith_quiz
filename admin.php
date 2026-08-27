<?php


session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
]);

session_start();

include 'db.php';


if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin/login.php");
    exit;
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");


$sql = "
    SELECT
        r.user_name,
        r.score,
        r.total_questions,
        r.timestamp,
        GROUP_CONCAT(
            CONCAT(
                q.question_text,
                ' [Your Answer: ',
                IFNULL(res.selected_option, 'Not Answered'),
                ' / Correct: ',
                q.correct_option,
                ']'
            )
            SEPARATOR ' | '
        ) AS details
    FROM results r
    LEFT JOIN responses res
        ON r.user_name = res.user_name
    LEFT JOIN questions q
        ON res.question_id = q.id
    GROUP BY
        r.id,
        r.user_name,
        r.score,
        r.total_questions,
        r.timestamp
    ORDER BY
        r.score DESC,
        r.timestamp ASC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin - Quiz Report</title>

<style>

@import url('https:

*{
    box-sizing:border-box;
}

body{
    font-family:Poppins,Arial,sans-serif;
    background:#f5f7fb;
    margin:0;
    padding:20px;
}

.header{
    background:linear-gradient(135deg,#1d2671,#c33764);
    color:#fff;
    padding:20px;
    text-align:center;
    border-radius:12px;
    margin-bottom:20px;
}

.header a{
    color:#fff;
    text-decoration:none;
    font-weight:bold;
}

.container{
    max-width:1400px;
    margin:auto;
}

table{
    border-collapse:collapse;
    width:100%;
    background:#fff;
}

th,
td{
    border:1px solid #ccc;
    padding:10px;
    text-align:left;
    vertical-align:top;
}

th{
    background:#1d2671;
    color:#fff;
}

tr:nth-child(even){
    background:#fafafa;
}

.details{
    max-width:650px;
    line-height:1.6;
    word-break:break-word;
}

.no-results{
    text-align:center;
    padding:20px;
    color:#666;
}

.back{
    display:inline-block;
    margin-top:15px;
    padding:10px 18px;
    background:#fff;
    color:#1d2671 !important;
    border-radius:8px;
}

@media (max-width:900px){

    .container{
        overflow-x:auto;
    }

    table{
        min-width:1000px;
    }

}

</style>

</head>

<body>

<div class="header">

    <h2>Quiz Report - All Participants</h2>

    <a href="dashboard.php" class="back">
        ← Back to Dashboard
    </a>

</div>

<div class="container">

<table>

    <tr>

        <th>Participant Name</th>
        <th>Score</th>
        <th>Total Questions</th>
        <th>Details</th>
        <th>Attempted At</th>

    </tr>

    <?php if ($result && $result->num_rows > 0): ?>

        <?php while ($row = $result->fetch_assoc()): ?>

            <tr>

                <td>
                    <?= htmlspecialchars($row['user_name'], ENT_QUOTES, 'UTF-8') ?>
                </td>

                <td>
                    <strong><?= (int)$row['score'] ?></strong>
                </td>

                <td>
                    <?= (int)$row['total_questions'] ?>
                </td>

                <td class="details">

                    <?= nl2br(
                        htmlspecialchars(
                            $row['details'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        )
                    ) ?>

                </td>

                <td>
                    <?= htmlspecialchars($row['timestamp'], ENT_QUOTES, 'UTF-8') ?>
                </td>

            </tr>

        <?php endwhile; ?>

    <?php else: ?>

        <tr>

            <td colspan="5" class="no-results">
                No results found.
            </td>

        </tr>

    <?php endif; ?>

</table>

</div>

</body>
</html>