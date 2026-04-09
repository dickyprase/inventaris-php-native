<?php
require '../conf/config.php';

if (isset($_POST['export'])) {
    $from = $_POST['from'];
    $to = $_POST['to'];

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=data_bahan_masuk_" . date('Y-m-d') . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Mulai menulis tabel ke file Excel
    echo "<table border='1'>";
    echo "<tr>
            <th>#</th>
            <th>Faktur</th>
            <th>Product</th>
            <th>Supplier</th>
            <th>Quantity</th>
            <th>Harga</th>
            <th>Purchase Date</th>
        </tr>";

    // Query untuk mengambil data dengan filter tanggal
    $sql = $conn->query("SELECT pd.id AS purchase_detail_id, p.name AS product_name, u.username AS user_name, s.name AS supplier_name, pd.quantity, pd.total AS total_amount, pur.faktur AS faktur , pur.purchase_date
              FROM purchase_detail pd
              JOIN purchase pur ON pd.purchase_id = pur.id
              JOIN products p ON pd.product_id = p.id
              JOIN suppliers s ON pur.supplier_id = s.id
              JOIN users u ON pur.user_id = u.id
              ORDER BY pur.faktur ASC");

    $no = 1;
    while ($data = $sql->fetch_assoc()) {
        echo "<tr>
        <td>{$no}</td>
        <td>{$data['faktur']}</td>
        <td>{$data['product_name']}</td>
        <td>{$data['supplier_name']}</td>
        <td>{$data['quantity']}</td>
        <td>Rp.". number_format($data['total_amount']) ."</td>
        <td>{$data['purchase_date']}</td>
      </tr>";
        $no++;
    }

    echo "</table>";
}