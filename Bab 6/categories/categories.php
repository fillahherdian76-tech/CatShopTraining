<?php
session_start();
if (empty($_SESSION['username'])) {
    header('location:../login.php');
    exit;
}
include '../koneksi.php';
$result = mysqli_query($koneksi, "SELECT * FROM tb_categories");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" href="../assets/icon.png" />
    <link rel="stylesheet" href="../css/admin.css" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Catshop Admin | Categories</title>

	<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-header h3 {
        margin: 0;
    }
    .btn-tambah {
        display: inline-block;
        padding: 10px 20px;
        background: #ffb62e;
        color: #fff;
        border-radius: 6px;
        text-decoration: none;
    }
    .table-wrapper {
        overflow-x: auto;
        background: #fff;
        border-radius: 8px;
    }
    .table-data {
        width: 100%;
        border-collapse: collapse;
    }
    .table-data th,
    .table-data td {
        border: 1px solid #ddd;
        padding: 12px;
        vertical-align: middle;
    }
    .table-data th {
        background: #f7f7f7;
        font-weight: 600;
    }
    .text-center {
        text-align: center;
    }
    .thumb {
        width: 160px;
        height: 110px;
        object-fit: cover;
        border-radius: 6px;
    }
    .action-group {
        display: flex;
        justify-content: center;
        gap: 8px;
    }
    .btn-action {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 6px;
        color: #fff;
        text-decoration: none;
        font-size: 14px;
    }
    .btn-edit {
        background: #4caf50;
    }
    .btn-delete {
        background: #f44336;
    }
</style>
</head>
<body>
    <div class="sidebar">
        <div class="logo-details">
            <i class="bx bx-category"></i>
            <span class="logo_name">CatShop</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="../admin.php">
                    <i class="bx bx-grid-alt"></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="../categories/categories.php" class="active">
                    <i class="bx bx-box"></i>
                    <span class="links_name">Categories</span>
                </a>
            </li>
            <li>
                <a href="../transaction/transaction.php">
                    <i class="bx bx-list-ul"></i>
                    <span class="links_name">Transaction</span>
                </a>
            </li>
            <li>
                <a href="../logout.php">
                    <i class="bx bx-log-out"></i>
                    <span class="links_name">Log out</span>
                </a>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class="bx bx-menu sidebarBtn"></i>
            </div>
            <div class="profile-details">
                <span class="admin_name">Catshop Admin</span>
            </div>
        </nav>
        <div class="home-content">
   <div class="home-content">
    <div class="page-header">
        <h3>Categories</h3>
        <a href="categories-entry.php" class="btn btn-tambah">Tambah Data</a>
    </div>

    <div class="table-wrapper">
        <table class="table-data">
            <thead>
                <tr>
                    <th style="width: 20%">Photo</th>
                    <th style="width: 15%">Categories</th>
                    <th style="width: 30%">Description</th>
                    <th style="width: 15%">Price</th>
                    <th style="width: 20%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) == 0): ?>
                    <tr>
                        <td colspan="5" class="text-center">Data Kosong</td>
                    </tr>
                <?php endif; ?>

                <?php while ($data = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td class="text-center">
                            <img class="thumb" src="../img_categories/<?= htmlspecialchars($data['photo']) ?>" alt="">
                        </td>
                        <td class="text-center"><?= htmlspecialchars($data['categories']) ?></td>
                        <td class="text-center"><?= htmlspecialchars($data['description']) ?></td>
                        <td class="text-center">Rp <?= number_format((float) $data['price'], 0, ',', '.') ?></td>
                        <td class="text-center">
                            <div class="action-group">
                                <a class="btn-action btn-edit" href="categories-edit.php?id=<?= $data['id'] ?>">Edit</a>
                                <a class="btn-action btn-delete" href="categories-hapus.php?id=<?= $data['id'] ?>">Hapus</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
    </section>
    <script>
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".sidebarBtn");
        sidebarBtn.onclick = function () {
            sidebar.classList.toggle("active");
            if (sidebar.classList.contains("active")) {
                sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        };
    </script>
</body>
</html>