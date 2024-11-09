<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Booking</title>
</head>
<body>
    <h1>Brampton Transit</h1>

    <?php
    // Simulated function to check if a bus is coming within 15 minutes
    function isBusComingSoon() {
        // Simulate bus arrival time in minutes (e.g., from a transit API)
        $busArrivalTime = rand(5, 30); // Randomly generate between 5 to 30 minutes
        return $busArrivalTime <= 15; // Returns true if bus is arriving within 15 minutes
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['step']) && $_POST['step'] == '1') {
        $destination = htmlspecialchars($_POST['destination']);
        echo "<p>Your destination: <strong>$destination</strong></p>";

        // Step 1: Check if the bus is arriving soon
        if (isBusComingSoon()) {
            echo "<p>A bus is arriving in less than 15 minutes. We recommend you take the bus.</p>";
        } else {
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="step" value="2">';
            echo '<input type="hidden" name="destination" value="' . $destination . '">';
            echo '<p>The next bus is more than 15 minutes away. Would you like to:</p>';
            echo '<input type="radio" name="transport" value="Bus" required> Wait for the Bus<br>';
            echo '<input type="radio" name="transport" value="Uber"> Take an Uber<br><br>';
            echo '<button type="submit">Continue</button>';
            echo '</form>';
        }

    } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['step']) && $_POST['step'] == '2') {
        $destination = htmlspecialchars($_POST['destination']);
        $transport = htmlspecialchars($_POST['transport']);

        if ($transport == "Uber") {
            // Step 2: Ask if the user wants to carpool if Uber is selected
            echo "<p>You chose to travel to <strong>$destination</strong> by <strong>Uber</strong>.</p>";
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="step" value="3">';
            echo '<input type="hidden" name="destination" value="' . $destination . '">';
            echo '<input type="hidden" name="transport" value="Uber">';
            echo '<p>Would you like to carpool?</p>';
            echo '<input type="radio" name="carpool" value="Yes" required> Yes<br>';
            echo '<input type="radio" name="carpool" value="No"> No<br><br>';
            echo '<button type="submit">Submit</button>';
            echo '</form>';
        } else {
            echo "<p>You chose to wait for the bus to travel to <strong>$destination</strong>.</p>";
        }

    } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['step']) && $_POST['step'] == '3') {
        $destination = htmlspecialchars($_POST['destination']);
        $transport = htmlspecialchars($_POST['transport']);
        $carpool = htmlspecialchars($_POST['carpool']);

        echo "<p>You chose to travel to <strong>$destination</strong> by <strong>$transport</strong>.";
        echo $carpool == "Yes" ? " You have opted to carpool." : " You chose not to carpool.";
        echo "</p>";
    } else {
        // Initial form to ask for the destination
        echo '<form method="post" action="">';
        echo '<input type="hidden" name="step" value="1">';
        echo '<label for="destination">Where do you want to go?</label><br>';
        echo '<input type="text" id="destination" name="destination" required><br><br>';
        echo '<button type="submit">Submit</button>';
        echo '</form>';
    }
    ?>
</body>
</html>
