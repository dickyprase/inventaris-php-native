<?php

require "config.php";


function getDashboardData() {
    global $conn;

    // Jumlah barang (stock)
    $query_products = "SELECT SUM(stock) AS total_products FROM products";
    $result_products = mysqli_query($conn, $query_products);
    $row_products = mysqli_fetch_assoc($result_products);
    $total_products = $row_products['total_products'] ?? 0;  

    // Jumlah pembelian
    $query_purchases = "SELECT COUNT(*) AS total FROM purchase";
    $result_purchases = mysqli_query($conn, $query_purchases);
    $row_purchases = mysqli_fetch_assoc($result_purchases);
    $total_purchases = $row_purchases['total'] ?? 0;

    // Jumlah assets
    $query_assets = "SELECT SUM(stock * price) AS total_assets FROM products;";
    $result_assets = mysqli_query($conn, $query_assets);
    $row_assets = mysqli_fetch_assoc($result_assets);
    $total_assets = $row_assets['total_assets'] ?? 0;

    // Jumlah pengeluaran
    $query_sales = "SELECT SUM(quantity) AS total_sales FROM sales";
    $result_sales = mysqli_query($conn, $query_sales);
    $row_sales = mysqli_fetch_assoc($result_sales);
    $total_sales = $row_sales['total_sales'] ?? 0;

    return [
        'total_products' => $total_products,
        'total_purchases' => $total_purchases,
        'total_assets' => $total_assets,
        'total_sales' => $total_sales
    ];
}



function login($username, $password)
{
    global $conn;

    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if ($password == $user['password']) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            return [
                'status' => true,
                'message' => 'Login berhasil'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Password salah'
            ];
        }
    } else {
        return [
            'status' => false,
            'message' => 'Username tidak ditemukan'
        ];
    }
}



function getStock() {
    global $conn;
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
    
    $result = mysqli_query($conn, $query);
    return $result;
}

function renderStockTable($result) {
    if (mysqli_num_rows($result) > 0) {
        $i = 1;
        $total_stock = 0;
        $total_price = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$i}</td>";
            echo "<td>PRODUCT-{$row['product_id']}</td>";
            echo "<td>{$row['product_name']}</td>";
            echo "<td>{$row['category_name']}</td>";
            echo "<td>{$row['stock']}</td>";
            echo "<td>Rp." . number_format($row['price']) . "</td>";
            echo "</tr>";
            

            $i++;
        }


    } else {
        echo "<tr><td rowspan='6' class='text-center'>No stock data found.</td></tr>";
    }
}




// function Master Barang
function getMasterBarang() {
    global $conn;

    $query = "SELECT * FROM products";
    $result = mysqli_query($conn, $query);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}

function addMasterBarang($nama_barang, $stok, $price, $category_id) {
    global $conn; 

    $nama_barang = mysqli_real_escape_string($conn, $nama_barang);
    $stok = mysqli_real_escape_string($conn, $stok);
    $price = mysqli_real_escape_string($conn, $price);
    $category_id = mysqli_real_escape_string($conn, $category_id);

    $query = "INSERT INTO products (category_id, name, stock, price) VALUES ($category_id, '$nama_barang', '$stok', '$price')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        return ['status' => true, 'message' => 'Data berhasil disimpan.'];
    } else {
        return ['status' => false, 'message' => 'Gagal menyimpan data: ' . mysqli_error($conn)];
    }
}

function deleteMasterBarang($id) {
    global $conn;

    $id = mysqli_real_escape_string($conn, $id);

    $query = "DELETE FROM products WHERE id = '$id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        return ['status' => true, 'message' => 'Data berhasil dihapus.'];
    } else {
        return ['status' => false, 'message' => 'Gagal menghapus data: ' . mysqli_error($conn)];
    }
}


function updateMasterBarang($id, $name, $stock, $price, $category) {
    global $conn;

    $id = mysqli_real_escape_string($conn, $id);
    $name = mysqli_real_escape_string($conn, $name);
    $stock = mysqli_real_escape_string($conn, $stock);
    $price = mysqli_real_escape_string($conn, $price);
    $category = mysqli_real_escape_string($conn, $category);

    $query = "UPDATE products 
              SET category_id = $category, 
                  name = '$name', 
                  stock = '$stock',
                  price = '$price'
              WHERE id = $id";

    $result = mysqli_query($conn, $query);

    if ($result) {
        return ['status' => true, 'message' => 'Data berhasil diperbarui.'];
    } else {
        return ['status' => false, 'message' => 'Gagal memperbarui data: ' . mysqli_error($conn)];
    }
}



// function catergory
function getMasterCategory() {
    global $conn;

    $query = "SELECT * FROM categories";
    $result = mysqli_query($conn, $query);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}

function addMasterCategory($category_name) {
    global $conn; 

    $name = mysqli_real_escape_string($conn, $category_name);

    $query = "INSERT INTO categories (category_name) VALUES ('$name')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        return ['status' => true, 'message' => 'Data berhasil disimpan.'];
    } else {
        return ['status' => false, 'message' => 'Gagal menyimpan data: ' . mysqli_error($conn)];
    }
}

function deleteMastercategory($id) {
    global $conn;

    $id = mysqli_real_escape_string($conn, $id);

    $query = "DELETE FROM categories WHERE id = $id";

    $result = mysqli_query($conn, $query);

    if ($result) {
        return ['status' => true, 'message' => 'Data berhasil dihapus.'];
    } else {
        return ['status' => false, 'message' => 'Gagal menghapus data: ' . mysqli_error($conn)];
    }
}


function updateMasterCategory($id, $name) {
    global $conn;

    $id = mysqli_real_escape_string($conn, $id);
    $name = mysqli_real_escape_string($conn, $name);

    $query = "UPDATE categories 
                SET category_name = '$name'
              WHERE id = $id";

    $result = mysqli_query($conn, $query);

    if ($result) {
        return ['status' => true, 'message' => 'Data berhasil diperbarui.'];
    } else {
        return ['status' => false, 'message' => 'Gagal memperbarui data: ' . mysqli_error($conn)];
    }
}


// fucntion supplier
function getSuppliers() {
    global $conn;

    $query = "SELECT * FROM suppliers";
    $result = mysqli_query($conn, $query);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}

function addMasterSupplier($name, $address, $contact) {
    global $conn; 

    $name = mysqli_real_escape_string($conn, $name);
    $address = mysqli_real_escape_string($conn, $address);
    $contact = mysqli_real_escape_string($conn, $contact);

    $query = "INSERT INTO suppliers (name, address, contact_info) VALUES ('$name', '$address', '$contact')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        return ['status' => true, 'message' => 'Data berhasil disimpan.'];
    } else {
        return ['status' => false, 'message' => 'Gagal menyimpan data: ' . mysqli_error($conn)];
    }
}

function updateMasterSupplier($id, $name, $address, $contact) {
    global $conn;

    $id = mysqli_real_escape_string($conn, $id);
    $name = mysqli_real_escape_string($conn, $name);
    $address = mysqli_real_escape_string($conn, $address);
    $contact = mysqli_real_escape_string($conn, $contact);

    $query = "UPDATE suppliers 
                SET name = '$name',
                    address = '$address',
                    contact_info = '$contact'
              WHERE id = $id";

    $result = mysqli_query($conn, $query);

    if ($result) {
        return ['status' => true, 'message' => 'Data berhasil diperbarui.'];
    } else {
        return ['status' => false, 'message' => 'Gagal memperbarui data: ' . mysqli_error($conn)];
    }
}


function deleteMasterSupplier($id) {
    global $conn;

    $id = mysqli_real_escape_string($conn, $id);

    $query = "DELETE FROM suppliers WHERE id = $id";

    $result = mysqli_query($conn, $query);

    if ($result) {
        return ['status' => true, 'message' => 'Data berhasil dihapus.'];
    } else {
        return ['status' => false, 'message' => 'Gagal menghapus data: ' . mysqli_error($conn)];
    }
}


// function users
function getUsers() {
    global $conn;

    $query = "SELECT * FROM users WHERE id !=1";
    $result = mysqli_query($conn, $query);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}

function generateNewNIP() {
    global $conn;

    $query = "SELECT nip FROM users ORDER BY nip DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $lastNIP = $row['nip'];

        $lastNumber = (int) $lastNIP;
        $newNumber = $lastNumber + 1;

        $newNIP = str_pad($newNumber, 5, '0', STR_PAD_LEFT); 
        
        return $newNIP;
    } else {
        return '00001';
    }
}


function addUser($nip, $name, $username, $password) {
    global $conn;

    $nip = mysqli_real_escape_string($conn, $nip);
    $name = mysqli_real_escape_string($conn, $name);
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "INSERT INTO users (nip, name, username, password) VALUES ('$nip', '$name', '$username', '$password')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        return ['status' => true, 'message' => 'Data berhasil disimpan.'];
    } else {
        return ['status' => false, 'message' => 'Gagal menyimpan data: ' . mysqli_error($conn)];
    }
}


function updateUser($id, $name, $username, $password, $role) {
    global $conn;

    $id = mysqli_real_escape_string($conn, $id);
    $name = mysqli_real_escape_string($conn, $name);
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    $role = mysqli_real_escape_string($conn, $role);

    $query = "UPDATE users 
                SET name = '$name',
                    username = '$username',
                    password = '$password',
                    role = '$role'
              WHERE id = $id";

    $result = mysqli_query($conn, $query);

    if ($result) {
        return ['status' => true, 'message' => 'Data berhasil diperbarui.'];
    } else {
        return ['status' => false, 'message' => 'Gagal memperbarui data: ' . mysqli_error($conn)];
    }
}

function deleteUser($id) {
    global $conn;

    $id = mysqli_real_escape_string($conn, $id);

    $query = "DELETE FROM users WHERE id = $id";

    $result = mysqli_query($conn, $query);

    if ($result) {
        return ['status' => true, 'message' => 'Data berhasil dihapus.'];
    } else {
        return ['status' => false, 'message' => 'Gagal menghapus data: ' . mysqli_error($conn)];
    }
}

// function setting
function getSettings() {
    global $conn;

    $query = "SELECT * FROM settings WHERE id=1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        return mysqli_fetch_assoc($result); 
    } else {
        return null; 
    }
}


function updateCompanySettings($name, $vat) {
    global $conn;

    $name = mysqli_real_escape_string($conn, $name);
    $vat = mysqli_real_escape_string($conn, $vat);

    $query = "UPDATE settings 
                SET company_name = '$name',
                    vat = $vat
              WHERE id = 1";

    $result = mysqli_query($conn, $query);

    if ($result) {
        return ['status' => true, 'message' => 'Data berhasil diperbarui.'];
    } else {
        return ['status' => false, 'message' => 'Gagal memperbarui data: ' . mysqli_error($conn)];
    }
}


// purchases

function inputPurchase($product_id, $user_id, $supplier_id, $quantity, $info, $purchase_date) {
    global $conn;

    $product_id = mysqli_real_escape_string($conn, $product_id);
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $supplier_id = mysqli_real_escape_string($conn, $supplier_id);
    $quantity = mysqli_real_escape_string($conn, $quantity);
    $info = mysqli_real_escape_string($conn, $info);
    $purchase_date = mysqli_real_escape_string($conn, $purchase_date);

    $query = "INSERT INTO purchases (product_id, user_id, supplier_id, quantity, info, purchase_date) 
              VALUES ('$product_id', '$user_id', '$supplier_id', '$quantity', '$info', '$purchase_date')";
    if (mysqli_query($conn, $query)) {
        $updateQuery = "UPDATE products SET stock = stock + $quantity WHERE id = $product_id";
        mysqli_query($conn, $updateQuery);
        
        return ['status' => true, 'message' => 'Data pembelian berhasil ditambahkan dan stok diperbarui.'];
    } else {
        return ['status' => false, 'message' => 'Gagal memperbarui data: ' . mysqli_error($conn)];
    }
}


function getPurchaseHistory() {
    global $conn;
    $query = "SELECT p.*, s.name as supplier_name 
              FROM purchase p
              LEFT JOIN suppliers s ON p.supplier_id = s.id 
              ORDER BY p.purchase_date DESC";
    
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getPurchaseDetails($purchaseId) {
    global $conn;
    $purchaseId = mysqli_real_escape_string($conn, $purchaseId);
    
    $query = "SELECT pd.*, p.name as product_name 
              FROM purchase_detail pd
              LEFT JOIN products p ON pd.product_id = p.id
              WHERE pd.purchase_id = '$purchaseId'";
    
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


function displayPurchaseData() {
    global $conn;

    $query = "SELECT pd.id AS purchase_detail_id, p.name AS product_name, u.username AS user_name, s.name AS supplier_name, pd.quantity, pd.total AS total_amount, pur.faktur AS faktur , pur.purchase_date
              FROM purchase_detail pd
              JOIN purchase pur ON pd.purchase_id = pur.id
              JOIN products p ON pd.product_id = p.id
              JOIN suppliers s ON pur.supplier_id = s.id
              JOIN users u ON pur.user_id = u.id
              ORDER BY pur.faktur ASC";
    
    $result = mysqli_query($conn, $query); // pastikan $conn adalah koneksi ke database

    if (mysqli_num_rows($result) > 0) {
        $i=1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$i}</td>
                    <td>{$row['faktur']}</td>
                    <td>{$row['product_name']}</td>
                    <td>{$row['supplier_name']}</td>
                    <td>{$row['quantity']}</td>
                    <td>Rp.". number_format($row['total_amount']) ."</td>
                    <td>{$row['purchase_date']}</td>
                  </tr>";
                  $i++;
        }
    } else {
        echo "<tr><td colspan='7'>No records found</td></tr>";
    }
}



//sales
function inputSales($product_id, $user_id, $quantity, $info, $sale_date) {
    global $conn;

    $product_id = mysqli_real_escape_string($conn, $product_id);
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $quantity = mysqli_real_escape_string($conn, $quantity);
    $info = mysqli_real_escape_string($conn, $info);
    $sale_date = mysqli_real_escape_string($conn, $sale_date);

    $query = "INSERT INTO sales (product_id, user_id, quantity, info, sale_date) 
              VALUES ('$product_id', '$user_id',  '$quantity', '$info', '$sale_date')";
    if (mysqli_query($conn, $query)) {
        $updateQuery = "UPDATE products SET stock = stock - $quantity WHERE id = $product_id";
        mysqli_query($conn, $updateQuery);
        
        return ['status' => true, 'message' => 'Data pengeluaran berhasil ditambahkan dan stok diperbarui.'];
    } else {
        return ['status' => false, 'message' => 'Gagal memperbarui data: ' . mysqli_error($conn)];
    }
}


function getSalesHistory() {
    global $conn;
    $query = "
        SELECT sales.id, 
            users.name AS user_name, 
            products.name AS product_name, 
            sales.quantity, 
            sales.info, 
            sales.sale_date
        FROM sales
        JOIN products 
            ON sales.product_id = products.id
        JOIN users 
            ON sales.user_id = users.id
        ORDER BY sales.sale_date DESC;
";
    
    $result = mysqli_query($conn, $query);
    return $result;
}

function renderSalesTable($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['product_name']}</td>";
            echo "<td>{$row['user_name']}</td>";
            echo "<td>{$row['quantity']}</td>";
            echo "<td>{$row['info']}</td>";
            echo "<td>" . date('Y-m-d', strtotime($row['sale_date'])) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7' class='text-center'>No Sales history found.</td></tr>";
    }
}


//return
function processReturn($product_id, $user_id, $quantity, $reason, $return_date, $return_type, $transaction_id) {
    global $conn;

    $product_id = mysqli_real_escape_string($conn, $product_id);
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $quantity = mysqli_real_escape_string($conn, $quantity);
    $reason = mysqli_real_escape_string($conn, $reason);
    $return_date = mysqli_real_escape_string($conn, $return_date);
    $return_type = mysqli_real_escape_string($conn, $return_type);
    $transaction_id = mysqli_real_escape_string($conn, $transaction_id);

    $referenceQuery = "";
    if ($return_type == 'purchase') {
        $referenceQuery = "SELECT quantity FROM purchase_detail WHERE purchase_id = '$transaction_id' AND product_id = '$product_id'";
    } elseif ($return_type == 'sale') {
        $referenceQuery = "SELECT quantity FROM sales WHERE id = '$transaction_id' AND product_id = '$product_id'";
    }

    $result = mysqli_query($conn, $referenceQuery);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        
        if ($row) {
            $availableQuantity = $row['quantity'];
            if ($quantity > $availableQuantity) {
                return ['status' => false, 'message' => 'Jumlah return melebihi jumlah yang tersedia dalam transaksi.'];
            }
        } else {
            return ['status' => false, 'message' => 'Data transaksi tidak ditemukan.'];
        }
    } else {
        return ['status' => false, 'message' => 'Gagal memeriksa data transaksi: ' . mysqli_error($conn)];
    }

    $query = "INSERT INTO returns (product_id, user_id, return_type, transaction_id, quantity, reason, return_date) 
              VALUES ('$product_id', '$user_id', '$return_type', '$transaction_id', '$quantity', '$reason', '$return_date')";

    if (mysqli_query($conn, $query)) {

        if ($return_type == 'purchase') {
            $updateQuery = "UPDATE products SET stock = stock - $quantity WHERE id = $product_id";
        } elseif ($return_type == 'sale') {
            $updateQuery = "UPDATE products SET stock = stock + $quantity WHERE id = $product_id";
        }

        if (mysqli_query($conn, $updateQuery)) {
            return ['status' => true, 'message' => 'Data return berhasil disimpan dan stok diperbarui.'];
        } else {
            return ['status' => false, 'message' => 'Gagal memperbarui stok: ' . mysqli_error($conn)];
        }
    } else {
        return ['status' => false, 'message' => 'Gagal menyimpan data return: ' . mysqli_error($conn)];
    }
}

function getReturnHistory() {
    global $conn;
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
        ORDER BY returns.return_date DESC;
";
    
    $result = mysqli_query($conn, $query);
    return $result;
}

function renderReturnTable($result) {
    if (mysqli_num_rows($result) > 0) {
        $i=1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$i}</td>";
            echo "<td>{$row['product_name']}</td>";
            echo "<td>{$row['user_name']}</td>";
            echo "<td>{$row['return_type']}</td>";
            if ($row['return_type'] == 'sale') {
                echo "<td>Sale #{$row['transaction_id']}</td>";
            } elseif ($row['return_type'] == 'purchase') {
                echo "<td>Purchase #{$row['transaction_id']}</td>";
            } else {
                echo "<td>{$row['transaction_id']}</td>";
            }
            echo "<td>{$row['quantity']}</td>";
            echo "<td>{$row['reason']}</td>";
            echo "<td>" . date('Y-m-d', strtotime($row['return_date'])) . "</td>";
            echo "</tr>";
        }
        $i++;
    } else {
        echo "<tr><td colspan='7' class='text-center'>No Return history found.</td></tr>";
    }
}


?>
