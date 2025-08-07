<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../includes/db.php';
include '../includes/auth.php';
checkLogin();

// ✅ Allow only admin users
if ($_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Fetch total bookings
$result = $conn->query("SELECT COUNT(*) AS total_bookings FROM bookings");
$row = $result->fetch_assoc();
$total_bookings = $row['total_bookings'] ?? 0;

// Fetch recent bookings with user and flight info
$sql = "SELECT b.id AS booking_id, u.name AS user_name, f.airline, f.from_city, f.to_city, f.flight_date, f.flight_time, b.payment_status
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN flights f ON b.flight_id = f.id
        ORDER BY b.id DESC
        LIMIT 10";

$bookings = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Admin Dashboard</h1>
    <p>Total Bookings: <?php echo $total_bookings; ?></p>

    <h2>Recent Bookings</h2>
    <?php if ($bookings && $bookings->num_rows > 0): ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>User Name</th>
                    <th>Airline</th>
                    <th>Route</th>
                    <th>Flight Date</th>
                    <th>Flight Time</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $bookings->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['booking_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['airline']); ?></td>
                        <td><?php echo htmlspecialchars($row['from_city'] . " → " . $row['to_city']); ?></td>
                        <td><?php echo htmlspecialchars($row['flight_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['flight_time']); ?></td>
                        <td><?php echo htmlspecialchars($row['payment_status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No bookings found.</p>
    <?php endif; ?>
</body>
</html>
