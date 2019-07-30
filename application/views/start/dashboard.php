<?php
  $UtstyrAlt = (!empty($UtstyrslisteKomplett)?sizeof($UtstyrslisteKomplett):0);
  $UtstyrIkkeOperativt = (!empty($UtstyrslisteIkkeOperativt)?sizeof($UtstyrslisteIkkeOperativt):0);
  $UtstyrOperativt = $UtstyrAlt-$UtstyrIkkeOperativt;
  $AntallPlukklister = (!empty($Plukklister)?sizeof($Plukklister):0);
  $AntallAvvik = (!empty($Avviksliste)?sizeof($Avviksliste):0);
?>
<div class="card-deck text-center text-white">
  <div class="card bg-secondary">
    <div class="card-header"><h4>OPERATIVT UTSTYR</h4></div>
    <div class="card-body"><h1><?php echo $UtstyrOperativt.' stk'; ?></h1></div>
  </div>
  <div class="card bg-secondary">
    <div class="card-header"><h4>IKKE-OPERATIVT UTSTYR</h4></div>
    <div class="card-body"><h1><?php echo $UtstyrIkkeOperativt.' stk'; ?></h1></div>
  </div>
  <div class="card bg-secondary">
    <div class="card-header"><h4>PLUKKLISTER</h4></div>
    <div class="card-body"><h1><?php echo $AntallPlukklister.' stk'; ?></h1></div>
  </div>
  <div class="card bg-secondary">
    <div class="card-header"><h4>AVVIK</h4></div>
    <div class="card-body"><h1><?php echo $AntallAvvik.' stk'; ?></h1></div>
  </div>
</div>
<br />

<h2>Åpne avvik</h2>
<br />

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead class="thead-secondary">
      <tr>
        <th>#</th>
        <th>Registrert den</th>
        <th>Registrert av</th>
        <th>Utstyr ID</th>
        <th>Beskrivelse</th>
        <th>Kostnad</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Avviksliste)) {
    foreach ($Avviksliste as $Avvik) {
?>
      <tr>
        <th><a href="<?php echo site_url('utstyr/avvik/'.$Avvik['AvvikID']); ?>"><?php echo $Avvik['AvvikID']; ?></a></th>
        <td><?php echo date("d.m.Y",strtotime($Avvik['DatoRegistrert'])); ?></td>
        <td><?php echo $Avvik['BrukerNavn']; ?></td>
        <td><a href="<?php echo site_url('utstyr/utstyr/'.$Avvik['UtstyrID']); ?>"><?php echo "-".$Avvik['UtstyrID']; ?></a></td>
        <td><?php echo word_limiter($Avvik['Beskrivelse'],10); ?></td>
        <td><?php if ($Avvik['Kostnad'] > 0) { echo 'kr '.$Avvik['Kostnad']; } else { echo "&nbsp;"; } ?></td>
        <td><?php echo $Avvik['Status']; ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="7" class="text-center">Ingen åpne avvik registrert.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
