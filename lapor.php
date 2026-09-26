<?php
require_once("private/database.php");
$statement = $db->query("SELECT id FROM `laporan` ORDER BY id DESC LIMIT 1");
// $cekk = $statement->fetch(PDO::FETCH_ASSOC);
if ($statement->rowCount() > 0) {
    foreach ($statement as $key) {
        // get max id from tabel laporan
        $max_id = $key['id'] + 1;
    }
}
if ($statement->rowCount() < 1) {
    $max_id = 100;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Lapor | BPBD KOTA TANGSEL</title>
    <link rel="shortcut icon" href="images/logotangerangselatan.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- font Awesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Main Styles CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        #map {
            position: sticky;
            /* Membuat peta tetap berada di tempat */
            top: 0;
            z-index: 1;
        }
    </style>
</head>

<body>

    <div class="shadow">
        <nav class="navbar navbar-fixed navbar-inverse form-shadow">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index">
                        <img alt="Brand" src="images/logo.png">
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="index">HOME</a></li>
                        <li class="active"><a href="lapor">LAPOR</a></li>
                        <li><a href="lihat">LIHAT PENGADUAN</a></li>
                        <li><a href="cara">CARA</a></li>
                        <li class="dropdown">
                            <a href="profildinas" class="dropdown-toggle" data-toggle="dropdown">PROFIL DINAS <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="profildinas">Profil Dinas</a></li>
                                <li class="divider"></li>
                                <li><a href="profildinas">Visi dan Misi</a></li>
                                <li class="divider"></li>
                                <li><a href="profildinas">Struktur Organisasi</a></li>
                                <li class="divider"></li>
                                <li><a href="profildinas">Bidang dan Sekretariat
                                    </a></li>
                            </ul>
                        </li>
                        <li><a href="kontak">KONTAK</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>


        <!-- content -->
        <div class="main-content">

            <h3>Buat Pengaduan</h3>
            <hr />
            <div class="row">
                <div class="col-md-8 card-shadow-2 form-custom">
                    <form class="form-horizontal" role="form" method="post" action="private/validasi" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nomor" class="col-sm-3 control-label">Nomor Pengaduan</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-exclamation-sign"></span></div>
                                    <input type="text" class="form-control" id="nomor" name="nomor" value="<?php echo $max_id; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama" class="col-sm-3 control-label">Nama</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" value="<?= @$_GET['nama'] ?>" required>
                                </div>
                                <p class="error"><?= @$_GET['namaError'] ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="<?= @$_GET['email'] ?>" required>
                                </div>
                                <p class="error"><?= @$_GET['emailError'] ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="telpon" class="col-sm-3 control-label">Telpon</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></div>
                                    <input type="text" class="form-control" id="telpon" name="telpon" placeholder="087123456789" value="<?= @$_GET['telpon'] ?>" required>
                                </div>
                                <p class="error"><?= @$_GET['telponError'] ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="col-sm-3 control-label">Alamat</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-home"></span></div>
                                    <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" value="<?= @$_GET['alamat'] ?>" required>
                                </div>
                                <p class="error"><?= @$_GET['alamatError'] ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="koordinat" class="col-sm-3 control-label">Titik Koordinat</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-map-marker"></span></div>
                                    <input type="text" class="form-control" id="koordinat" name="koordinat" placeholder="Klik pada peta untuk memilih lokasi" readonly required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pilih Lokasi</label>
                            <div class="col-sm-9">
                                <div id="map" style="height: 300px; width: 100%;"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="foto" class="col-sm-3 control-label">Unggah Foto</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-picture"></span></div>
                                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tujuan" class="col-sm-3 control-label">Isi Laporan</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-random"></span></div>
                                    <select class="form-control" id="tujuan" name="tujuan" required onchange="toggleLainnya(this.value)">
                                        <option value="">-- Pilih Laporan --</option>
                                        <option value="Banjir">Banjir</option>
                                        <option value="Tanah Longsor">Tanah Longsor</option>
                                        <option value="Gempa Bumi">Gempa Bumi</option>
                                        <option value="Angin Kencang">Angin Kencang</option>
                                        <option value="Kekeringan">Kekeringan</option>
                                        <option value="Cuaca Ekstrem">Cuaca Ekstrem</option>
                                        <option value="Pohon Tumbang">Pohon Tumbang</option>
                                        <option value="Wabah">Wabah</option>
                                        <option value="lainnya">Lain-lain</option>
                                    </select>
                                </div>
                                <!-- Input tambahan untuk Lain-lain -->
                                <div id="lainnyaInput" style="margin-top: 10px; display: none;">
                                    <input type="text" class="form-control" name="tujuan_lain" placeholder="Tulis jenis laporan lainnya...">
                                </div>
                            </div>
                        </div>

                        <script>
                            function toggleLainnya(value) {
                                var input = document.getElementById("lainnyaInput");
                                if (value === "lainnya") {
                                    input.style.display = "block";
                                } else {
                                    input.style.display = "none";
                                }
                            }
                        </script>

                        <div class="form-group">
                            <label for="pengaduan" class="col-sm-3 control-label">Deskripsi Pengaduan</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></div>
                                    <textarea class="form-control" rows="4" name="pengaduan" placeholder="Tuliskan Deskripsi Pengaduan Anda" required><?= @$_GET['pengaduan'] ?></textarea>
                                </div>
                                <p class="error"><?= @$_GET['pengaduanError'] ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-3">
                                <input id="submit" name="submit" type="submit" value="Kirim Pengaduan" class="btn btn-primary-custom form-shadow">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <p class="error"><em>* Catat Nomor Pengaduan Untuk Melihat Status Pengaduan</em></p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4"></div>
            </div>

            <!-- link to top -->
            <a id="top" href="#" onclick="topFunction()">
                <i class="fa fa-arrow-circle-up"></i>
            </a>
            <script>
                // When the user scrolls down 100px from the top of the document, show the button
                window.onscroll = function() {
                    scrollFunction()
                };

                function scrollFunction() {
                    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                        document.getElementById("top").style.display = "block";
                    } else {
                        document.getElementById("top").style.display = "none";
                    }
                }
                // When the user clicks on the button, scroll to the top of the document
                function topFunction() {
                    document.body.scrollTop = 0;
                    document.documentElement.scrollTop = 0;
                }
            </script>
            <!-- link to top -->


            <!-- /.section -->
            <hr>
        </div>

        <!-- Footer -->
        <footer class="footer text-center">
            <div class="row">
                <div class="col-md-4 mb-5 mb-lg-0">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <i class="fa fa-top fa-map-marker"></i>
                        </li>
                        <li class="list-inline-item">
                            <h4 class="text-uppercase mb-4">Kantor</h4>
                        </li>
                    </ul>
                    <p class="mb-0">
                        JL.Cendekia No.28,Ciater,Kec.Serpong
                        <br>Kota Tangerang Selatan,Banten 15310
                    </p>
                </div>
                <div class="col-md-4 mb-5 mb-lg-0">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <i class="fa fa-top fa-rss"></i>
                        </li>
                        <li class="list-inline-item">
                            <h4 class="text-uppercase mb-4">Sosial Media</h4>
                        </li>
                    </ul>
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="https://www.instagram.com/bpbdtangerangselatan/">
                                <i class="fa fa-fw fa-instagram"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="https://x.com/BPBDKotaTangsel">
                                <i class="fa fa-fw fa-twitter"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <i class="fa fa-top fa-envelope-o"></i>
                        </li>
                        <li class="list-inline-item">
                            <h4 class="text-uppercase mb-4">Kontak</h4>
                        </li>
                    </ul>
                    <p class="mb-0">
                        Telp Siaga : 112 / 081380201112 <br>
                        Email : bpbd@tangerangselatankota.go.id <br>
                        Website : bpbd.tangerangselatankota.go.id
                    </p>
                </div>
            </div>
        </footer>
        <!-- /footer -->

        <div class="copyright py-4 text-center text-white">
            <div class="container">
                <small>v-6.0 | Copyright &copy; BPBD Kota Tangerang Selatan 2025</small>
            </div>
        </div>
        <!-- shadow -->
    </div>

   <!-- jQuery -->
<script src="js/jquery.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="js/bootstrap.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi peta hanya sekali
        const map = L.map('map').setView([-6.29465, 106.71123], 13);

        // Tambahkan tile layer dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let marker;

        // Fungsi untuk memperbarui marker dan input koordinat
        function updateLocation(lat, lng) {
            document.getElementById('koordinat').value = lat + ", " + lng;
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }
        }

        // Ambil lokasi pengguna secara otomatis jika didukung
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    var lat = position.coords.latitude.toFixed(6);
                    var lng = position.coords.longitude.toFixed(6);
                    map.setView([lat, lng], 15);
                    updateLocation(lat, lng);
                },
                function(error) {
                    console.warn("Gagal mendapatkan lokasi: " + error.message);
                    alert("Gagal mendapatkan lokasi: " + error.message + "\nPastikan Anda mengizinkan akses lokasi.");
                }, {
                    enableHighAccuracy: true
                }
            );
        } else {
            console.log("Geolocation tidak didukung oleh browser ini.");
        }

        // Izinkan pengguna memilih lokasi lain dengan mengklik peta
        map.on('click', function(e) {
            const lat = e.latlng.lat.toFixed(6);
            const lng = e.latlng.lng.toFixed(6);
            updateLocation(lat, lng);
        });

        // Jika Anda punya searchControl, tambahkan di sini
        // map.addControl(searchControl);
    });
</script>
</body>
</html>