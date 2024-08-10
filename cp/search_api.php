<?php
// Function to search law using Indian Kanoon API
function searchLaw($query) {
    $api_url = 'https://api.indiankanoon.org/search/?format=json&q=' . urlencode($query);
    $api_key = '4064373c6e46e5374e199661646c603f06e7f65c'; // Replace with your actual API key

    // Initialize cURL session
    $ch = curl_init();

    // Set the URL
    curl_setopt($ch, CURLOPT_URL, $api_url);

    // Set the header with the API key
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Token ' . $api_key
    ));

    // Return the response instead of printing it
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Execute the request
    $response = curl_exec($ch);

    // Close cURL session
    curl_close($ch);

    // Decode the JSON response
    $data = json_decode($response, true);

    return $data;
}

// Example usage
if (isset($_POST["submit"])) {
    $search_query = $_POST["search"];
    $result = searchLaw($search_query);
    
    // Check if results are found
    if (!empty($result['results'])) {
        ?>
        <br><br><br>
        <table>
            <tr>  
            <th> Law_Name </th>
            <th> law_Description</th>
            </tr>
            <?php
            foreach ($result['results'] as $law) {
                ?>
                <tr>
                <td><?php echo $law['title']; ?></td>
                <td><?php echo $law['snippet']; ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    } else {
        echo "No matching law found.";
    }
}
?>
