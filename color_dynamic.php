 
<?php
header("Content-type: text/css");
require_once 'db.php';


$sql = "SELECT name, hex_value FROM colors";
    
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_row()) {
        echo (".cell-$row[0] { background-color: $row[1]; }\n");
    }
    $result -> free_result();
}
?>