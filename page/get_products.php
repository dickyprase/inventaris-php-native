<?php
require '../conf/config.php';

$type_id = $_POST['type_id'];
$return_type = $_POST['return_type'];

if ($return_type == 'purchase') {
    // Ambil produk berdasarkan purchase ID
    $query = "SELECT p.id, p.name FROM products p
              JOIN purchase_detail pu ON pu.product_id = p.id
              WHERE pu.purchase_id = $type_id";
} else if ($return_type == 'sale') {
    // Ambil produk berdasarkan sale ID
    $query = "SELECT p.id, p.name FROM products p
              JOIN sales s ON s.product_id = p.id
              WHERE s.id = $type_id";
}

$result = mysqli_query($conn, $query);
$options = "<option value=''>-- Pilih Produk --</option>";

while ($row = mysqli_fetch_assoc($result)) {
    $options .= "<option value='{$row['id']}'>{$row['name']}</option>";
}

echo $options;
?>
