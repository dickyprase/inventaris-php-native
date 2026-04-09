<?php

require '../conf/config.php';

// Ambil data untuk purchases per hari
$purchasesQuery = "SELECT 
                        DAY(p.purchase_date) AS day, 
                        SUM(pd.quantity) AS total_quantity
                    FROM 
                        purchase p
                    JOIN 
                        purchase_detail pd ON p.id = pd.purchase_id
                    WHERE 
                        MONTH(p.purchase_date) = MONTH(CURRENT_DATE)
                    GROUP BY 
                        DAY(p.purchase_date)
                    ORDER BY 
                        day;
";
$purchasesResult = mysqli_query($conn, $purchasesQuery);

$purchasesData = [];
for ($i = 1; $i <= 31; $i++) {
    $purchasesData[$i] = 0; // Initialize with 0 for all days
}

while ($row = mysqli_fetch_assoc($purchasesResult)) {
    $purchasesData[$row['day']] = $row['total_quantity'];
}

// Ambil data untuk sales per hari
$salesQuery = "SELECT DAY(sale_date) AS day, SUM(quantity) AS total 
               FROM sales 
               WHERE MONTH(sale_date) = MONTH(CURRENT_DATE) 
               GROUP BY DAY(sale_date)";
$salesResult = mysqli_query($conn, $salesQuery);

$salesData = [];
for ($i = 1; $i <= 31; $i++) {
    $salesData[$i] = 0; // Initialize with 0 for all days
}

while ($row = mysqli_fetch_assoc($salesResult)) {
    $salesData[$row['day']] = $row['total'];
}

// Siapkan data untuk Chart.js
$data = [
    'days' => range(1, 31), // Tanggal 1 hingga 31
    'purchases' => array_values($purchasesData), // Jumlah pembelian per hari
    'sales' => array_values($salesData) // Jumlah penjualan per hari
];

// Kembalikan data dalam format JSON
echo json_encode($data);
?>
