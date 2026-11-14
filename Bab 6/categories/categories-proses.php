<?php
include '../koneksi.php';

function upload() {
    $namaFile = $_FILES['photo']['name'];
    $error    = $_FILES['photo']['error'];
    $tmpName  = $_FILES['photo']['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if($error === 4) {
        echo "
            <script>
                alert('Gambar Harus Diisi');
                window.location = 'categories-entry.php';
            </script>
        ";
        return false;
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if(!in_array($ekstensiGambar, $ekstensiValid)) {
        echo "
            <script>
                alert('File Harus Berupa Gambar');
                window.location = 'categories-entry.php';
            </script>
        ";
        return false;
    }

    // lolos pengecekan, upload gambar dengan nama baru
    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;

    if(!move_uploaded_file($tmpName, '../img_categories/' . $namaFileBaru)) {
        echo "
            <script>
                alert('Gagal Mengupload Gambar');
                window.location = 'categories-entry.php';
            </script>
        ";
        return false;
    }

    return $namaFileBaru;
}

if(isset($_POST['simpan'])) {
    $categories  = mysqli_real_escape_string($koneksi, $_POST['categories']);
    $price       = mysqli_real_escape_string($koneksi, $_POST['price']);
    $description = mysqli_real_escape_string($koneksi, $_POST['description']);

    // cek data dulu sebelum upload
    if(empty($categories) || empty($price) || empty($description)) {
        echo "
            <script>
                alert('Pastikan Anda Mengisi Semua Data');
                window.location = 'categories-entry.php';
            </script>
        ";
        exit;
    }

    $photo = upload();
    if($photo === false) {
        exit;
    }

    $sql = "INSERT INTO tb_categories (photo, categories, price, description)
            VALUES ('$photo', '$categories', '$price', '$description')";

    if(mysqli_query($koneksi, $sql)) {
        echo "
            <script>
                alert('Data Categories Berhasil Ditambahkan');
                window.location = 'categories.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Terjadi Kesalahan: " . addslashes(mysqli_error($koneksi)) . "');
                window.location = 'categories-entry.php';
            </script>
        ";
    }

} elseif(isset($_POST['edit'])) {
    $id          = (int) $_POST['id'];
    $categories  = mysqli_real_escape_string($koneksi, $_POST['categories']);
    $price       = mysqli_real_escape_string($koneksi, $_POST['price']);
    $description = mysqli_real_escape_string($koneksi, $_POST['description']);
    $photoLama   = $_POST['photoLama'];

    // jika user tidak memilih gambar baru, pakai foto lama
    if($_FILES['photo']['error'] === 4) {
        $photo = $photoLama;
    } else {
        $photo = upload();
        if($photo === false) {
            exit;
        }
        // hapus foto lama setelah foto baru berhasil diupload
        if(file_exists('../img_categories/' . $photoLama)) {
            unlink('../img_categories/' . $photoLama);
        }
    }

    $sql = "UPDATE tb_categories SET
            photo       = '$photo',
            categories  = '$categories',
            price       = '$price',
            description = '$description'
            WHERE id = $id";

    if(mysqli_query($koneksi, $sql)) {
        echo "
            <script>
                alert('Data Categories Berhasil Diubah');
                window.location = 'categories.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Terjadi Kesalahan: " . addslashes(mysqli_error($koneksi)) . "');
                window.location = 'categories-edit.php';
            </script>
        ";
    }

} elseif(isset($_POST['hapus'])) {
    $id = (int) $_POST['id'];

    // ambil nama foto untuk dihapus dari folder
    $result = mysqli_query($koneksi, "SELECT photo FROM tb_categories WHERE id = $id");
    $row    = mysqli_fetch_assoc($result);

    if($row) {
        $photo = $row['photo'];
        if(file_exists('../img_categories/' . $photo)) {
            unlink('../img_categories/' . $photo);
        }
    }

    if(mysqli_query($koneksi, "DELETE FROM tb_categories WHERE id = $id")) {
        echo "
            <script>
                alert('Data Categories Berhasil Dihapus');
                window.location = 'categories.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Categories Gagal Dihapus');
                window.location = 'categories.php';
            </script>
        ";
    }

} else {
    header('location: categories.php');
    exit;
}