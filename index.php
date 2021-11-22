<?php 
require_once( "sparqllib.php" );

  $db = sparql_connect( "http://localhost:3030/projectsw/query" );
  if( !$db ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
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
    <title>Just Web</title>
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
            <h5><a class="nav-link" href="#">Kelompok Lain</a></h5>
          </div>
        </div>
      </div>
    </nav>
    <section class="container">
      <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
        </div>
        
        <div class="carousel-inner">
        <?php 
            $carousel = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            PREFIX d: <http://fake.com/data/>
            PREFIX dbo: <http://dbpedia.org/ontology/>
            PREFIX foaf: <http://xmlns.com/foaf/0.1/>
            PREFIX dbp: <http://dbpedia.org/property/>
            SELECT 
            ?gambar ?nama ?genre
            WHERE {
              ?band rdf:type dbo:Band.
              ?band foaf:image ?gambar.
              ?band foaf:name ?nama.
              ?band dbp:genre ?genre.
            } ORDER BY ASC (?nama)  LIMIT 5";
            $hasil = sparql_query($carousel);
            $i = 1;
            while ($baris = sparql_fetch_array($hasil)): // mengembalikan array asosisative
            if ($i==1) { 
            ?>
            <div class="carousel-item active" style="height: 70vh">
            <img src="<?=$baris['gambar']?>" class="gambar-band d-block w-100 h-100 " alt="..." style="filter: brightness(35%);"/>
              <div class="carousel-caption text-start">
                <h1><?=$baris['nama']?></h1>
                <p><?=$baris['genre']?></p>
                <a class="btn btn-danger" href="tampilBand.php?namaband=<?=$baris['nama']?>">More</a>
              </div>
            </div>
          <?php } else {?>
            <div class="carousel-item" style="height: 70vh">
            <img src="<?=$baris['gambar']?>" class="d-block w-100 h-100" alt="..." style="filter: brightness(35%);"/>
            <div class="carousel-caption text-start">
              <h1><?=$baris['nama']?></h1>
              <p><?=$baris['genre']?></p>
              <a class="btn btn-danger" href="tampilBand.php?namaband=<?=$baris['nama']?>">More</a>
            </div>
            </div>
          <?php } $i++;  endwhile; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </section>
    <section class="container">
    <form class="d-flex mb-3 mt-3">
      <input id="search" class="form-control" type="text" placeholder="search" name="search">
    </form>
     <?php 
      $all = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
      PREFIX d: <http://fake.com/data/>
      PREFIX dbo: <http://dbpedia.org/ontology/>
      PREFIX foaf: <http://xmlns.com/foaf/0.1/>
      PREFIX dbp: <http://dbpedia.org/property/>

      SELECT 
      ?gambar ?nama ?genre ?debut ?instagram ?twitter ?facebook
      WHERE {
        ?band rdf:type dbo:Band.
        ?band foaf:image ?gambar.
        ?band foaf:name ?nama.
        ?band dbp:genre ?genre.
        ?band dbp:yearsActive ?debut.
        ?band d:instagramAccount ?instagram.
        ?band d:facebookAccount ?facebook.
        ?band d:twitterAccount ?twitter.
      } ";
      $result = sparql_query($all);
        while( $row = sparql_fetch_array( $result ) ):
     ?>
      <div class="row">
        <div class="col">
        <div class="band text-dark mb-5 ">
        <div class="band-preview">
        <img src="<?=$row['gambar']?>" class="card-img-top" alt="...">
        </div>
          <div class="band-info">
            <div class="progress-container">
              <div class="progress"></div>
            </div>
            <h1><?= $row['nama'] ?></h1>
            <h5><?= $row['debut'] ?></h5>
            <p><?= $row['genre'] ?></p>
            <div class="medsos mt-4">
              <a href="<?=$row['instagram']?>"><img src="img/instagram.png" alt="akun instagram <?=$row['nama']?>"  class="me-2"></a>
              <a href="<?=$row['facebook']?>"><img src="img/facebook.png" alt="akun facebook <?=$row['nama']?>" class="me-2"></a>
              <a href="<?=$row['twitter']?>"><img src="img/twitter.png" alt="akun twitter <?=$row['nama']?>" class="me-2"></a>
            </div>
            <a href="tampilBand.php?namaband=<?=$row['nama']?>" class="tombol">More</a>
        </div>
      </div>
        </div>
      </div>
      <?php 
        endwhile;
      ?>
    </section>
  <footer class="container d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
      <div class="col-md-4 d-flex align-items-center">
          <img src="img/radiation.png" alt="logo" width="40" height="40" class="mb-3 me-2 mb-md-0">
        <span class="text-muted">© 2021 Just Web, Inc</span>
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
          loaderContainer.classList.add("fade");
        }, 500);
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      $(document).ready(function () {
        $('#search').on('keyup', function () {
          var value = $(this).val().toLowerCase();
          $('.band').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
          });
        });
      });
    </script>
  </body>
</html>
