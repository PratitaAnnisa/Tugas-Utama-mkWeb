<?php
    session_start();

    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = [];
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $productid = (int) $_POST['productid'];
        $productname = htmlspecialchars(trim($_POST['productname']));
        $unitprice = (float) $_POST['unitprice'];
        $jumlah = (int) $_POST['jumlah'];

        if($jumlah < 1) $jumlah = 1;

        if(isset($_SESSION['cart'][$productid])){
            $_SESSION['cart'][$productid]['jumlah'] += $jumlah;
        } else {
            $_SESSION['cart']['productid'] = [
                'productid' => $productid,
                'productname' => $productname,
                'unitprice' => $unitprice,
                'jumlah' => $jumlah,
            ];
        }
    }

    $total = 0;
    foreach($_SESSION['cart'] as $item){
        $total =+ $item['unitprice'] * $item['jumlah'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart</title>
</head>
<body>
    <h1>Shopping Cart</h1>

    <?php if(empty($_SESSION['cart'])): ?>
        <p>Keranjang belanja anda masih ksoong</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>ProductName</th>
                    <th>UnitPrice</th>
                    <th>Jumlah</th>
                    <th>SubTotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($_SESSION['cart'] as $item): ?>
                <?php $subtotal = $item['unitprice'] * $item['jumlah']; ?>
                <tr>
                    <td><?= $item['productid'] ?></td>
                    <td><?= htmlspecialchars($item['productname']) ?></td>
                    <td><?= number_format($item['unitprice'], 2) ?></td>
                    <td><?= $item['jumlah'] ?></td>
                    <td><?= number_format($subtotal, 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" align="right">Total Harga: </th>
                    <th>$<?= number_format($total, 2) ?></th>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>
    <br>
    <a href="index.php">
        <button>Tambahkan Produk Lain</button>
    </a>
</body>
</html>

