<?php
// getAssignedAssets.php
// session_start();
include('./config/connection.php');

if (!isset($_SESSION["user"]["userID"])) {
    echo json_encode(["data" => [], "error" => "User not logged in"]);
    exit;
}

$userID = $_SESSION["user"]["userID"];

$sql = "SELECT 
            aa.assignmentID,
            aa.assignmentDate,
            aa.returnDate,
            aa.expCheckinDate,
            aa.status,
            aa.quantity,
            aa.checkedOutDate,
            i.name AS itemName,
            o.name AS officeName
        FROM assetassignment aa
        LEFT JOIN item i ON aa.itemID = i.itemID
        LEFT JOIN office o ON aa.officeID = o.officeID
        WHERE aa.userID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(["data" => $data]);
?>