<?php
// require __DIR__ . '/db.php';


$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $name = $_POST['name'];
        $hex = $_POST['hex'];

        $sql = "SELECT COUNT(*) FROM colors WHERE hex_value = '$hex'";
        $name_res = $conn->query($sql);
        $name_count = $name_res->fetch_row()[0];
        $sql = "SELECT COUNT(*) FROM colors WHERE name = '$name'";
        $hex_res = $conn->query($sql);
        $hex_count = $hex_res->fetch_row()[0];

        if ($name_count != 0 || $hex_count != 0) {
            $errors[] = 'Cannot place duplicates';
        }

        if (!$errors){
            $sql = "INSERT INTO colors (name, hex_value) VALUES ('$name', '$hex')";
            $result = $conn->query($sql);
        }

    }

    if ($action === 'edit') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $hex = $_POST['hex'];
        
        $sql = 'SELECT COUNT(*) FROM colors WHERE hex_value = $hex';
        $name_res = $conn->query($sql);
        $sql = 'SELECT COUNT(*) FROM colors WHERE name = $name';
        $hex_res = $conn->query($sql);

        if ($name_res != 0 || $hex_res != 0) {
            $errors[] = 'Cannot place duplicates';
        }
        if (!$errors) {
            $sql = 'UPDATE color SET name = $name, hex_value = $hex WHERE id = $id';
            $result = $conn->query($sql);
        }
    }

    if ($action === 'delete') {
        $name = $_POST['name'];

        $sql = 'SELECT COUNT(*) FROM colors';
        $result = $conn->query($sql);

        if ($result <= 2) {
            $errors[] = 'Cannot Delete';
        }

        if (!$errors) {
            $sql = "DELETE FROM colors WHERE name = $name";
            $results = $conn->query($sql);
        }
    }
}
?>
<div class="header">
    <h1>Color Selection</h1>
    <p>Manage colors to use with the color coordinator</p>
</div>
<div class="color-add">
    <h2>Add a Color</h2>
    <form method="POST" action="?page=color-selection">
        <input type="hidden" name="page" value="color-selection">
        <label>Color Name:</label>
        <input type="text" name="name" required>
        <br>
        <label>Hex Value:</label>
        <input type="text" name="hex" required>
        <br>
        <button type="submit" name="action" value="add">Add Color</button>
    </form>
</div>
