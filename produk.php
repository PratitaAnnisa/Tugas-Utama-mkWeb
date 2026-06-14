<?php
    include 'koneksi.php';

    if(!isset($_GET['categoryid']) || !is_numeric($_GET['categoryid'])){
        header("Location: index.php");
        exit;
    }

    $categoryid = (int) $_GET['categoryid'];

    $q_cat = "SELECT CategoryID, CategoryName FROM Categories WHERE CategoryID = $categoryid";
    $r_cat = mysqli_query($conn, $q_cat);

    if(mysqli_num_rows($r_cat) == 0){
        header("Location: index.php");
        exit;
    }

    $category = mysqli_fetch_assoc($r_cat);

    $q_prod = "SELECT ProductID, ProductName, UnitPrice FROM Products WHERE CategoryID = $categoryid ORDER BY ProductName";
    $r_prod = mysqli_query($conn, $q_prod);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk: <?= htmlspecialchars($category['CategoryName']) ?></title>
</head>
<body>
    <h1>Berikut Daftar Produk <?= htmlspecialchars($category['CategoryName']) ?></h1>

    <?php if (mysqli_num_rows($r_prod) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ProductID</th>
                    <th>ProductName</th>
                    <th>UnitPrice</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($r_prod)): ?>
                    <tr>
                        <td><?= $row['ProductID'] ?></td>
                        <td>
                            <a href="detail.php?productid=<?= $row['ProductID'] ?>">
                                <?= htmlspecialchars($row['ProductName']) ?>
                            </a>
                        </td>
                        <td>$<?= number_format($row['UnitPrice'], 2) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada Produk untuk ditampilkan</p>
    <?php endif; ?>

    <?php mysqli_close($conn); ?>
</body>
</html>