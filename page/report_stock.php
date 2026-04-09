<?php
require '../conf/config.php';

if (isset($_POST['export'])) {

    // Header untuk file Excel
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=data_stock_" . date('Y-m-d') . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Mulai membuat tabel untuk file Excel
    echo "<table border='1'>";
    echo "<tr>
            <th>#</th>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Stock</th>
            <th>Price</th>
        </tr>";

    // Query database untuk data return
    $query = " 
        SELECT 
                c.id AS category_id, 
                c.category_name, 
                p.id AS product_id, 
                p.name AS product_name, 
                p.stock,
                p.price
            FROM 
                categories c
            LEFT JOIN 
                products p ON c.id = p.category_id
            ORDER BY 
                c.category_name, p.name
    ";

    $sql = mysqli_query($conn, $query);

    // Validasi query
    if (!$sql) {
        die("Query gagal: " . mysqli_error($conn));
    }

    // Cek apakah data ditemukan
    if (mysqli_num_rows($sql) > 0) {
        $i = 1;
        while ($row = mysqli_fetch_assoc($sql)) {
            echo "<tr>";
            echo "<td>{$i}</td>";
            echo "<td>PRODUCT-{$row['product_id']}</td>";
            echo "<td>{$row['product_name']}</td>";
            echo "<td>{$row['category_name']}</td>";
            echo "<td>{$row['stock']}</td>";
            echo "<td>{$row['price']}</td>";
            echo "</tr>";
            $i++;
        }
    } else {
        echo "<tr><td colspan='6' class='text-center'>No data found.</td></tr>";
    }

    echo "</table>";
    exit; // Menghentikan proses setelah file terunduh
}
?>
