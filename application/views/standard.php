<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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

<nav class="navbar navbar-expand-lg navbar-light fixed-top bg-light border-bottom border-secondary">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarDepotsys" aria-controls="navbarDepotsys" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarDepotsys">
    <a class="navbar-brand" href="<?php echo site_url('start/dashboard'); ?>">DepotSYS</a>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarAktivitet" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Aktivitet
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarAktivitet">
          <a class="dropdown-item" href="<?php echo site_url('aktivitet/nyplukkliste'); ?>">Ny plukkliste</a>
	  <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?php echo site_url('aktivitet/innregistrering'); ?>">Innregistrering</a>
          <a class="dropdown-item" href="<?php echo site_url('aktivitet/aktiviteter'); ?>">Aktiviteter</a>
	  <a class="dropdown-item" href="<?php echo site_url('aktivitet/plukklister'); ?>">Plukklister</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarUtstyr" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Utstyr
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarUtstyr">
	  <a class="dropdown-item" href="<?php echo site_url('utstyr/utstyrsliste'); ?>">Utstyrsliste</a>
	  <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?php echo site_url('utstyr/utstyrstyper'); ?>">Utstyrstyper</a>
          <a class="dropdown-item" href="<?php echo site_url('utstyr/lokasjoner'); ?>">Lokasjoner</a>
	  <a class="dropdown-item" href="<?php echo site_url('utstyr/kasser'); ?>">Kasser</a>
	  <a class="dropdown-item" href="<?php echo site_url('utstyr/produsenter'); ?>">Produsenter</a>
          <a class="dropdown-item" href="<?php echo site_url('utstyr/batterityper'); ?>">Batterityper</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarVedlikehold" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Vedlikehold
        </a>
	<div class="dropdown-menu" aria-labelledby="navbarVedlikehold">
	  <a class="dropdown-item" href="<?php echo site_url('vedlikehold/avviksliste'); ?>">Avviksliste</a>
	  <a class="dropdown-item" href="<?php echo site_url('vedlikehold/kontrolliste'); ?>">Kontrolliste</a>
          <a class="dropdown-item" href="<?php echo site_url('vedlikehold/bestillingsliste'); ?>">Bestillingsliste</a>
	</div> 
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarOppsett" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Oppsett
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarOppsett">
	  <a class="dropdown-item" href="<?php echo site_url('oppsett/brukere'); ?>">Brukere</a>
          <a class="dropdown-item" href="<?php echo site_url('oppsett/roller'); ?>">Roller</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarMinProfil" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<?php echo $this->session->userdata('Fornavn'); ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarMinBruker">
	  <a class="dropdown-item" href="<?php echo site_url('oppsett/minprofil'); ?>">Min profil</a>
          <a class="dropdown-item" href="<?php echo site_url('utstyr/mittutstyr'); ?>">Utlevert utstyr</a>
          <a class="dropdown-item" href="<?php echo site_url('utstyr/mineplukklister'); ?>">Mine plukklister</a>
	  <a class="dropdown-item" href="<?php echo site_url('start/logout'); ?>">Logg ut</a>
        </div>
      </li>
    </ul>
    <form class="form-inline" method="POST" action="<?php echo site_url('utstyr/utstyrssok'); ?>">
    <input class="form-control mr-sm-2" type="search" name="Sokestreng" placeholder="Søk etter" aria-label="Search">
    <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Finn</button>
    </form>
  </div>
</nav>

<main role="main" class="container-fluid">
<?php
  if ($this->session->flashdata('GUIMeldinger')) {
    foreach ($this->session->flashdata('GUIMeldinger') as $Melding) {
?>
  <div class="alert <?php if ($Melding['Type'] == 0) { echo ' alert-success'; } else { echo ' alert-danger'; } ?>" role="alert"><?php echo $Melding['Tekst']; ?></div>
<?php
    }
  }
?>

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
