<?php

include 'koneksi.php';

$query = "SELECT CategoryID, CategoryName, Description FROM Categories ORDER  BY CategoryName";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Selamat Datang</h1>
    <h2>Daftar Kategori</h2>

    <?php if(mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <a href="produk.php?categoryid=<?= $row['CatagoryID'] ?>">
                                <?= htmlspecialchars($row['CategoryName']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($row['Description']) ?></td>
                    </tr>
                    <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada data untuk ditampilkan.</p>
    <?php endif; ?>

    <?php mysqli_close($conn); ?>
</body>
</html>