<?php
  if(isset($_GET['namaband'])){
    require_once( "sparqllib.php" );
    $db = sparql_connect( "http://localhost:3030/projectsw/query" );
    if( !$db ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
    $namaband = $_GET['namaband'];
  }else{
    echo "<script>document.location.href = 'tidakada.php';</script>";
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css" />
    <title>Band <?= $namaband ?></title>
    <link rel="icon" href="img/radiation.png" />
  </head>
  <body onload="startTime()">
  
    <div class="loaderContainer">
      <div class="loader"></div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="img/radiation.png" alt="logo" width="40" height="40">
        </a>
        <h3><a href="index.php" style="font-size:30px;"class="navbar-brand">Just Web</a></h3>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav ms-auto">
            <h5><a class="nav-link active aktif" aria-current="page" href="index.php">Home</a></h5>
            <h5><a class="nav-link" href="about.php">About</a></h5>
            <h5><a class="nav-link" href="kelompokLain.php">Kelompok Lain</a></h5>
          </div>
        </div>
      </div>
    </nav>
    <section class="banner container mb-5">
        <div class="carousel-inner">
            <?php 
                    
                    $band = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                    PREFIX d: <http://fake.com/data/>
                    PREFIX dbo: <http://dbpedia.org/ontology/>
                    PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                    PREFIX dbp: <http://dbpedia.org/property/>

                    SELECT 
                    ?banner ?abstract ?debut ?genre ?instagram ?twitter ?facebook
                    WHERE {
                        ?band rdf:type dbo:Band.
                        ?band foaf:name '$namaband'.
                        ?band foaf:image ?banner.
                        ?band dbp:yearsActive ?debut.
                        ?band dbp:genre ?genre.
                        ?band d:instagramAccount ?instagram.
                        ?band d:facebookAccount ?facebook.
                        ?band d:twitterAccount ?twitter.
                    } ";
                    $result = sparql_query($band); 
                    while ($baris = sparql_fetch_array($result)):
                    ?>
                        <div class="carousel-item active">
                            <img src="<?=$baris['banner']?>" class="d-block w-100" alt="..." style="height:70vh; filter: brightness(35%);">
                            <div class="carousel-caption">
                                <h1><?= $namaband ?></h1>
                                <h3><?= $baris['debut'] ?></h3>
                                <h5><?= $baris['genre'] ?></h5>
                                <a href="<?=$baris['instagram']?>"><img src="img/instagram.png" alt="akun instagram <?=$namaband?>"  class="me-2" style="filter: brightness(150%);"></a>
                                <a href="<?=$baris['facebook']?>"><img src="img/facebook.png" alt="akun facebook <?=$namaband?>" class="me-2" style="filter: brightness(150%);"></a>
                                <a href="<?=$baris['twitter']?>"><img src="img/twitter.png" alt="akun twitter <?=$namaband?>" class="me-2" style="filter: brightness(150%);"></a>
                            </div>
                        </div>
                    <?php endwhile;  ?>   
        </div>
    </section>
    <section class="anggota container mb-5">
        <h1 class="text-center mb-5">Anggota <?= $namaband ?></h1>
        <div class="d-flex justify-content-around flex-wrap">
        <?php 
            $sparql = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            PREFIX d: <http://fake.com/data/>
            PREFIX dbo: <http://dbpedia.org/ontology/>
            PREFIX foaf: <http://xmlns.com/foaf/0.1/>
            PREFIX dbp: <http://dbpedia.org/property/>
            SELECT 
            ?foto ?namaPanggung ?fullName ?birthDate ?role ?birthPlace ?tinggi
            WHERE {
                ?band rdf:type dbo:Band.
                ?band foaf:name '$namaband'.
                ?band dbo:bandMember ?member.
                ?member foaf:image ?foto.
                ?member dbo:alias ?namaPanggung.
                ?member d:role ?role.
                ?member foaf:name ?fullName.
                ?member dbo:birthDate ?birthDate.
                ?member dbp:birthPlace ?birthPlace.
                ?member dbp:height ?tinggi.
            } ";
            $hasil = sparql_query($sparql);
            while ($anggota = sparql_fetch_array($hasil)) :
        ?>
        <div class="card mb-5" style="width: 18rem;">
        <img src="<?=$anggota['foto']?>" class="card-img-top" alt="" height=300>
        <div class="card-body">
            <h5 class="card-title"><?= $anggota['namaPanggung'] ?></h5>
            <p class="card-text"><?= $anggota['role'] ?></p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Nama Lengkap : </strong><?= $anggota['fullName'] ?></li>
            <li class="list-group-item"><strong>Tanggal Lahir : </strong><?= $anggota['birthDate'] ?></li>
            <li class="list-group-item"><strong>Tempat Lahir : </strong><?= $anggota['birthPlace'] ?></li>
            <li class="list-group-item"><strong>Tinggi Badan : </strong><?= $anggota['tinggi'] ?> cm</li>
        </ul>
        </div>
        <?php endwhile;  ?>
        </div>
    </section>
    <section class="mb-5" style="width:75%; margin:auto">
      <h1 class="text-center">About <?= $namaband ?></h1>
      <?php 
        $query = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
        PREFIX d: <http://fake.com/data/>
        PREFIX dbo: <http://dbpedia.org/ontology/>
        PREFIX foaf: <http://xmlns.com/foaf/0.1/>

        SELECT
        ?abstract 
        WHERE {
          ?band rdf:type dbo:Band.
          ?band foaf:name '$namaband'.
          ?band dbo:abstract ?abstract.
        }";
        $tampil = sparql_query($query);
        while ($abstract = sparql_fetch_array($tampil)):
      ?>
      <p><?= $abstract['abstract']; ?></p>
      <?php endwhile;  ?>
    </section>
   
    <footer class="container d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
      <div class="col-md-4 d-flex align-items-center">
          <img src="img/radiation.png" alt="logo" width="40" height="40" class="mb-3 me-2 mb-md-0">
        <span class="text-muted">© 2021 Company, Inc</span>
      </div>
      <div class="col-md-4 text-center"  >
        <h3 id="jam" class="ms-2"></h3>
      </div>
      <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
        <li class="ms-3"><a class="text-muted" href="https://www.instagram.com/"><img src="img/instagram.png" alt="" class="me-2"></a></li>
        <li class="ms-3"><a class="text-muted" href="https://www.facebook.com/"><img src="img/facebook.png" alt="" class="me-2"></a></li>
        <li class="ms-3"><a class="text-muted" href="https://www.twitter.com/"><img src="img/twitter.png" alt="" class="me-2"></a></li>
      </ul>
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
      let loaderContainer = document.querySelector('.loaderContainer');
      window.addEventListener('load', function () {
        setTimeout(() => {
          loaderContainer.classList.add("fade")
        }, 1000);
        setTimeout(() => {
          loaderContainer.parentElement.removeChild(loaderContainer);
        }, 1300);
      });
      function startTime() {
        const today = new Date();
        let h = today.getHours();
        let m = today.getMinutes();
        let s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('jam').innerHTML =  h + ":" + m + ":" + s;
        setTimeout(startTime, 1000);
      }

        function checkTime(i) {
          if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
          return i;
        }
    </script>
    
  </body>
</html>
