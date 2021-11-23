<?php 
  require_once( "sparqllib.php" );
  $db = sparql_connect( "http://localhost:3030/kelompokLain/sparql" );
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
    <title>Kumpulan Buku</title>
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
            <h5><a class="nav-link" aria-current="page" href="index.php">Home</a></h5>
            <h5><a class="nav-link" href="about.php">About</a></h5>
            <h5><a class="nav-link active aktif" href="kelompokLain.php">Kelompok Lain</a></h5>
          </div>
        </div>
      </div>
    </nav>
    <section class="container mt-5">
      
      <div class="row">
        <div class="col text-center">
          <h1>Daftar Buku</h1>
        </div>
        <form class="d-flex mb-3 mt-3">
          <input id="search" class="form-control" type="text" placeholder="search" name="search">
        </form>
      </div>
        <?php 
          $sparql = "PREFIX dc:   <http://purl.org/dc/elements/1.1/> 
          PREFIX rdf:  <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
          PREFIX wiki: <https://en.wikipedia.org/wiki/Price> 
          
          SELECT ?judul ?creator ?publisher ?category ?price 
          WHERE {
            ?buku dc:title ?judul.
              ?buku dc:creator ?creator.
              ?buku dc:publisher ?publisher.
              ?buku wiki:category ?category.
              ?buku wiki:price ?price.
              
          }";
          $result = sparql_query($sparql);
          while($row = sparql_fetch_array($result)):
        ?>
        <div class="row">
          <div class="col">
            <div class="buku text-dark mb-5">
              <div class="buku-preview">
                <img src="img/books.png" class="card-img-top" alt="..." />
              </div>
              <div class="buku-info">
                <div class="progress-container">
                  <div class="progress"></div>
                </div>
                <h1><?= $row['judul'] ?></h1>
                <h5><?= $row['creator'] ?></h5>
                <br>
                <p><strong>Category : </strong><?= $row['category'] ?></p>
                <p><strong>Penerbit : </strong><?= $row['publisher'] ?></p>
                <p><strong>Harga : </strong><?= $row['price'] ?></p>
                <a href="tampilbuku.php?namabuku=<?=$row['judul']?>" class="tombol">More</a>
              </div>
            </div>
          </div>
        </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      $(document).ready(function () {
        $('#search').on('keyup', function () {
          var value = $(this).val().toLowerCase();
          $('.buku').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
          });
        });
      });
    </script>
</body>
</html>