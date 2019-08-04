<?php if (substr($Materiell['MateriellID'],-1,1) != 'T') { ?>
<div class="card card-body bg-warning">
Materiell '-<?php echo $Materiell['MateriellID']; ?>' er ikke registrert som forbruksmateriell, og kan derfor ikke telles i forhold til lagerbeholdning.
</div>
<?php } else { ?>
<form method="POST" action="<?php echo site_url('vedlikehold/materielltelling?materiellid='.$Materiell['MateriellID']); ?>">
<input type="hidden" name="MateriellID" value="<?php echo set_value('MateriellID',$Materiell['MateriellID']); ?>" />

<div class="card">
  <h5 class="card-header">Materielltelling</h5>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="MateriellID"><b>Materiell ID:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="MateriellID" value="-<?php echo $Materiell['MateriellID']; ?>" readonly>
      </div>
    </div>
<?php if ($Materiell['LokasjonID'] > 0) { ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Lokasjon"><b>Lokasjon:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="Lokasjon" value="<?php echo $Materiell['Lokasjon']; ?>" readonly>
      </div>
    </div>
<?php } ?>
<?php if ($Materiell['KasseID'] > 0) { ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Kasse"><b>Kasse:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="Kasse" value="<?php echo $Materiell['Kasse']; ?>" readonly>
      </div>
    </div>
<?php } ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label"><b>Beskrivelse:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="Beskrivelse" value="<?php echo $Materiell['Beskrivelse']; ?>" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="ProdusentID"><b>Produsent:</b></label>
      <div class="col-sm-10">
	<input type="text" class="form-control-plaintext" id="ProdusentID" value="<?php echo $Materiell['ProdusentNavn']; ?>" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Antall"><b>Antall på lager:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="Antall" name="Antall" value="<?php if (isset($Materiell['Antall'])) { echo $Materiell['Antall']; } else { echo "0"; } ?>" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="AntallMin"><b>Antall minimum:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="AntallMin" value="<?php echo $Materiell['AntallMin']; ?>" readonly>
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
        <td colspan="5" class="text-center">Ingen endringer er gjort på lageret for materiellet.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
<?php } ?>
