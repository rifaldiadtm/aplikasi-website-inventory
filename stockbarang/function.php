<?php
session_start();

//Membuat koneksi ke database
$conn = mysqli_connect("localhost","root","","stockbarang");

//Menambahkan Barang STOCK AWAL
if(isset($_POST['addnewstock'])){
    $namastock = $_POST['namastock'];
    $deskripsi = $_POST['deskripsi'];
    $stockawalan = $_POST['stockawalan'];

//Soal Gambar
$allowed_extension = array('png','jpg');
$nama = $_FILES['file']['name']; //Mengambil nama File Gambar
$dot = explode('.', $nama);
$ekstensi = strtolower(end($dot)); //Mengambil Ekstensinya
$ukuran = $_FILES['file']['size']; //Mengambil Size dari File
$file_tmp = $_FILES['file']['tmp_name']; //Mengambil lokasi Filenya

//Penamaan File -> enkripsi
$image = md5(uniqid($nama,true) . time()).'.'.$ekstensi; //Menggabungkan nama file yang di enkripsi dengan ekstensinya

 //proses upload gambar
 if(in_array($ekstensi, $allowed_extension) === true){
    //validasi ukuran filenya
    if($ukuran < 20000000){
        move_uploaded_file($file_tmp, 'images/'.$image);

        $addtotable = mysqli_query($conn,"insert into stockawal (namastock, deskripsi, stockawalan, image) values ('$namastock','$deskripsi','$stockawalan', '$image')");
        if($addtotable){
            header('location:stock.php');
        } else {
            echo 'Input Gagal';
            header('location:stock.php');
        }
    } else {
        //kalau filenya lebih dari 20 mb
        echo '
    <script>
        alert("Ukuran terlalu Besar");
        window.location.href="stock.php";
    </script>
        ';
    }
} else {
    //Jikalau File tidak png atau jpg
    echo '
    <script>
        alert("File harus png atau jpg");
        window.location.href="stock.php";
    </script>
        ';
}

};

//Update Info Barang AWAL
if(isset($_POST['updatebarang'])){
    $idstock = $_POST['idstock'];
    $namastock = $_POST['namastock'];
    $deskripsi = $_POST['deskripsi'];
    
    //Soal Gambar
    $allowed_extension = array('png','jpg');
    $nama = $_FILES['file']['name']; //Mengambil nama File Gambar
    $dot = explode('.', $nama);
    $ekstensi = strtolower(end($dot)); //Mengambil Ekstensinya
    $ukuran = $_FILES['file']['size']; //Mengambil Size dari File
    $file_tmp = $_FILES['file']['tmp_name']; //Mengambil lokasi Filenya 

    //Penamaan File -> enkripsi
    $image = md5(uniqid($nama,true) . time()).'.'.$ekstensi; //Menggabungkan nama file yang di enkripsi dengan ekstensinya

    if($ukuran==0){
        //jika tidak ingin upload
        $update = mysqli_query($conn,"update stockawal set namastock='$namastock', deskripsi='$deskripsi' where idstock='$idstock'");
        if($update){
            header('location:stock.php');
        } else {
            echo 'Input Gagal';
            header('location:stock.php');
        }
    } else {
        //jika ingin upload
        move_uploaded_file($file_tmp, 'images/'.$image);
        $update = mysqli_query($conn,"update stock set namastock='$namastock', deskripsi='$deskripsi', image='$image' where idstock='$idstock'");
        if($update){
            header('location:stock.php');
        } else {
            echo 'Input Gagal';
            header('location:stock.php');
        }
    }
}






//Menambahkan Barang Baru
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    
    //Soal Gambar
    $allowed_extension = array('png','jpg');
    $nama = $_FILES['file']['name']; //Mengambil nama File Gambar
    $dot = explode('.', $nama);
    $ekstensi = strtolower(end($dot)); //Mengambil Ekstensinya
    $ukuran = $_FILES['file']['size']; //Mengambil Size dari File
    $file_tmp = $_FILES['file']['tmp_name']; //Mengambil lokasi Filenya 

    //Penamaan File -> enkripsi
    $image = md5(uniqid($nama,true) . time()).'.'.$ekstensi; //Menggabungkan nama file yang di enkripsi dengan ekstensinya

    //proses upload gambar
    if(in_array($ekstensi, $allowed_extension) === true){
        //validasi ukuran filenya
        if($ukuran < 20000000){
            move_uploaded_file($file_tmp, 'images/'.$image);

            $addtotable = mysqli_query($conn,"insert into stock (namabarang, deskripsi, stock, image) values ('$namabarang','$deskripsi','$stock', '$image')");
            if($addtotable){
                header('location:index.php');
            } else {
                echo 'Input Gagal';
                header('location:index.php');
            }
        } else {
            //kalau filenya lebih dari 20 mb
            echo '
        <script>
            alert("Ukuran terlalu Besar");
            window.location.href="index.php";
        </script>
            ';
        }
    } else {
        //Jikalau File tidak png atau jpg
        echo '
        <script>
            alert("File harus png atau jpg");
            window.location.href="index.php";
        </script>
            ';
    }

};


//Menambahkan Barang Masuk
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $suppliernya = $_POST['suppliernya'];
    $kuantitas = $_POST['kuantitas'];

    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang= '$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);
  
    $stocksekarang = $ambildatanya['stock'];
    $tambahkanStockSekarangDenganKuantitas = $stocksekarang+$kuantitas;

    $addtomasuk = mysqli_query($conn,"insert into masuk(idbarang, namasupplier, kuantitas) values('$barangnya', '$suppliernya','$kuantitas')");
    $updatestockmasuk = mysqli_query($conn,"update stock set stock='$tambahkanStockSekarangDenganKuantitas' where idbarang='$barangnya'");
    
    if($addtomasuk&&$updatestockmasuk){
        header('location:masuk.php');
    } else {
        echo 'Input Gagal';
        header('location:masuk.php');
    }
}


//Menambahkan Barang Keluar
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $kuantitas = $_POST['kuantitas'];

    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang= '$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];

    if($stocksekarang >= $kuantitas){
        //Kalau Stock Barangnya cukup
        $tambahkanstocksekarangdengankuantitas = $stocksekarang-$kuantitas;

        $addtokeluar = mysqli_query($conn,"insert into keluar(idbarang,penerima,kuantitas) values('$barangnya','$penerima','$kuantitas')");
        $updatestockkeluar = mysqli_query($conn,"update stock set stock='$tambahkanstocksekarangdengankuantitas' where idbarang='$barangnya'");
        if($addtokeluar&&$updatestockkeluar){
            header('location:keluar.php');
        } else {
            echo 'Input Gagal';
            header('location:keluar.php');
        }
    } else{
        //Kalau Stock Barangnya tidak cukup
        echo '
        <script>
            alert("Stock saat ini tidak mencukupi");
            window.location.href="keluar.php"
        </script>
        ';
    }

}



//Update Info Barang
if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    
    //Soal Gambar
    $allowed_extension = array('png','jpg');
    $nama = $_FILES['file']['name']; //Mengambil nama File Gambar
    $dot = explode('.', $nama);
    $ekstensi = strtolower(end($dot)); //Mengambil Ekstensinya
    $ukuran = $_FILES['file']['size']; //Mengambil Size dari File
    $file_tmp = $_FILES['file']['tmp_name']; //Mengambil lokasi Filenya 

    //Penamaan File -> enkripsi
    $image = md5(uniqid($nama,true) . time()).'.'.$ekstensi; //Menggabungkan nama file yang di enkripsi dengan ekstensinya

    if($ukuran==0){
        //jika tidak ingin upload
        $update = mysqli_query($conn,"update stock set namabarang='$namabarang', deskripsi='$deskripsi' where idbarang='$idb'");
        if($update){
            header('location:index.php');
        } else {
            echo 'Input Gagal';
            header('location:index.php');
        }
    } else {
        //jika ingin upload
        move_uploaded_file($file_tmp, 'images/'.$image);
        $update = mysqli_query($conn,"update stock set namabarang='$namabarang', deskripsi='$deskripsi', image='$image' where idbarang='$idb'");
        if($update){
            header('location:index.php');
        } else {
            echo 'Input Gagal';
            header('location:index.php');
        }
    }
}


//Menghapus Barang dari Stock
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb']; //idbarang

    $gambar = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $get = mysqli_fetch_array($gambar);
    $img = 'images/'.$get['image'];
    unlink($img);

    $hapus = mysqli_query($conn, "delete from stock where idbarang='$idb'");
    if($hapus){
        header('location:index.php');
    } else {
        echo 'Input Gagal';
        header('location:index.php');
    }
};



//Mengubah Data Barang Masuk
if(isset($_POST['updatebarangmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $kuantitas = $_POST['kuantitas'];

    $lihatstock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $queryMasuk = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $kuantitasnya = mysqli_fetch_array($queryMasuk);
    $kuantitasskrng = $kuantitasnya['kuantitas'];

    if($kuantitas>$kuantitasskrng){
        $selisih = $kuantitas-$kuantitasskrng;
        $kurangin = $stockskrng + $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set kuantitas='$kuantitas' where idmasuk='$idm'");
            if($kurangistocknya&&$updatenya){
                header('location:masuk.php');
                } else {
                echo 'Input Gagal';
                header('location:masuk.php');
            }
    } else {
        $selisih = $kuantitasskrng-$kuantitas;
        $kurangin = $stockskrng - $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set kuantitas='$kuantitas' where idmasuk='$idm'");
            if($kurangistocknya&&$updatenya){
                header('location:masuk.php');
                } else {
                echo 'Input Gagal';
                header('location:masuk.php');
            }
    }

}



//Menghapus Barang Masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $kuantitas = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock - $kuantitas;

    $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdatanya = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");

    if($update&&$hapusdatanya){
        header('location:masuk.php');
    }   else{
        header('location:masuk.php');
    }
}



// Mengubah Data Barang Keluar
if(isset($_POST['updatebarangkeluar'])){
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $kuantitas = $_POST['kuantitas'];

    $lihatstock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $kuantitasskrng = mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
    $kuantitasnya = mysqli_fetch_array($kuantitasskrng);
    $kuantitasskrng = $kuantitasnya['kuantitas'];

    if($kuantitas>$kuantitasskrng){
        $selisih = $kuantitas-$kuantitasskrng;
        $kurangin = $stockskrng - $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set kuantitas='$kuantitas', penerima='$penerima' where idkeluar='$idk'");
            if($kurangistocknya&&$updatenya){
                header('location:keluar.php');
                } else {
                echo 'Input Gagal';
                header('location:keluar.php');
            }
    } else {
        $selisih = $kuantitasskrng-$kuantitas;
        $kurangin = $stockskrng + $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set kuantitas='$kuantitas', penerima='$penerima' where idkeluar='$idk'");
            if($kurangistocknya&&$updatenya){
                header('location:keluar.php');
                } else {
                echo 'Input Gagal';
                header('location:keluar.php');
            }
    }

}



//Menghapus Barang Keluar
if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];
    $kuantitas = $_POST['kuantitas'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock + $kuantitas;

    $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdatanya = mysqli_query($conn, "delete from keluar where idkeluar='$idk'");

    if($update&&$hapusdatanya){
        header('location:keluar.php');
    }   else{
        header('location:keluar.php');
    }

}


//Menambahkan Admin Baru
if(isset($_POST['addadmin'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $queryinsert = mysqli_query($conn,"insert into login (email, password) values ('$email','$password')");

    if($queryinsert){
        //if berhasil
        header('location:admin.php');

    } else {
        //Kalau gagal insert ke database
        header('location:admin.php');
    }
}


//Edit Data Admin
if(isset($_POST['updateadmin'])){
    $emailbaru = $_POST['emailadmin'];
    $passwordbaru = $_POST['passwordbaru'];
    $idnya = $_POST['id'];

    $queryupdate = mysqli_query($conn,"update login set email='$emailbaru', password='$passwordbaru' where iduser='$idnya'");

    if($queryupdate){
        header('location:admin.php');
    } else {
        header('location:admin.php');
    }
}


//Menghapus Admin
if(isset($_POST['hapusadmin'])){
    $id = $_POST['id'];

    $querydelete = mysqli_query($conn,"delete from login where iduser='$id'");

    if($querydelete){
        header('location:admin.php');
    } else {
        header('location:admin.php');
    }
}


//Menambahkan Data Supplier
if(isset($_POST['addnewsupplier'])){
    $namasupplier = $_POST['namasupplier'];
    $namabarang = $_POST['namabarang'];
    $alamat = $_POST['alamat'];
    $notlp = $_POST['notlp'];

    $addtotable = mysqli_query($conn,"insert into supplier (namasupplier, namabarang, alamat, notlp) values ('$namasupplier','$namabarang','$alamat', '$notlp')");
    if($addtotable){
        header('location:supplier.php');
    } else {
        echo 'Input Gagal';
        header('location:supplier.php');
    }
}

//Update Info Supplier
if(isset($_POST['updatesupplier'])){
    $idsupplier = $_POST['idsupplier'];
    $namasupplier = $_POST['namasupplier'];
    $namabarang = $_POST['namabarang'];
    $alamat = $_POST['alamat'];
    $notlp = $_POST['notlp'];

    $update = mysqli_query($conn,"update supplier set namasupplier='$namasupplier', namabarang='$namabarang', alamat='$alamat', notlp='$notlp' where idsupplier='$idsupplier'");
    if($update){
    header('location:supplier.php');
    } else {
        echo 'Input Gagal';
        header('location:supplier.php');
}
}




//Menghapus Data Supplier 
if(isset($_POST['hapussupplier'])){
    $idsupplier = $_POST['idsupplier']; //idsupplier

    $hapus = mysqli_query($conn, "delete from supplier where idsupplier='$idsupplier'");
    if($hapus){
        header('location:supplier.php');
    } else {
        echo 'Input Gagal';
        header('location:supplier.php');
    }
};

?>