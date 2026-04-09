<?php
require '../conf/config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['export'])) {
    $from = $_POST['from'];
    $to = $_POST['to'];

    if (empty($from) || empty($to)) {
        die("Tanggal tidak valid!");
    }

    // Header untuk file Excel
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=data_sales_" . date('Y-m-d') . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Membuat tabel
    echo "<table border='1'>";
    echo "<tr>
            <th>#</th>
            <th>Product</th>
            <th>User</th>
            <th>Quantity</th>
            <th>Keterangan</th>
            <th>Tanggal</th>
        </tr>";

    // Query database
    $sql = $conn->query("SELECT 
            p.id, 
            p.product_id, 
            p.user_id, 
            p.quantity, 
            p.info, 
            p.sale_date, 
            pr.name AS product_name, 
            u.name AS user_name
        FROM sales p
        JOIN products pr ON p.product_id = pr.id
        JOIN users u ON p.user_id = u.id
        WHERE p.sale_date BETWEEN '$from' AND '$to'
        ORDER BY p.sale_date DESC");

    if (!$sql) {
        die("Query gagal: " . $conn->error);
    }

    $no = 1;
    while ($data = $sql->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$no}</td>";
        echo "<td>{$data['product_name']}</td>";
        echo "<td>{$data['user_name']}</td>";
        echo "<td>{$data['quantity']}</td>";
        echo "<td>{$data['info']}</td>";
        echo "<td>" . date('Y-m-d', strtotime($data['sale_date'])) . "</td>";
        echo "</tr>";
        $no++;
    }

    echo "</table>";
    exit;
}
?>
