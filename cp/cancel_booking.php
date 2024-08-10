<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] === TRUE && isset($_SESSION['status']) && $_SESSION['status'] === 'Active') {
    include("db_con/dbCon.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $bookingId = $_POST['bookingId'];
        $conn = connect();

        // Delete booking from database
        $query = "DELETE FROM booking WHERE booking_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $bookingId);

        if ($stmt->execute()) {
            $response = array("success" => true, "message" => "Booking successfully canceled.");
        } else {
            $response = array("success" => false, "message" => "Failed to cancel booking. Please try again.");
        }

        $stmt->close();
        $conn->close();

        echo json_encode($response);
    }
} else {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(array("success" => false, "message" => "Unauthorized access."));
}
?>