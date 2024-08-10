<?php
include('db_con/dbCon.php');
$conn = connect();

if (isset($_GET['date']) && isset($_GET['lawyer_id'])) {
    $date = $_GET['date'];
    $lawyer_id = $_GET['lawyer_id'];

    // Fetch already booked time slots for the selected date and lawyer
    $query = "SELECT time_slot FROM bookings WHERE date = '$date' AND lawyer_id = '$lawyer_id'";
    $result = mysqli_query($conn, $query);

    $booked_slots = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $booked_slots[] = $row['time_slot'];
    }

    echo json_encode($booked_slots);
}
?>
