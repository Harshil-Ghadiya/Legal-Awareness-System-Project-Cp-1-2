<?php
// Include your database connection code
include("db_con/dbCon.php");

// Check if the selected date is provided in the AJAX request
if(isset($_POST['selectedDate'])) {
    // Sanitize the input to prevent SQL injection
    $selectedDate = mysqli_real_escape_string($conn, $_POST['selectedDate']);

    // Query to retrieve booked time slots for the selected date
    $query = "SELECT time FROM booking WHERE booking_date = '$selectedDate'";
    $result = mysqli_query($conn, $query);

    // Check if query was successful
    if($result) {
        // Array to store booked time slots
        $bookedSlots = array();

        // Fetch booked time slots from the result set
        while($row = mysqli_fetch_assoc($result)) {
            $bookedSlots[] = $row['time'];
        }

        // Convert booked time slots array to comma-separated string
        $bookedSlotsString = implode(',', $bookedSlots);

        // Send the booked time slots as response
        echo $bookedSlotsString;
    } else {
        // Error handling if query fails
        echo "Error: " . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
} else {
    // Handle case when selected date is not provided
    echo "Error: Selected date not provided.";
}
?>
