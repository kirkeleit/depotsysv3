<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="generator" content="">
  <title>DepotSYS</title>

  <!-- Bootstrap core CSS -->
  <link href="/css/bootstrap.min.css" rel="stylesheet">

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
  <link href="/css/standard.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <a class="navbar-brand" href="#">DepotSYS</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarKomponenter" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Komponenter
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarKomponenter">
	  <a class="dropdown-item" href="<?php echo site_url('komponenter/liste'); ?>">Liste</a>
	  <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?php echo site_url('komponenter/lokasjoner'); ?>">Lokasjoner</a>
	  <a class="dropdown-item" href="<?php echo site_url('komponenter/kasser'); ?>">Kasser</a>
          <a class="dropdown-item" href="<?php echo site_url('komponenter/komponenttyper'); ?>">Komponenttyper</a>
	  <a class="dropdown-item" href="<?php echo site_url('komponenter/produsenter'); ?>">Produsenter</a>
        </div>
      </li>

    </ul>
    <form class="form-inline mt-2 mt-md-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

<main role="main" class="container-fluid">
<?php if ($this->session->flashdata('Feilmelding')) { ?>
  <div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('Feilmelding'); ?></div>
<?php } ?>
<?php if ($this->session->flashdata('Infomelding')) { ?>
  <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('Infomelding'); ?></div>
<?php } ?>
<?php echo $contents; ?>
</main>

<script src="/js/jquery-3.4.1.js"></script>
<script>window.jQuery || document.write('<script src="/js/jquery-3.4.1.js"><\/script>')</script><script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
