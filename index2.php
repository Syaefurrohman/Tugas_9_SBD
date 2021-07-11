<?php
//memasukkan file config.php
include('koneksi.php');
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Perpustakaan</title>
        <script src="files/js/jquery.min.js"></script>
        <script src="files/bootstrap/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="files/bootstrap/css/bootstrap.min.css">
    </head>

<!-- Pengaturan -->
    <style type="text/css">
        body {
            color: red;
            background-color: #d24dff;
            background: -webkit-linear-gradient(#93B874, #C9DCB9);
        }
        h1 {
            color: #00FF00;
            background-color: ;
        }
        p {
            color: rgb(0,0,255);
            background-color: #FFFFFF;
        }
    </style>
<!-- akhir pengaturan -->
    <body onload="muatDaftarData();">
        
        <div class="col-md-8 col-md-offset-2" ng-controller="listContactCtrl">
            <div class="page-header">
                <h1><font face="Times New Roman" color="red">
                    Form Perpustakaan</font>
                </h1>
                <ul class="nav nav-pills">
                  <li><a id="nav-list-data" href="javascript:void(0);" onclick="gantiMenu('list-data');">Daftar Data</a></li>
                  <li><a id="nav-tambah-data" href="javascript:void(0);" onclick="gantiMenu('tambah-data');">Tambah Data</a></li>
                </ul>

            </div>
            <div id="tambah-data" class="well" style="display:none;">
                <form id="form-data">
                    <div id="name-group" class="form-group">
                        <label>Kode Buku:</label> 
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="contoh: Biskuit" /><br/>
                    </div>
                    <div id="barang-group" class="form-group">
                        <label>Nama Buku:</label> 
                        <input type="text" class="form-control" id="barang" name="barang" placeholder="contoh: 100 pack" /><br/>
                    </div>
                    <div id="berat-group" class="form-group">
                        <label>Genre:</label> 
                        <input type="text" class="form-control" id="berat" name="berat" placeholder="contoh: 1000 Kg" /><br/>
                    </div>
                    <div id="harga-group" class="form-group">
                        <label>Jumlah Buku:</label> 
                        <textarea class="form-control" id="harga" name="harga" placeholder="contoh: Rp: 1.000"></textarea><br/>
                    </div>
                    
                    <input type="button" value="Simpan" onclick="simpanData();" class="btn btn-success btn-small"/>
                    <input type="reset" value="Reset" onclick="" class="btn btn-warning btn-small"/>
                </form>
            </div>
            <div id="edit-data" class="well" style="display:none;">
                <form id="eform-data">
				
                    <div id="name-group" class="form-group" style="display:none;">
                        <label>id data:</label> 
                        <input type="text" class="form-control" id="eid_data" name="nama" placeholder="" /><br/>
                    </div>
				
                    <div id="name-group" class="form-group">
                        <label>Kode Buku:</label> 
                        <input type="text" class="form-control" id="enama" name="nama" placeholder="contoh: Biskuit" /><br/>
                    </div>
                    <div id="barang-group" class="form-group">
                        <label>Nama Buku:</label> 
                        <input type="text" class="form-control" id="ebarang" name="barang" placeholder="contoh: 100 pack" /><br/>
                    </div>
                    <div id="berat-group" class="form-group">
                        <label>Genre:</label> 
                        <input type="text" class="form-control" id="eberat" name="berat" placeholder="contoh: 1000 Kg" /><br/>
                    </div>
                    <div id="harga-group" class="form-group">
                        <label>Jumlah Stock:</label> 
                        <textarea class="form-control" id="eharga" name="harga" placeholder="contoh: Rp: 1.000"></textarea><br/>
                    </div>
                    <input type="button" value="Simpan" onclick="simpanEditData();" class="btn btn-success btn-small"/>
                    <input type="reset" value="Reset" onclick="" class="btn btn-warning btn-small"/>
                    <input type="button" value="Cancel" onclick="gantiMenu('list-data');" class="btn btn-warning btn-small"/>
                </form>
            </div>
            <div id="list-data" class="well">
            <center>
        <font size="6">Data Barang</font>
    </center>
    <hr>
    <a href="index.php?page=tambah_mhs"><button class="btn btn-dark right">Tambah Barang</button></a>
    <a href="index.php?page=tabel_mhs"><button class="btn btn-dark right">Cek Tabel Barang</button></a>
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Barang</th>
                    <th>Harga Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //select ke database Select tabel_barang urut berdasarkan 
                $sql = mysqli_query($koneksi, "SELECT * FROM daftar_buku ORDER BY Kode_Buku DESC") or die(mysqli_error($koneksi));

                if (mysqli_num_rows($sql) > 0) {
                    $no = 1;
                    while ($data = mysqli_fetch_assoc($sql)) {
                        echo '
                        <tr>
                            <td>' . $no . '</td>
                            <td>' . $data['Kode_Barang'] . '</td>
                            <td>' . $data['Nama_Barang'] . '</td>
                            <td>' . $data['Jumlah_Barang'] . '</td>
                            <td>' . $data['Harga_Barang'] . '</td>
                        
                        </tr>
                        ';
                        $no++;
                    }
                } else {
                    echo '
                    <tr>
                        <td colspan="6">Tidak Ada Data..!</td>
                    </tr>
                    ';
                }
                ?>
            </tbody>

        </table>
    </div>
            </div>
        </div>
        
    </body>
    <script type="text/javascript">
        function muatDaftarData(){
            if (localStorage.daftar_data && localStorage.id_data){
            
                daftar_data = JSON.parse(localStorage.getItem('daftar_data'));
               
                var data_app = "";
                
                if (daftar_data.length > 0){
                    data_app = '<table class="table">';
                    data_app += '<thead>'+
                                        '<th>No</th>'+
                                        '<th>Nama Barang</th>'+
                                        '<th>Jumlah Barang</th>'+
                                        '<th>Berat bersih</th>'+
                                        '<th>Harga Jual</th>'+
                                        '<th>Terjual</th>'+
                                        '<th>Perintah</th>'+
                                        '<th>Perintah</th>'+
                                      '</thead><tbody>';
                                      
                    for (i in daftar_data){
                        data_app += '<tr>';
                        data_app += '<td>'+ daftar_data[i].id_data + ' </td>'+
                                          '<td>'+ daftar_data[i].nama + ' </td>'+
                                          '<td>'+ daftar_data[i].barang + '</td>'+
                                          '<td>'+ daftar_data[i].berat + ' </td>'+
                                          '<td>'+ daftar_data[i].harga + ' </td>'+
                                          '<td>'+ daftar_data[i].terjual+'</td>'+
                                          '<td><a class="btn btn-danger btn-small" href="javascript:void(0)" onclick="hapusData(\''+daftar_data[i].id_data+'\')">Hapus</a></td>'+
                                          '<td><a class="btn btn-warning btn-small" href="javascript:void(0)" onclick="editData(\''+daftar_data[i].id_data+'\')">Edit</a></td>';
                        data_app += '</tr>';
                        
                    }
                   data_app += '</tbody></table>';
               
                }
                else {
                    data_app = "Tidak ada data...";
                }
               
                
               $('#list-data').html(data_app);
               $('#list-data').hide();
               $('#list-data').fadeIn(100);
            }
        }
		
		function editData(id){
		
            if (localStorage.daftar_data && localStorage.id_data){
                daftar_data = JSON.parse(localStorage.getItem('daftar_data'));			
				idx_data = 0;
                for (i in daftar_data){
                    if (daftar_data[i].id_data == id){
						$("#eid_data").val(daftar_data[i].id_data);
						$("#enama").val(daftar_data[i].nama);
                        $("#ebarang").val(daftar_data[i].barang);
						$("#eberat").val(daftar_data[i].berat);
						$("#eharga").val(daftar_data[i].harga);
                        $("#eterjual").val(daftar_data[i].terjual);
						daftar_data.splice(idx_data, 1);
                    }
                    idx_data ++;
                }
				gantiMenu('edit-data');
				
            }
			
		}
        
        
        function simpanData(){
            nama = $('#nama').val();
            barang = $('#barang').val();
            berat = $('#berat').val();
            harga = $('#harga').val();
            terjual = $('#terjual').val();
            
            if (localStorage.daftar_data && localStorage.id_data){
                daftar_data = JSON.parse(localStorage.getItem('daftar_data'));
                id_data = parseInt(localStorage.getItem('id_data'));
            }
            else {
                daftar_data = [];
                id_data = 0;
            }

            id_data ++;
            daftar_data.push({'id_data':id_data, 'nama':nama, 'barang':barang, 'berat':berat, 'harga':harga, 'terjual':terjual});
            localStorage.setItem('daftar_data', JSON.stringify(daftar_data));
            localStorage.setItem('id_data', id_data);
            document.getElementById('form-data').reset();
            gantiMenu('list-data');
            
            return false;
        }
		
        function simpanEditData(){
            id_data = $('#eid_data').val();
            nama = $('#enama').val();
            barang = $('#ebarang').val();
            berat = $('#eberat').val();
            harga = $('#eharga').val();
            terjual = $('#terjual').val();
            
            daftar_data.push({'id_data':id_data, 'nama':nama, 'barang':barang, 'berat':berat, 'harga':harga, 'terjual':terjual});
            localStorage.setItem('daftar_data', JSON.stringify(daftar_data));
            document.getElementById('eform-data').reset();
            gantiMenu('list-data');
            
            return false;
        }
        
        function hapusData(id){
            if (localStorage.daftar_data && localStorage.id_data){
                daftar_data = JSON.parse(localStorage.getItem('daftar_data'));
                
                idx_data = 0;
                for (i in daftar_data){
                    if (daftar_data[i].id_data == id){
                        daftar_data.splice(idx_data, 1);
                    }
                    idx_data ++;
                }
               
                localStorage.setItem('daftar_data', JSON.stringify(daftar_data));
                muatDaftarData();
            }
        }
		

        function gantiMenu(menu){
            if (menu == "list-data"){
                muatDaftarData();
                $('#tambah-data').hide();
                $('#list-data').fadeIn();
				$('#edit-data').hide();
            }
            else if (menu == "tambah-data"){
                $('#tambah-data').fadeIn();
                $('#list-data').hide();
				$('#edit-data').hide();
            }else if (menu == "edit-data"){
                $('#edit-data').fadeIn();
                $('#tambah-data').hide();
                $('#list-data').hide();
            }
        }
    </script>
</html>
