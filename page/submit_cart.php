<?php
require '../conf/config.php';
header('Content-Type: application/json');

function savePurchase($faktur, $supplier, $user_id, $date, $cart) {
    global $conn;
    
    if (!$conn) {
        return ['success' => false, 'message' => 'Koneksi database gagal!'];
    }
    
    // Escape string untuk mencegah SQL injection
    $faktur = mysqli_real_escape_string($conn, $faktur);
    $supplier = mysqli_real_escape_string($conn, $supplier);
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $date = mysqli_real_escape_string($conn, $date);
    
    // Mengecek apakah faktur sudah ada
    $check_query = "SELECT COUNT(*) as count FROM purchase WHERE faktur = '$faktur'";
    $check_result = mysqli_query($conn, $check_query);
    $row = mysqli_fetch_assoc($check_result);
    
    if ($row['count'] > 0) {
        return ['success' => false, 'message' => 'Nomor faktur sudah ada dalam database!'];
    }
    
    // Mulai transaction
    mysqli_begin_transaction($conn);
    
    try {
        // Menyiapkan query untuk memasukkan data ke tabel purchase
        $query = "INSERT INTO purchase (supplier_id, user_id, purchase_date, faktur) VALUES ('$supplier', $user_id, '$date', '$faktur')";
        
        if (mysqli_query($conn, $query)) {
            $purchaseId = mysqli_insert_id($conn); 
            $updated_products = []; // Array untuk menyimpan produk yang diupdate harganya
            
            // Menyiapkan query untuk memasukkan data ke tabel purchase_detail
            foreach ($cart as $item) {
                $product_id = mysqli_real_escape_string($conn, $item['id']);
                $quantity = mysqli_real_escape_string($conn, $item['quantity']);
                $price = mysqli_real_escape_string($conn, $item['price']);
                $total = $item['quantity'] * $item['price'];
                
                // Cek harga dan stok di database
                $price_query = "SELECT price, stock FROM products WHERE id = '$product_id'";
                $price_result = mysqli_query($conn, $price_query);
                $product = mysqli_fetch_assoc($price_result);

                if (!$product) {
                    throw new Exception("Produk dengan ID $product_id tidak ditemukan!");
                }

                if ($product && $product['price'] != $item['price']) {
                    $update_price = "UPDATE products SET 
                                   price = '$price',
                                   updated_at = NOW() 
                                   WHERE id = '$product_id'";
                    
                    if (mysqli_query($conn, $update_price)) {
                        $updated_products[] = $product_id;
                    } else {
                        throw new Exception('Gagal mengupdate harga produk!');
                    }
                }
                
            
                // Update stok produk
                $new_stock = $product['stock'] + $quantity;
                $update_stock_query = "UPDATE products SET stock = '$new_stock' WHERE id = '$product_id'";
                
                if (!mysqli_query($conn, $update_stock_query)) {
                    throw new Exception("Gagal mengupdate stok produk dengan ID $product_id!");
                }
                
            
                // Insert ke purchase_detail
                $query_detail = "INSERT INTO purchase_detail 
                                (purchase_id, product_id, quantity, price, total) 
                                VALUES ('$purchaseId', '$product_id', '$quantity', '$price', '$total')";
                                
                if (!mysqli_query($conn, $query_detail)) {
                    throw new Exception('Gagal menyimpan detail pembelian!');
                }
            }
            
            
            // Menghitung total pembelian
            $query_total = "SELECT SUM(total) AS total_purchase 
                           FROM purchase_detail 
                           WHERE purchase_id = '$purchaseId'";
            $result = mysqli_query($conn, $query_total);
            $row = mysqli_fetch_assoc($result);
            $total_purchase = $row['total_purchase'];
            
            // Update kolom total di tabel purchase
            $query_update = "UPDATE purchase SET total = '$total_purchase' 
                           WHERE id = '$purchaseId'";
            if (!mysqli_query($conn, $query_update)) {
                throw new Exception('Gagal mengupdate total pembelian!');
            }
            
            // Commit transaction
            mysqli_commit($conn);
            
            $message = 'Data berhasil disimpan';
            if (count($updated_products) > 0) {
                $message .= '. ' . count($updated_products) . ' produk diupdate harganya';
            }
            
            return ['success' => true, 'message' => $message];
            
        } else {
            throw new Exception('Gagal menyimpan pembelian!');
        }
        
    } catch (Exception $e) {
        mysqli_rollback($conn);
        return ['success' => false, 'message' => $e->getMessage()];
    }

}

// Proses request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $supplier = $_POST['supplier'] ?? '';
    $user_id = $_POST['user_id'] ?? '';
    $date = $_POST['date'] ?? '';
    $faktur = $_POST['faktur'] ?? '';
    
    $cartData = $_POST['cart'] ?? '';
    if (!is_string($cartData)) {
        echo json_encode([
            'success' => false, 
            'message' => 'Format cart tidak valid!'
        ]);
        exit;
    }
    $cart = json_decode($_POST['cart'], true);

    if (!$supplier || !$date || !$faktur || !$cart) {
        echo json_encode(['success' => false, 'message' => 'Data tidak lengkap!']);
        exit;
    }

    $result = savePurchase($faktur ,$supplier, $user_id, $date, $cart);
    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Metode tidak valid!']);
}



