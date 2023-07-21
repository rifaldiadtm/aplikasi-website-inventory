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
        <title>Data Supplier</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>  

    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="supplier.php">PERMATA HPL</a> 
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
                        <h1 class="mt-4">Data Supplier</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Tambah Supplier
                                </button>
                            </div>
                            <div class="card-body">


                            <?php
                               
                            ?>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Supplier</th>
                                                <th>Nama Barang</th>
                                                <th>Alamat Supplier</th>
                                                <th>No Telepon</th>
                                                <th>Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $ambildatasupplier = mysqli_query($conn,"select * from supplier");
                                            $i = 1;
                                            while($data=mysqli_fetch_array($ambildatasupplier)){
                                                $namasupplier = $data['namasupplier'];
                                                $namabarang = $data['namabarang'];
                                                $alamat = $data['alamat'];
                                                $notlp = $data['notlp'];
                                                $idsupplier = $data['idsupplier'];
                                                
                                            ?>

                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$namasupplier;?></td>
                                                <td><?=$namabarang;?></td>
                                                <td><?=$alamat;?></td>
                                                <td><?=$notlp;?></td>
                                                <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idsupplier;?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idsupplier;?>">
                                                    Delete
                                                </button>
                                                </td>
                                            </tr>

                                             <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?=$idsupplier;?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Edit Supplier</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <form method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                    <input type="text" name="namasupplier" value="<?=$namasupplier;?>" class="form-control" required>
                                                    <br>
                                                    <input type="text" name="namabarang" value="<?=$namabarang;?>" class="form-control" required> 
                                                    <br>
                                                    <input type="text" name="alamat" value="<?=$alamat;?>" class="form-control" required>
                                                    <br>
                                                    <input type="text" name="notlp" value="<?=$notlp;?>" class="form-control" required>
                                                    <br>
                                                    <input type="hidden" name="idsupplier" value="<?=$idsupplier;?>">
                                                    <button type="submit" class="btn btn-primary" name="updatesupplier">Submit</button>
                                                    </div>
                                                    </form>
                                                    
                                                </div>
                                                </div>
                                            </div>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="delete<?=$idsupplier;?>">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Data Supplier? </h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <form method="post">
                                                    <div class="modal-body">
                                                    Apakah Anda Yakin Ingin Menghapus <?=$namasupplier;?>?
                                                    <input type="hidden" name="idsupplier" value="<?=$idsupplier;?>">
                                                    <br>
                                                    <br>
                                                    <button type="submit" class="btn btn-danger" name="hapussupplier">Hapus</button>
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
            <h4 class="modal-title">Tambah Data Supplier</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <form method="post" enctype="multipart/form-data">
            <div class="modal-body">
            <input type="text" name="namasupplier" placeholder="Nama Supplier" class="form-control" required>
            <br>
            <input type="text" name="namabarang" placeholder="Nama Barang" class="form-control" required> 
            <br>
            <input type="text" name="alamat" placeholder="Alamat Supplier" class="form-control" required> 
            <br>
            <input type="text" name="notlp" placeholder="No Telepon" class="form-control" required>
            <br>
            <button type="submit" class="btn btn-primary" name="addnewsupplier">Submit</button>
            </div>
            </form>
            
        </div>
        </div>
    </div>

</html>