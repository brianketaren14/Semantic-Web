<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css" />
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
            <h5><a class="nav-link active aktif" href="about.php">About</a></h5>
            <h5><a class="nav-link" href="#">Kelompok Lain</a></h5>
          </div>
        </div>
      </div>
    </nav>
    <section id="profile" class="mb-5">
      <div class="container">
        <div class="row">
          <div class="col text-center text-dark" style="padding: 40px 0">
            <h2 class="display-6">About Us</h2>
            <br>
        </div>
        </div>
        <div class="row d-flex flex-wrap-reverse justify-content-between ">
          <div class="col-4">
            <div class="card text-dark text-center">
              <img src="img/alex.jpeg" class="card-img-top rounded-circle w-75 m-auto mt-3 mb-3" alt="..." />
              <div>
                <h5>Alex</h5>
                <p>201401034</p>
                <p><small>KOM A</small></p>
              </div>
            </div>
          </div>
          <div class="col-4">
            <div class="card text-dark text-center">
              <img src="https://media-exp1.licdn.com/dms/image/C4E03AQExYnKWtBIykg/profile-displayphoto-shrink_200_200/0/1634723539178?e=1642032000&v=beta&t=dxLiKcHK7V6zl2Xuuu-jcMf6mTfo_u7hAAwEp-5_Ggk" class="card-img-top rounded-circle w-75 m-auto mt-3 mb-3" alt="..." />
              <div>
                <h5>Brian</h5>
                <p>201401041</p>
                <p><small>KOM A</small></p>
              </div>
            </div>
          </div>
          <div class="col-4">
            <div class="card text-dark text-center">
              <img src="img/daniel.jpeg" class="card-img-top rounded-circle w-75 m-auto mt-3 mb-3" alt="..." />
              <div>
                <h5>Daniel</h5>
                <p>20140146</p>
                <p><small>KOM A</small></p>
              </div>
            </div>
          </div>
        </div>
      </div>
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