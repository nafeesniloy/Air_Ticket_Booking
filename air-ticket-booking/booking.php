<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'includes/db.php';
include 'includes/auth.php';
checkLogin();

$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';
$date = $_GET['date'] ?? '';

// Validate inputs (optional safety)
if (empty($from) || empty($to) || empty($date)) {
    die("Missing flight search parameters.");
}

// Prepare SQL to find flights on or after the searched date
$query = "SELECT * FROM flights WHERE from_city = ? AND to_city = ? AND flight_date >= ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sss", $from, $to, $date);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Flights</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .flight {
            border: 1px solid #ccc;
            padding: 15px;
            margin: 15px 0;
            border-radius: 10px;
            background: #f9f9f9;
        }
        .flight strong {
            font-size: 1.2em;
        }
    </style>
</head>
<body>

<h2>Available Flights</h2>

<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="flight">
            <p><strong><?php echo htmlspecialchars($row['airline']); ?></strong></p>
            <p><?php echo htmlspecialchars($row['from_city']); ?> → <?php echo htmlspecialchars($row['to_city']); ?></p>
            <p>
                <?php echo htmlspecialchars($row['flight_date']); ?> |
                <?php echo htmlspecialchars($row['flight_time']); ?> |
                BDT <?php echo htmlspecialchars($row['price']); ?>
            </p>
            <form method="POST" action="confirm.php">
                <input type="hidden" name="flight_id" value="<?php echo $row['id']; ?>">
                <button type="submit">Book Now</button>
            </form>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No flights found matching your search.</p>
<?php endif; ?>

</body>
</html>
