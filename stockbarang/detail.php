<?php
require 'function.php';
require 'cek.php';

//Dapetin ID barang yang dimasukkan dihalaman sebelumnya
$idbarang = $_GET['id']; //GET id barang
//Get Informasi Barang berdasarkan Database
$get = mysqli_query($conn,"select * from stock where idbarang='$idbarang'");
$fetch = mysqli_fetch_assoc($get);
//Set Variable
$namabarang = $fetch['namabarang'];
$deskripsi = $fetch['deskripsi'];
$stock = $fetch['stock'];

//cek ada gambar atau tidak
$gambar = $fetch['image']; //ambil gambar
if($gambar==null){
    //jika tidak ada gambar
    $img = 'No Photo';
} else {
    //jika ada gambar
    $img = '<img src="images/'.$gambar.'"class="zoomable">';
}


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Stock - Detail Barang</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            .zoomable{
                width: 150px;
                height: 200px;
            }
            .zoomable:hover{
                transform: scale(1.2);
                transition: 0.3s ease;
            }
        </style>    

    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">PERMATA HPL</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
         
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                        <a class="nav-link" href="stock.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                                Stock Barang Awal
                            </a>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                                Stock Barang Akhir
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-cart-plus"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-cart-plus"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="supplier.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Data Supplier
                            </a>
                            <a class="nav-link" href="admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Data Admin
                            </a>
                            <a class="nav-link" href="logout.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-power-off"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Detail Barang</h1>
                       
                        
                        <div class="card mb-4 mt-4">
                            <div class="card-header">
                              <h2><?=$namabarang;?></h2>
                                <?=$img;?>
                            </div>
                            <div class="card-body">

                            <div class="row">
                            <div class="col-md-3"><strong>Deskripsi</strong></div>
                                <div class="col-md-9">: <?=$deskripsi;?></div>
                            </div>

                            <div class="row">
                                <div class="col-md-3"><strong>Stock</strong></div>
                                <div class="col-md-9">: <?=$stock;?></div>
                            </div>

                            <br><br><hr>

                                <h3>Barang Masuk</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="barangmasuk" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Supplier</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                           $ambildatamasuk = mysqli_query($conn,"select * from masuk where idbarang='$idbarang'");
                                            $i = 1;

                                           while($fetch=mysqli_fetch_array($ambildatamasuk)){
                                               $tanggal = $fetch['tanggal'];
                                               $namasupplier = $fetch['namasupplier'];
                                               $kuantitas = $fetch['kuantitas'];

                                            ?>

                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$tanggal;?></td>
                                                <td><?=$namasupplier;?></td>
                                                <td><?=$kuantitas;?></td>
                                            </tr>


                                            <?php
                                            };
                                            ?>

                                        </tbody>
                                    </table>
                                </div>

                                <br><br>

                                    <h3>Barang Keluar</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="barangkeluar" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Pelanggan</th>
                                                <th>Kuantitas</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                           $ambildatakeluar = mysqli_query($conn,"select * from keluar where idbarang='$idbarang'");
                                            $i = 1;

                                           while($fetch=mysqli_fetch_array($ambildatakeluar)){
                                               $tanggal = $fetch['tanggal'];
                                               $penerima = $fetch['penerima'];
                                               $kuantitas = $fetch['kuantitas'];

                                            ?>

                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$tanggal;?></td>
                                                <td><?=$penerima;?></td>
                                                <td><?=$kuantitas;?></td>
                                            </tr>


                                            <?php
                                            };

                                            ?>

                                        </tbody>
                                    </table>
                                </div>    


                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>