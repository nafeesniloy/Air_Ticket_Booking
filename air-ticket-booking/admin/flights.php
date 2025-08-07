<?php
include '../includes/db.php';
include '../includes/auth.php';
checkAdmin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $airline     = $_POST['airline'];
    $departure   = $_POST['departure'];
    $destination = $_POST['destination'];
    $date        = $_POST['date'];
    $time        = $_POST['time'];
    $price       = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO flights (airline, departure, destination, date, time, price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $airline, $departure, $destination, $date, $time, $price);
    $stmt->execute();
}
$result = $conn->query("SELECT * FROM flights");
?>

<!DOCTYPE html>
<html>
<head><title>Manage Flights</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h2>Add New Flight</h2>
<form method="POST">
    Airline: <input type="text" name="airline" required><br><br>
    From: <input type="text" name="departure" required><br><br>
    To: <input type="text" name="destination" required><br><br>
    Date: <input type="date" name="date" required><br><br>
    Time: <input type="time" name="time" required><br><br>
    Price: <input type="number" name="price" required><br><br>
    <button type="submit">Add Flight</button>
</form>

<h2>Existing Flights</h2>
<?php while ($row = $result->fetch_assoc()): ?>
    <div>
        <p><?php echo $row['airline']; ?> | <?php echo $row['departure']; ?> → <?php echo $row['destination']; ?> | <?php echo $row['date']; ?> <?php echo $row['time']; ?> | $<?php echo $row['price']; ?></p>
    </div>
<?php endwhile; ?>
</body>
</html>
