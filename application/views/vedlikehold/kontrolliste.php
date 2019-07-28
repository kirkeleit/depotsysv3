<h2>Kontrolliste</h2>
<br />

<div class="card card-body">
<a data-toggle="collapse" href="#ListeFilter" role="button" aria-expanded="false" aria-controls="ListeFilter">Trykk her for å vise filter for listen.</a></div>
</div>
<br />

<form method="POST" action="<?php echo site_url('utstyr/kontrolliste'); ?>">
<div class="card card-body collapse" id="ListeFilter">
  <div class="form-group row">
    <label class="col-sm-2 col-form-label" for="LokasjonID"><b>Lokasjon:</b></label>
    <div class="col-sm-10">
      <select class="form-control" id="FilterLokasjonID" name="FilterLokasjonID">
        <option value="">[ingen filter]</option>
<?php
  foreach ($Lokasjoner as $Lokasjon) {
?>
        <option value="<?php echo $Lokasjon['LokasjonID']; ?>"<?php if ($Lokasjon['LokasjonID'] == substr($this->input->get('filterplassering'),1)) { echo " selected"; } ?>><?php echo "+".$Lokasjon['Kode']." ".$Lokasjon['Navn']; ?></option>

<?php
  }
?>
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label" for="KasseID"><b>Kasse:</b></label>
    <div class="col-sm-10">
      <select class="form-control" id="FilterKasseID" name="FilterKasseID">
        <option value="">[ingen filter]</option>
<?php
  foreach ($Kasser as $Kasse) {
?>
        <option value="<?php echo $Kasse['KasseID']; ?>"<?php if ($Kasse['KasseID'] == substr($this->input->get('filterplassering'),1)) { echo " selected"; } ?>><?php echo "=".$Kasse['Kode']." ".$Kasse['Navn']; ?></option>
<?php
  }
?>
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">&nbsp;</label>
    <div class="col-sm-10">
      <input type="submit" class="btn btn-primary" name="FiltrerListe" value="Filtrer" />
    </div>
  </div>
</div>
</form>
<br />

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead>
      <tr>
        <th>Utstyr ID</th>
        <th>Produsent</th>
	<th>Beskrivelse</th>
        <th>Plassering</th>
	<th>Sist kontrollert</th>
        <th>Kontrollintervall</th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
      if (($Utstyr['KontrollDager'] > 0) and (((((time()-strtotime($Utstyr['DatoKontrollert'])) / 60) / 60) / 24) >= $Utstyr['KontrollDager'])) {
?>
        <tr>
	  <th><a href="<?php echo site_url('utstyr/utstyr/'.$Utstyr['UtstyrID']); ?>" target="_new"><?php echo "-".$Utstyr['UtstyrID']; ?></a><input type="hidden" name="UtstyrID[]" value="<?php echo $Utstyr['UtstyrID']; ?>"></th>
          <td><?php echo $Utstyr['ProdusentNavn']; ?></td>
	  <td><?php echo $Utstyr['Beskrivelse']; ?></td>
          <td><?php if (strlen($Utstyr['LokasjonID']) > 0) { echo $Utstyr['Lokasjon']; } else { echo "&nbsp;"; } ?><?php if (strlen($Utstyr['KasseID']) > 0) { echo $Utstyr['Kasse']; } else { echo "&nbsp;"; } ?></td>
	  <td<?php if ($Utstyr['DatoKontrollert'] == '') { echo ' class="bg-danger text-white"'; } ?>><?php if ($Utstyr['DatoKontrollert'] == '') { echo "Aldri kontrollert"; } else { echo date('d.m.Y',strtotime($Utstyr['DatoKontrollert'])).' ('.floor((((time()-strtotime($Utstyr['DatoKontrollert'])) / 60) / 60) / 24).')'; } ?></td>
          <td><?php echo $Utstyr['KontrollDager'].' dager'; ?></td>
          <td><a href="<?php echo site_url('utstyr/utstyrkontroll?utstyrid='.$Utstyr['UtstyrID']); ?>" target="_new">Kontroller</a></td>
        </tr>
<?php
      }
    }
  } else {
?>
      <tr>
        <td colspan="6" class="text-center">Ingen utstyr er tilgjengelig for kontroll.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
