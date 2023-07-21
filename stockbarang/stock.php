<?php
require 'function.php';
require 'cek.php';

$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Stock Barang Awal</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            .zoomable{
                width: 100px;
            }
            .zoomable:hover{
                transform: scale(1.5);
                transition: 0.3s ease;
            }

            a{
                text-decoration:none;
                color:white;
            }
        </style>    

    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php"><strong>PERMATA HPL</strong></a> 
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <?=$email;?>
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
                        <h1 class="mt-4">Stock Barang Awal</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Tambah Barang Awal
                                </button>
                                <a href="exportstockawal.php" class="btn btn-info">Export Data</a>
                            </div>
                            <div class="card-body">

                            <?php
                                $ambildataawal = mysqli_query($conn,"select * from stock where stock < 1");

                                while($fetch=mysqli_fetch_array($ambildataawal)){
                                    $namastock = $fetch['namastock'];
                                

                            ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>PERHATIAN!</strong> Stock <?=$namastock;?> Telah Habis
                            </div>

                            <?php
                                }
                            ?>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Gambar</th>
                                                <th>Nama Barang</th>
                                                <th>Tanggal</th>
                                                <th>Deskripsi</th>
                                                <th>Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $ambilsemuadataawal = mysqli_query($conn,"select * from stockawal order by namastock ASC");
                                            $i = 1;
                                            while($data=mysqli_fetch_array($ambilsemuadataawal)){
                                                $namastock = $data['namastock'];
                                                $tanggal = $data['tanggal'];
                                                $deskripsi = $data['deskripsi'];
                                                $stockawalan = $data['stockawalan'];
                                                $idstock = $data['idstock'];

                                                //cek ada gambar atau tidak
                                                $gambar = $data['image']; //ambil gambar
                                                if($gambar==null){
                                                    //jika tidak ada gambar
                                                    $image = 'No Photo';
                                                } else {
                                                    //jika ada gambar
                                                    $image = '<img src="images/'.$gambar.'"class="zoomable">';
                                                }

                                            ?>

                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$image;?></td>
                                                <td><?=$namastock;?></td>
                                                <td><?=$tanggal;?></td>
                                                <td><?=$deskripsi;?></td>
                                                <td><?=$stockawalan;?></td>
                                                
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

        <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Tambah Barang Awal</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <form method="post" enctype="multipart/form-data">
            <div class="modal-body">
            <input type="text" name="namastock" placeholder="Nama Stock" class="form-control" required>
            <br>
            <input type="text" name="deskripsi" placeholder="Deskripsi Barang" class="form-control" required> 
            <br>
            <input type="number" name="stockawalan" placeholder="Jumlah" class="form-control" required>
            <br>
            <input type="file" name="file" class="form-control">
            <br>
            <button type="submit" class="btn btn-primary" name="addnewstock">Submit</button>
            </div>
            </form>
            
        </div>
        </div>
    </div> 

</html>