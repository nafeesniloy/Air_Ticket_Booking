<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Air Ticket Booking - Home</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<header style="text-align:center; padding: 20px; background: #f4f4f4;">
    <h1>Welcome to Air Ticket Booking</h1>
    <div style="margin-top: 10px;">
        <?php if (isset($_SESSION['user_name'])): ?>
            <strong>Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?></strong> |
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a> |
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
</header>

<main style="max-width: 600px; margin: 40px auto; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <h2 style="text-align:center;">Search Flights</h2>

    <form method="GET" action="booking.php" style="margin-top: 20px;">
        <label for="from"><strong>From:</strong></label><br>
        <select name="from" id="from" required>
            <option value="">Select From City</option>
            <option value="dhaka">Dhaka</option>
            <option value="chittagong">Chittagong</option>
            <option value="khulna">Khulna</option>
            <option value="sylhet">Sylhet</option>
            <option value="rajshahi">Rajshahi</option>
            <option value="barisal">Barisal</option>
            <option value="coxsbazar">Cox's Bazar</option>
        </select><br><br>

        <label for="to"><strong>To:</strong></label><br>
        <select name="to" id="to" required>
            <option value="">Select To City</option>
            <option value="dhaka">Dhaka</option>
            <option value="chittagong">Chittagong</option>
            <option value="khulna">Khulna</option>
            <option value="sylhet">Sylhet</option>
            <option value="rajshahi">Rajshahi</option>
            <option value="barisal">Barisal</option>
            <option value="coxsbazar">Cox's Bazar</option>
        </select><br><br>

        <label for="date"><strong>Date:</strong></label><br>
        <input type="date" name="date" id="date" required /><br><br>

        <button type="submit" style="padding: 10px 20px; background: #0056d2; color: white; border: none; border-radius: 5px;">Search Flights</button>
    </form>
</main>

<footer style="text-align: center; padding: 20px; margin-top: 50px; background: #f4f4f4;">
    <p>&copy; 2025 Air Ticket Booking</p>
</footer>

</body>
</html>
