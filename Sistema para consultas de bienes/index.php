<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="js/jquery.js"></script>
    <link rel="shortcut icon" href="img/menu.png">
  <title>Login</title>
</head>
<body>
<div class="position-absolute top-0 start-50 translate-middle-x">
  <br>
  <img src="img/logo.png" alt="logo" >
</div>
<section class="vh-100" style="background-color: #F4F6F7;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

          <form action="cargaDatos.php" method="POST">

            <h3 class="mb-5">Consulta de Bienes Institucionales</h3>

            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right" for="typeEmailX-2">Cédula</label>
              <div class="col-md-6">
                <input type="text" name="txtUsuario" class="form-control" onkeypress="return numeros(event)" maxlength="10" required/>
              </div>
            </div>
            <br>
            <!--<div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right" for="typeEmailX-2">Fec. Nacimiento</label>
              <div class="col-md-6">
                <input type="text" placeholder="dd/mm/yyyy" name="txtfecha" class="form-control" maxlength="10" required/>
              </div>
            </div>-->
            <button class="btn btn-lg btn-block btn-primary mb-2" style="background-color: #3b5998;" type="submit" name="selec">CONSULTAR</button>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>

<script src="sweetalert2.all.min.js"></script>
</html>

<script>
    function numeros(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
    }
</script>