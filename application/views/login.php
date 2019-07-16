<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>DepotSYS | LOGIN</title>

  <!-- Bootstrap core CSS -->
  <link href="/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
  <!-- Custom styles for this template -->
  <link href="/css/login.css" rel="stylesheet">
</head>

<body class="text-center">
<form class="form-signin" method="POST">
<h1 class="h3 mb-3 font-weight-normal">Pålogging</h1>
<?php if (isset($Feilmelding)) { ?>
  <div class="alert alert-danger">
    <?php echo $Feilmelding; ?>
  </div>
<?php } ?>
  <label for="inputEmail" class="sr-only">Brukernavn</label>
  <input type="text" id="Brukernavn" name="Brukernavn" class="form-control" placeholder="Brukernavn" value="<?php echo set_value('Brukernavn'); ?>" required autofocus>
  <label for="inputPassword" class="sr-only">Passord</label>
  <input type="password" id="Passord" name="Passord" class="form-control" placeholder="Passord" required>
  <button class="btn btn-lg btn-primary btn-block" type="submit" name="DoLogin" value="Send">Logg inn</button>
</form>
</body>
</html>

