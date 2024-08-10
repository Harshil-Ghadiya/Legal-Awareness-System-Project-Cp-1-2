<?php
include("db_con/dbCon.php");

if (isset($_POST['date']) && isset($_POST['lawyer_id'])) {
    $date = $_POST['date'];
    $lawyer_id = $_POST['lawyer_id'];

    $conn = connect();
    $query = "SELECT time_slot FROM bookings WHERE lawyer_id='$lawyer_id' AND date='$date'";
    $result = mysqli_query($conn, $query);

    $booked_slots = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $booked_slots[] = $row['time_slot'];
    }
    mysqli_close($conn);

    $all_slots = [
        "8am to 9am", "9am to 10am", "10am to 11am", "11am to 12pm", 
        "12pm to 1pm", "1pm to 2pm", "2pm to 3pm", "3pm to 4pm", "4pm to 5pm"
    ];

    $available_slots = array_diff($all_slots, $booked_slots);

    foreach ($available_slots as $slot) {
        echo "<option value='$slot'>$slot</option>";
    }
}
?>
