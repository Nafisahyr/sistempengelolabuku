<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "uhddg";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$judul         = "";
$pengarang     = "";
$tahunterbit   = "";  
$sukses        = "";
$error         = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from isi where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1          = "select * from isi where id = '$id'";
    $q1            = mysqli_query($koneksi, $sql1);
    $r1            = mysqli_fetch_array($q1);
    $judul         = $r1['Judul'];
    $pengarang     = $r1['Pengarang'];
    $tahunterbit   = $r1['Tahun_terbit'];

    if ($judul == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { 
    $judul         = $_POST['Judul'];
    $pengarang     = $_POST['Pengarang'];
    $tahunterbit   = $_POST['Tahun_terbit'];

    if ($judul && $pengarang && $tahunterbit) {
        if ($op == 'edit') { 
            $sql1       = "update isi set Judul ='$judul',Pengarang = '$pengarang',Tahun_terbit='$tahunterbit' where  id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { 
            $sql1   = "insert into isi (Judul,Pengarang,Tahun_terbit) values ('$judul','$pengarang','$tahunterbit')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>

        body {
            background-color: #D6E6F2;
            font-family: 'poppins';
        }

        .mx-auto {
            width: 700px
        }

        h1{
           
            margin-top: 60px;
            text-align: center;
            color: #769FCD;
            font-size: 50px;
        }

        .card {
            margin-top: 90px;
            margin-bottom: 40px;  
            background-color: #F7FBFC;
        }

        .card-header{
            text-align: center;
            background-color: #769FCD;

        }

    </style>
</head>

<body>
  <h1>SISTEM <BR> PENGELOLA BUKU</h1>
    <div class="mx-auto">
        <div class="card">
          <div class="card-header text-white">
                ISI DATA
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:0;url=index.php");
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:0;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Judul" name="Judul" value="<?php echo $judul ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="pengarang" class="col-sm-2 col-form-label">Pengarang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Pengarang" name="Pengarang" value="<?php echo $pengarang ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tahun terbit" class="col-sm-2 col-form-label">Tahun terbit</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Tahun_terbit" name="Tahun terbit" value="<?php echo $tahunterbit ?>">
                        </div>
                    </div>
                    <div class="col-12 ">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header text-white">
                DATA BUKU
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Judul</th>
                            <th scope="col">Pengarang</th>
                            <th scope="col">Tahun terbit</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from isi order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id              = $r2['id'];
                            $judul           = $r2['Judul'];
                            $pengarang       = $r2['Pengarang'];
                            $tahunterbit     = $r2['Tahun_terbit'];
                        ?>
                            <tr>
                                <td scope="row"><?php echo $judul ?></td>
                                <td scope="row"><?php echo $pengarang ?></td>
                                <td scope="row"><?php echo $tahunterbit ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>

</html>