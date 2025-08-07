<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/db.php';
include 'includes/auth.php';
checkLogin();

$booking_id = intval($_GET['booking_id'] ?? 0);
if ($booking_id <= 0) {
    die("Invalid or missing booking ID.");
}

$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $method = trim($_POST['method'] ?? '');
    $txn_id = trim($_POST['txn_id'] ?? '');

    if (empty($method) || empty($txn_id)) {
        $error = "Please enter all fields.";
    } else {
        $stmt = $conn->prepare("UPDATE bookings SET payment_method = ?, transaction_id = ?, payment_status = 'Paid' WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("ssi", $method, $txn_id, $booking_id);
            if ($stmt->execute()) {
                // ✅ Redirect to thank you page
                header("Location: thank_you.php");
                exit();
            } else {
                $error = "❌ Database error while executing.";
            }
        } else {
            $error = "❌ Prepare failed: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Payment for Booking #<?php echo $booking_id; ?></h2>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Payment Method:</label>
        <select name="method" required>
            <option value="">Select Method</option>
            <option value="bKash">bKash</option>
            <option value="Nagad">Nagad</option>
            <option value="Rocket">Rocket</option>
            <option value="Card">Card</option>
            <option value="Cash">Cash</option>
        </select><br><br>

        <label>Transaction ID:</label>
        <input type="text" name="txn_id" required><br><br>

        <button type="submit">Confirm Payment</button>
    </form>
</body>
</html>
