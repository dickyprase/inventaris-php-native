<?php

require '../conf/config.php';

$return_type = $_POST['return_type'];

if ($return_type == 'purchase') {
    // Ambil purchase ID
    $query = "SELECT id, CONCAT('Purchase #', id) AS reference FROM purchase";
} else if ($return_type == 'sale') {
    // Ambil sale ID
    $query = "SELECT id, CONCAT('Sale #', id) AS reference FROM sales";
}

$result = mysqli_query($conn, $query);
$options = "<option value=''>-- Pilih Reference ID --</option>";

while ($row = mysqli_fetch_assoc($result)) {
    $options .= "<option value='{$row['id']}'>{$row['reference']}</option>";
}

echo $options;
?>
