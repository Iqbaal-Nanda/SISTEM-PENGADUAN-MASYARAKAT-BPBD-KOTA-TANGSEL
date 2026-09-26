<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
require_once("private/database.php");
?>
<?php
// fungsi untuk merandom avatar profil
function RandomAvatar()
{
    $photoAreas = array("avatar1.png", "avatar2.png", "avatar3.png", "avatar4.png", "avatar5.png", "avatar6.png", "avatar7.png", "avatar8.png", "avatar9.png", "avatar10.png", "avatar11.png");
    $randomNumber = array_rand($photoAreas);
    $randomImage = $photoAreas[$randomNumber];
    echo $randomImage;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Pengaduan BPBD</title>
    <link rel="shortcut icon" href="images/logotangerangselatan.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- font Awesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Main Styles CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="js/bootstrap.js"></script>
    <!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.min.css">
</head>

<body>
    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.11';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <!--Success Modal Saved-->
    <div class="modal fade" id="successmodalclear" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm " role="document">
            <div class="modal-content bg-2">
                <div class="modal-header ">
                    <h4 class="modal-title text-center text-green">Sukses</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">Pengaduan Berhasil Di Kirim</p>
                    <p class="text-center">Untuk Mengetahui Status Pengaduan</p>
                    <p class="text-center">Silahkan Buka Menu <a href="lihat">Lihat Pengaduan</a> </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn button-green" onclick="location.href='index';" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_GET['status'])) {
    ?>
        <script type="text/javascript">
            $("#successmodalclear").modal();
        </script>
    <?php
    }
    ?>
    <!-- body -->
    <div class="shadow">
        <!-- navbar -->
        <nav class="navbar navbar-inverse navbar-fixed form-shadow">
            <!-- container-fluid -->
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav nav-link">
                        <li class="active"><a href="">HOME</a></li>
                        <li><a href="lapor">LAPOR</a></li>
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
                        <li><a href="#" onclick="confirmLogout()">LOGOUT</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <!-- end navbar -->


        <!-- Slider dengan Video -->
        <div class="carousel-inner" role="listbox" style="position: relative;">
            <div class="item active">
                <video autoplay muted loop playsinline preload="auto" style="width: 100%; height: 600px; object-fit: cover; display: block;">
                    <source src="images/header_video2.mp4" type="video/mp4">
                    Browser Anda tidak mendukung video.
                </video>

                <!-- Weather Overlay di atas Video -->
<!--                 
                <div id="weather-overlay" style="position: absolute; top: 20px; left: 20px; background: rgba(0,0,0,0.5); padding: 10px; border-radius: 5px; color:#fff;">
                    <h4 style="margin-bottom:5px; font-size:16px;">Cuaca Terkini</h4>
                    <div id="weather-data">
                        <p style="margin:0;">Memuat data cuaca...</p>
                    </div>
                </div>
-->

                <div class="carousel-caption welcome">
                    <h2 class="animated fadeInDown" style="font-family: 'Poppins', sans-serif; font-size: 50px; font-weight: 700; color: #ffffff; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);">
                        SELAMAT DATANG
                    </h2>
                    <h3 class="animated fadeInUp" style="font-family: 'Poppins', sans-serif; font-size: 36px; font-weight: 500; color: #ffffff; text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);">
                        DI WEBSITE PENGADUAN MASYARAKAT
                    </h3>
                    <p class="animated fadeInUp slogan" style="font-family: 'Poppins', sans-serif; font-size: 24px; font-weight: 400; color: #ffffff; margin-top: 20px; text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);">
                        BPBD KOTA TANGERANG SELATAN
                    </p>
                </div>
            </div>
            <!-- item active -->
        </div>
        <!-- end Slider -->
<!--
        <script>
            $(document).ready(function() {
                var apiKey = "0fd954b11391f9abb5342b7047f1645c"; // Ganti dengan API Key Anda
                var cityId = "1642911"; // Sesuaikan jika perlu
                var url = "https://api.openweathermap.org/data/2.5/weather?id=" + cityId + "&units=metric&lang=id&appid=" + apiKey;
                $.getJSON(url, function(data) {
                    var cityName = data.name;
                    var temp = Math.round(data.main.temp);
                    var description = data.weather[0].description;
                    var iconUrl = "http://openweathermap.org/img/wn/" + data.weather[0].icon + "@2x.png";

                    var html = '<strong style="font-size:14px;">' + cityName + '</strong><br>';
                    html += '<img src="' + iconUrl + '" alt="Ikon Cuaca" style="vertical-align:middle;"><br>';
                    html += '<span style="font-size:12px;">' + description + '</span><br>';
                    html += '<span style="font-size:14px; font-weight:bold;">' + temp + '&deg;C</span>';
                    $("#weather-data").html(html);
                }).fail(function() {
                    $("#weather-data").html("<p>Data cuaca tidak dapat dimuat.</p>");
                });
            });
        </script>
-->
        <!-- content -->
        <div class="main-content">
            <!-- section -->
            <div class="section">
                <div class="row">
                    <!-- laporan Terbaru -->
                    <div class="col-md-8">
                        <br>
                        <h3 class="text-center h3-custom">Pengaduan Terbaru</h3>
                        <hr class="custom-line" />
                        <hr>
                        <!-- scroll-laporan -->
                        <div class="scroll-laporan">
                            <?php
                            // Ambil semua record dari tabel laporan
                            $statement = $db->query("SELECT * FROM `laporan` ORDER BY id DESC");
                            foreach ($statement as $key) {
                                $mysqldate = $key['tanggal'];
                                $phpdate = strtotime($mysqldate);
                                $tanggal = date('d F Y, H:i:s', $phpdate);
                            ?>
                                <div class="panel-body card-shadow-2">
                                    <a class="media-left" href="#"><img class="img-circle img-sm form-shadow" src="images/avatar/<?php RandomAvatar(); ?>"></a>
                                    <div class="media-body">
                                        <div>
                                            <h4 class="text-green profil-name" style="font-family: monospace;"><?php echo $key['nama']; ?></h4>
                                            <p class="text-muted text-sm"><i class="fa fa-th fa-fw"></i> - <?php echo $tanggal; ?></p>
                                        </div>
                                        <hr class="hr-nama">
                                        <p>
                                            <?php echo $key['isi']; ?>
                                        </p>
                                    </div>
                                    <!-- media body -->
                                </div>
                                <!-- panel body -->
                            <?php
                            }
                            ?>

                        </div>
                        <!-- end scroll-laporan -->
                    </div>
                    <!-- End Laporan Terbaru -->

                    <!-- Social Media Feed -->
                    <div class="col-md-4">
                        <br>
                        <!-- header text social-feed -->
                        <h3 class="text-center h3-custom">Social Feed</h3>
                        <hr class="custom-line" />
                        <!-- end header text social-feed -->

                        <!-- YouTube Feed -->
                        <div class="box">
                            <div class="box-icon shadow">
                                <span class="fa fa-2x fa-youtube-play"></span>
                            </div>
                            <div class="info">
                                <h3 class="text-center">YouTube</h3>
                                <div class="embed-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%;">
                                    <iframe src="https://www.youtube.com/embed/jn1nLBDsDm8?si=O0LoBCqSCQe406Xu" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></iframe>
                                </div>
                                <p class="text-center" style="margin-top:10px;">
                                    Jika tidak dapat diputar, klik <a href="https://www.youtube.com/watch?v=jn1nLBDsDm8?si=O0LoBCqSCQe406Xu" target="_blank">di sini</a> untuk menuju ke channel YouTube BPBD.
                                </p>
                            </div>
                        </div>

                        <hr>

                        <!-- Instagram Feed -->
                        <div class="box">
                            <div class="box-icon shadow">
                                <span class="fa fa-2x fa-instagram"></span>
                            </div>
                            <div class="info">
                                <a href="https://www.instagram.com/bpbdtangerangselatan/" target="_blank" style="color:inherit; text-decoration:none;">
                                    <h3 class="text-center">Instagram</h3>
                                </a>
                                <div class="scroll-container">
                                    <!-- Gambar pertama -->
                                    <img src="images/tk_syafaka.jpg" alt="IG BPBD Tangsel 1">
                                    <!-- Gambar kedua -->
                                    <img src="images/kunjungan.webp" alt="IG BPBD Tangsel 2">
                                    <!-- Gambar ketiga -->
                                    <img src="images/penangan_pt.webp" alt="IG BPBD Tangsel 3">
                                    <!-- Gambar keempat -->
                                    <img src="images/informasi.webp" alt="IG BPBD Tangsel 4">
                                    <!-- Video, dengan kontrol dan poster sebagai thumbnail -->
                                    <video controls style="width:300px; border-radius:10px; margin-right:10px;" poster="images/">
                                        <source src="images/room_bpbd.mp4" type="video/mp4">
                                        Browser Anda tidak mendukung video.
                                    </video>
                                </div>
                            </div>
                        </div>
                        <style>
                            .scroll-container {
                                overflow-x: auto;
                                white-space: nowrap;
                                display: flex;
                                padding: 10px;
                                border-radius: 10px;
                            }

                            .scroll-container img {
                                width: 300px;
                                margin-right: 10px;
                                border-radius: 10px;
                            }
                        </style>
                        <script>
                            const container = document.querySelector('.scroll-container');
                            setInterval(() => {
                                if (container) {
                                    container.scrollLeft += 1;
                                }
                            }, 50);
                        </script>

                        <hr>
                        <!-- Twitter Feed  -->
                        <div class="box">
                            <div class="box-icon shadow">
                                <span class="fa fa-2x fa-twitter"></span>
                            </div>
                            <div class="info">
                                <h3 class="text-center">Twitter Feed</h3>
                                <a class="twitter-timeline"
                                    href="https://twitter.com/BPBDTANGSEL"
                                    data-width="100%"
                                    data-height="400"
                                    data-theme="dark"
                                    data-chrome="noheader nofooter noborders transparent"
                                    data-tweet-limit="5">
                                    Tweet Terbaru dari BPBD Tangsel
                                </a>
                                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                            </div>
                        </div>

                        <hr>
                        <!-- Link Feed -->
                        <div class="box">
                            <div class="box-icon shadow">
                                <span class="fa fa-2x fa-rss"></span>
                            </div>
                            <div class="info">
                                <h3 class="text-center">Link</h3>
                                <ul class="list-group">
                                    <li class="list-group-item list-group-item-success">
                                        <a href="https://bpbd.tangerangselatankota.go.id/" target="_blank">Website BPBD Kota Tangerang Selatan</a>
                                    </li>
                                    <li class="list-group-item list-group-item-info">
                                        <a href="https://tangerangselatankota.go.id/" target="_blank">Website Pemerintahan Kota Tangerang Selatan</a>
                                    </li>
                                    <li class="list-group-item list-group-item-warning">
                                        <a href="https://data.tangerangselatankota.go.id/dataset" target="_blank">Website Kominfo Kota Tangerang Selatan</a>
                                    </li>
                                    <li class="list-group-item list-group-item-danger">
                                        <a href="https://pbb-bphtb.tangerangselatankota.go.id/" target="_blank">Website Bapenda Kota Tangerang Selatan</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End Link Feed -->
                    </div>
                    <!-- End Social Media Feed -->
                </div>
                <!-- end row -->
            </div>
            <!-- /.section -->

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

        </div>
        <!-- end main-content -->

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
                </div>
            </div>
        </footer>
        <!-- /footer -->

        <div class="copyright py-4 text-center text-white">
            <small>v-6.0 | Copyright &copy; BPBD Kota Tangerang Selatan 2025</small>
        </div>
        <!-- shadow -->
    </div>
    <script>
        function confirmLogout() {
            const confirmation = confirm("Apakah Anda yakin ingin logout?");
            if (confirmation) {
                window.location.href = "logout.php";
            }
        }
    </script>
</body>

</html>