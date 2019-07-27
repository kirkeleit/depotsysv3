<?php if (substr($Utstyr['UtstyrID'],-1,1) != 'T') { ?>
<div class="card card-body bg-warning">
Utstyr '-<?php echo $Utstyr['UtstyrID']; ?>' er ikke registrert som forbruksmateriell, og kan derfor ikke telles i forhold til lagerbeholdning.
</div>
<?php } else { ?>
<form method="POST" action="<?php echo site_url('utstyr/utstyrtelling?utstyrid='.$Utstyr['UtstyrID']); ?>">
<input type="hidden" name="UtstyrID" value="<?php echo set_value('UtstyrID',$Utstyr['UtstyrID']); ?>" />

<div class="card">
  <h5 class="card-header">Utstyr</h5>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="UtstyrID"><b>Utstyr ID:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="UtstyrID" value="-<?php echo $Utstyr['UtstyrID']; ?>" readonly>
      </div>
    </div>
<?php if ($Utstyr['LokasjonID'] > 0) { ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Lokasjon"><b>Lokasjon:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="Lokasjon" value="<?php echo $Utstyr['Lokasjon']; ?>" readonly>
      </div>
    </div>
<?php } ?>
<?php if ($Utstyr['KasseID'] > 0) { ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Kasse"><b>Kasse:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="Kasse" value="<?php echo $Utstyr['Kasse']; ?>" readonly>
      </div>
    </div>
<?php } ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label"><b>Beskrivelse:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="Beskrivelse" value="<?php echo $Utstyr['Beskrivelse']; ?>" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="ProdusentID"><b>Produsent:</b></label>
      <div class="col-sm-10">
	<input type="text" class="form-control-plaintext" id="ProdusentID" value="<?php echo $Utstyr['ProdusentNavn']; ?>" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Antall"><b>Antall på lager:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="Antall" name="Antall" value="<?php if (isset($Utstyr['Antall'])) { echo $Utstyr['Antall']; } else { echo "0"; } ?>" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="AntallMin"><b>Antall minimum:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="AntallMin" value="<?php echo $Utstyr['AntallMin']; ?>" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="NyttAntall"><b>Nytt antall:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="NyttAntall" name="NyttAntall" required>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <div class="btn-group" role="group" aria-label="Skjema lagre">
      <input type="submit" class="btn btn-primary" value="Lagre" name="SkjemaLagre" />
    </div>
  </div>
</div>
</form>
<br />

<h5>Lagerendringer</h5>
<div class="table-responsive">
  <table class="table table-bordered table-sm table-striped table-hover">
    <thead>
      <tr>
        <th>Dato</th>
	<th>Bruker</th>
	<th>Antall</th>
        <th>Endring</th>
        <th>Kommentar</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Lagerendringer)) {
    foreach ($Lagerendringer as $Lagerendring) {
?>
      <tr>
        <td><?php echo date('d.m.Y',strtotime($Lagerendring['DatoRegistrert'])); ?></td>
	<td><?php echo $Lagerendring['BrukerNavn']; ?></td>
	<td><?php echo $Lagerendring['Antall']; ?></td>
        <td><?php echo $Lagerendring['EndringType']; ?></td>
        <td><?php echo $Lagerendring['Kommentar']; ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="5" class="text-center">Ingen endringer er gjort på lageret for utstyret.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
<?php } ?>
