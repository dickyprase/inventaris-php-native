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
    header("Content-Disposition: attachment; filename=data_returns_" . date('Y-m-d') . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Mulai membuat tabel untuk file Excel
    echo "<table border='1'>";
    echo "<tr>
            <th>#</th>
            <th>User</th>
            <th>Product</th>
            <th>Return Type</th>
            <th>Transaction ID</th>
            <th>Quantity</th>
            <th>Reason</th>
            <th>Return Date</th>
        </tr>";

    // Query database untuk data return
    $query = " 
        SELECT returns.id, 
            users.name AS user_name, 
            products.name AS product_name, 
            returns.return_type,
            returns.transaction_id,
            returns.quantity, 
            returns.reason, 
            returns.return_date
        FROM returns
        JOIN products 
            ON returns.product_id = products.id
        JOIN users 
            ON returns.user_id = users.id
        WHERE returns.return_date BETWEEN '$from' AND '$to'
        ORDER BY returns.return_date DESC;
    ";

    $sql = $conn->query($query);

    // Validasi query
    if (!$sql) {
        die("Query gagal: " . $conn->error);
    }

    $no = 1;
    while ($data = $sql->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$no}</td>";
        echo "<td>{$data['user_name']}</td>";
        echo "<td>{$data['product_name']}</td>";
        echo "<td>{$data['return_type']}</td>";
            if ($data['return_type'] == 'sale') {
                echo "<td>Sale #{$data['transaction_id']}</td>";
            } elseif ($data['return_type'] == 'purchase') {
                echo "<td>Purchase #{$data['transaction_id']}</td>";
            } else {
                echo "<td>{$data['transaction_id']}</td>";
            }
        echo "<td>{$data['quantity']}</td>";
        echo "<td>{$data['reason']}</td>";
        echo "<td>" . date('Y-m-d', strtotime($data['return_date'])) . "</td>";
        echo "</tr>";
        $no++;
    }

    echo "</table>";
    exit; // Menghentikan proses setelah file terunduh
}
?>
