<?php
require 'function.php';
require 'cek.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Barang Masuk</title>
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
                        <h1 class="mt-4">Barang Masuk</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Tambah Barang Masuk
                                </button>
                                <a href="exportmasuk.php" class="btn btn-info">Export Data</a>
                                <div class="row mt-4">
                                    <div class="col">
                                </div>
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Gambar</th>
                                                <th>Nama Barang</th>
                                                <th>Tanggal</th>
                                                <th>Jumlah</th>
                                                <th>Supplier</th>
                                                <th>Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    
                                        <?php
                                                $ambilsemuadata = mysqli_query(
                                                    $conn,
                                                    "SELECT bm.tanggal, s.namabarang AS nama_barang, bm.namasupplier, bm.kuantitas, s.image, bm.idmasuk, s.idbarang
                                                    FROM masuk bm
                                                    JOIN stock s ON bm.idbarang = s.idbarang
                                                    "
                                                );
                                                $i = 1;
                                            while($data=mysqli_fetch_array($ambilsemuadata)){
                                                $idb = $data['idbarang'];
                                                $idm = $data['idmasuk'];
                                                $tanggal = $data['tanggal'];
                                                $namabarang = $data['nama_barang'];
                                                $kuantitas = $data['kuantitas'];
                                                $namasupplier = $data['namasupplier'];
                                

                                                 //cek ada gambar atau tidak
                                                 $gambar = $data['image']; //ambil gambar
                                                 if($gambar==null){
                                                     //jika tidak ada gambar
                                                     $img = 'No Photo';
                                                 } else {
                                                     //jika ada gambar
                                                     $img = '<img src="images/'.$gambar.'"class="zoomable">';
                                                 }

                                            ?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$img;?></td>
                                                <td><?=$namabarang;?></td>
                                                <td><?=$tanggal;?></td>
                                                <td><?=$kuantitas;?></td>
                                                <td><?=$namasupplier;?></td>
                                                <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idm;?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idm;?>">
                                                    Delete
                                                </button>
                                                </td>
                                            </tr>

                                             <!-- Edit Modal -->
                                             <div class="modal fade" id="edit<?=$idm;?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Edit Barang</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <form method="post">
                                                    <div class="modal-body">
                                                    <input type="number" name="kuantitas" value="<?=$kuantitas;?>" class="form-control" required> 
                                                    <br>
                                                    <input type="hidden" name="idb" value="<?=$idb;?>">
                                                    <input type="hidden" name="idm" value="<?=$idm;?>">
                                                    <button type="submit" class="btn btn-primary" name="updatebarangmasuk">Submit</button>
                                                    </div>
                                                    </form>
                                                    
                                                </div>
                                                </div>
                                            </div>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="delete<?=$idm;?>">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Barang? </h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <form method="post">
                                                    <div class="modal-body">
                                                    Apakah Anda Yakin Ingin Menghapus <?=$namabarang;?>?
                                                    <input type="hidden" name="idb" value="<?=$idb;?>">
                                                    <input type="hidden" name="kty" value="<?=$kuantitas;?>">
                                                    <input type="hidden" name="idm" value="<?=$idm;?>">
                                                    <br>
                                                    <br>
                                                    <button type="submit" class="btn btn-danger" name="hapusbarangmasuk">Hapus</button>
                                                    </div>
                                                    </form>
                                                    
                                                </div>
                                                </div>
                                            </div>

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
            <h4 class="modal-title">Tambah Barang Masuk</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <form method="post">
            <div class="modal-body">

            <select name="barangnya" class="form-control">
                <?php
                        $ambilsemuadatanya = mysqli_query($conn,"select * from stock order by namabarang");
                        while($fetcharray = mysqli_fetch_array($ambilsemuadatanya)){
                            $namabarangnya = $fetcharray['namabarang'];
                            $idbarangnya = $fetcharray['idbarang'];
                        
                ?>

                <option value="<?=$idbarangnya;?>"><?=$namabarangnya;?></option>
                    
                <?php     
                    }
                ?>
                </select>

            <br>
            <input type="number" name="kuantitas" placeholder="Kuantitas" class="form-control" required>
            <br>
            <select name="suppliernya" class="form-control">
                <?php
                        $ambilsemuadatanya = mysqli_query($conn,"select * from supplier order by idsupplier");
                        while($fetcharray = mysqli_fetch_array($ambilsemuadatanya)){
                            $namasupplier = $fetcharray['namasupplier'];
                            $idsupplier = $fetcharray['idsupplier'];
                ?>

                <option value="<?=$namasupplier;?>"><?=$namasupplier;?></option>

                <?php     
                    }
                ?>
                </select>
            
            <br>
            <button type="submit" class="btn btn-primary" name="barangmasuk">Submit</button>
            </div>
            </form>
            
        </div>
        </div>
    </div>

</html>