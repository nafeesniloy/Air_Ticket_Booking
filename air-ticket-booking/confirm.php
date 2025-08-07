<?php
session_start();
include 'includes/db.php';
include 'includes/auth.php';
checkLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['flight_id'])) {
    $user_id = $_SESSION['user_id'];
    $flight_id = intval($_POST['flight_id']);

    // Insert booking
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, flight_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $flight_id);

    if ($stmt->execute()) {
        $booking_id = $stmt->insert_id;

        // ✅ Redirect to payment page
        header("Location: payment.php?booking_id=" . $booking_id);
        exit();
    } else {
        $error = "Booking failed. Please try again.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!-- fallback HTML (rarely shown, just in case redirect fails) -->
<!DOCTYPE html>
<html>
<head>
    <title>Booking Failed</title>
</head>
<body>
<h2><?php echo $error ?? "Invalid request."; ?></h2>
<a href="index.php">Back to Home</a>
</body>
</html>
