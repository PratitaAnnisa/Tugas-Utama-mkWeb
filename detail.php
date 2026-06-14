<?php
    include 'koneksi.php';

    if(!isset($_GET['productid']) || !is_numeric($_GET['productid'])){
        header("Location: index.php");
        exit;
    }

    $productid = (int) $_GET['productid'];

    $query = "SELECT p.ProductID, p.ProductName, p.QuantityPerUnit, p.UnitPrice, p.UnitsInStock, p.UnitsOnOrder, p.ReorderLevel, p.Discontinued, c.CategoryName, s.CompanyName AS SupplierName FROM Products p LEFT JOIN Categories c ON p.CategoryID = c.CategoryID LEFT JOIN Suppliers s ON p.SupplierID = s.SupplierID WHERE p.ProductID = $productid";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 0){
        header("Location: index.php");
        exit;
    }

    $product = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk: <?= htmlspecialchars($product['ProductName']) ?></title>
</head>
<body>
    <h1>Detail Produk</h1>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>ProductID</th>
            <td><?= $product['ProductID'] ?></td>
        </tr>
        <tr>
            <th>ProductName</th>
            <td><?= htmlspecialchars($product['ProductName']) ?></td>
        </tr>
        <tr>
            <th>Category</th>
            <td><?= htmlspecialchars($product['CategoryName']) ?></td>
        </tr>
        <tr>
            <th>Supplier</th>
            <td><?= htmlspecialchars($product['SupplierName']) ?></td>
        </tr>
        <tr>
            <th>Quantity Per Unit</th>
            <td><?= htmlspecialchars($product['QuantityPerUnit']) ?></td>
        </tr>
        <tr>
            <th>Unit Price</th>
            <td>$<?= number_format($product['UnitPrice'], 2) ?></td>
        </tr>
        <tr>
            <th>Units In Stock</th>
            <td><?= $product['UnitsInStock'] ?></td>
        </tr>
        <tr>
            <th>Units On Order</th>
            <td><?= $product['UnitsOnOrder'] ?></td>
        </tr>
        <tr>
            <th>Discontinued</th>
            <td><?= $product['Discontinued'] ? 'Ya' : 'Tidak' ?></td>
        </tr>
    </table>

    <hr>
    <h3>Beli Produk</h3>

    <form action="cart.php" method="POST">
        <input type="hidden" name="productid" value="<?= $product['ProductID'] ?>">
        <input type="hidden" name="productname" value="<?= htmlspecialchars($product['ProductName']) ?>">
        <input type="hidden" name="unitprice" value="<?= $product['UnitPrice'] ?>">

        <label for="jumlah">Jumlah yang ingin dibeli: </label>
        <input type="number" id="jumlah" name="jumlah" min="1" max="<?= $product['UnitsInStock'] ?>" value="1" required>

        <br><br>
        <input type="submit" value="Beli / Masuk Keranjang">
    </form>

    <p><a href="produk.php"> << Kembali Ke daftar produk</a></p>

    <?php mysqli_close($conn); ?>

</body>
</html>