<h2>Telleliste</h2>
<br />
<div class="card card-body">Tellelisten brukes for å raskt telle over forbruksmateriell. Alt materiell som er listet opp med et minimumsantall hvor registrert antall er mindre, er merket med gult. Skriv inn antall forbruksmateriell du teller på relevant linje, og trykk på lagre. Dersom nytt antall er mindre enn minimumsantall så vil forbruksmateriellet bli listet opp på bestillingslisten.</div>
<br />

<form method="POST" action="<?php echo site_url('utstyr/telleliste'); ?>">
<a class="btn btn-primary btn-sm" data-toggle="collapse" href="#ListeFilter" role="button" aria-expanded="false" aria-controls="ListeFilter">Filter</a></div>
<div class="card card-body collapse" id="ListeFilter">
  <div class="form-group row">
    <label class="col-sm-2 col-form-label" for="LokasjonID"><b>Lokasjon:</b></label>
    <div class="col-sm-10">
      <select class="form-control" id="FilterLokasjonID" name="FilterLokasjonID">
        <option value="">[ingen filter]</option>
<?php
  foreach ($Lokasjoner as $Lokasjon) {
?>
        <option value="<?php echo $Lokasjon['LokasjonID']; ?>"<?php if ($Lokasjon['LokasjonID'] == substr($this->input->get('filterplassering'),1)) { echo " selected"; } ?>><?php echo "+".$Lokasjon['LokasjonID']." ".$Lokasjon['Navn']; ?></option>

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
        <option value="<?php echo $Kasse['KasseID']; ?>"<?php if ($Kasse['KasseID'] == substr($this->input->get('filterplassering'),1)) { echo " selected"; } ?>><?php echo "=".$Kasse['KasseID']." ".$Kasse['Navn']; ?></option>
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

<form method="POST" action="<?php echo site_url('utstyr/telleliste'); ?>">
<?php if (isset($FilterKasseID)) { ?>
<input type="hidden" name="FilterKasseID" value="<?php echo $FilterKasseID; ?>">
<?php } ?>
<?php if (isset($FilterLokasjonID)) { ?>
<input type="hidden" name="FilterLokasjonID" value="<?php echo $FilterLokasjonID; ?>">
<?php } ?>
<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead>
      <tr>
        <th>Utstyr ID</th>
        <th>Produsent</th>
        <th>Beskrivelse</th>
        <th>Plassering</th>
        <th>Kontrollert</th>
        <th>Minimum</th>
        <th>Antall</th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
?>
      <tr<?php if ($Utstyr['Antall'] < $Utstyr['AntallMin']) { echo ' class="bg-warning"'; } ?>>
        <th><a href="<?php echo site_url('utstyr/utstyr/'.$Utstyr['UtstyrID']); ?>"><?php echo '-'.$Utstyr['UtstyrID']; ?></a><input type="hidden" name="UtstyrID[]" value="<?php echo $Utstyr['UtstyrID']; ?>"></th>
        <td><?php echo $Utstyr['ProdusentNavn']; ?></td>
        <td><?php echo $Utstyr['Beskrivelse']; ?></td>
        <td><?php if (strlen($Utstyr['LokasjonID']) > 0) { echo "+".$Utstyr['LokasjonID']; } else { echo "&nbsp;"; } ?><?php if (strlen($Utstyr['KasseID']) > 0) { echo "=".$Utstyr['KasseID']; } else { echo "&nbsp;"; } ?></td>
        <td><?php if ($Utstyr['DatoKontrollert'] == '') { echo "&nbsp;"; } else { echo date('d.m.Y',strtotime($Utstyr['DatoKontrollert'])); } ?></td>
        <td><?php echo $Utstyr['AntallMin']; ?></td>
        <td><?php echo $Utstyr['Antall']; ?></td>
        <td><input type="number" class="form-control" name="NyttAntall[]" ><input type="hidden" name="Antall[]" value="<?php echo $Utstyr['Antall']; ?>"></td>
      </tr>
<?php
    }
  }
?>
    </tbody>
  </table>
</div>
<input type="submit" class="btn btn-sm btn-primary" name="TellingLagre" value="Lagre">
</form>
