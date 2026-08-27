<?php

include 'db.php';

// Fetch results
$sql = "SELECT r.user_name, r.score, r.total_questions, r.timestamp,
            GROUP_CONCAT(CONCAT(q.question_text, ' [Your Answer: ', IFNULL(res.selected_option,''), ' / Correct: ', q.correct_option, ']') SEPARATOR '<br>') AS details
        FROM results r
        LEFT JOIN responses res ON r.user_name = res.user_name
        LEFT JOIN questions q ON res.question_id = q.id
        GROUP BY r.user_name, r.timestamp
        ORDER BY r.score DESC, r.timestamp ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Quiz Report</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        tr:nth-child(even) { background: #fafafa; }
    </style>
</head>
<body>
    <h2>Quiz Report - All Participants</h2>
    <table>
        <tr>
            <th>Participant Name</th>
            <th>Score</th>
            <th>Total Questions</th>
            <th>Details</th>
            <th>Attempted At</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                    <td><?php echo $row['score']; ?></td>
                    <td><?php echo $row['total_questions']; ?></td>
                    <td><?php echo $row['details']; ?></td>
                    <td><?php echo $row['timestamp']; ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">No results found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
