<form method="POST" action="<?php echo site_url('materiell/materiell/'.$Materiell['MateriellID']); ?>">
<input type="hidden" name="MateriellID" value="<?php echo set_value('MateriellID',$Materiell['MateriellID']); ?>" />

<div class="card">
  <h5 class="card-header">Materiell</h5>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="MateriellID"><b>Materiell ID:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="MateriellID" value="-<?php echo $Materiell['MateriellID']; ?>" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Plassering"><b>Plassering:</b></label>
      <div class="col-sm-10">
        <select class="custom-select" id="Plassering" name="Plassering">
          <option value="">[ukjent/ingen plass]</option>
          <optgroup label="Kasser">
<?php
  foreach ($Kasser as $Kasse) {
?>
            <option value="=<?php echo $Kasse['KasseID']; ?>"<?php if ($Materiell['KasseID'] == $Kasse['KasseID']) { echo " selected"; } ?>><?php echo '='.$Kasse['Kode']." ".$Kasse['Navn']; ?></option>
<?php
  }
?>
          </optgroup>
          <optgroup label="Lokasjoner">
<?php
  foreach ($Lokasjoner as $Lokasjon) {
?>
            <option value="+<?php echo $Lokasjon['LokasjonID']; ?>"<?php if ($Materiell['LokasjonID'] == $Lokasjon['LokasjonID']) { echo " selected"; } ?>><?php echo '+'.$Lokasjon['Kode']." ".$Lokasjon['Navn']; ?></option>
<?php
  }
?>

          </optgroup>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label"><b>Beskrivelse:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Beskrivelse" name="Beskrivelse" value="<?php echo set_value('Beskrivelse',$Materiell['Beskrivelse']); ?>" required>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="ProdusentID"><b>Produsent:</b></label>
      <div class="col-sm-10">
        <select class="custom-select" id="ProdusentID" name="ProdusentID">
	  <option value="0">(ingen valgt)</option>
          <option disabled>──────</option>
<?php
  foreach ($Produsenter as $Produsent) {
?>
          <option value="<?php echo $Produsent['ProdusentID']; ?>"<?php if ($Materiell['ProdusentID'] == $Produsent['ProdusentID']) { echo " selected"; } ?>><?php echo $Produsent['Navn']; ?></option>
<?php
  }
?>
	</select>
      </div>
    </div>
<?php if (substr($Materiell['MateriellID'],-1,1) == 'T') { ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="AntallMin"><b>Antall minimum:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="AntallMin" name="AntallMin" value="<?php echo set_value('AntallMin',$Materiell['AntallMin']); ?>">
      </div>
    </div>
<?php } ?>
<?php if (substr($Materiell['MateriellID'],-1,1) != 'T') { ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="BatteritypeID"><b>Batteritype:</b></label>
      <div class="col-sm-10">
        <select class="custom-select" id="BatteritypeID" name="BatteritypeID">
	  <option value="0"<?php if ($Materiell['BatteritypeID'] == 0) { echo ' selected'; } ?>>(ingen valgt)</option>
	  <option disabled>──────</option>
<?php
  if (isset($Batterityper)) {
    foreach ($Batterityper as $Batteritype) {
?>
	  <option value="<?php echo $Batteritype['BatteritypeID']; ?>"<?php if ($Materiell['BatteritypeID'] == $Batteritype['BatteritypeID']) { echo " selected"; } ?>><?php echo $Batteritype['Navn']; ?></option>
<?php
    }
  }
?>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="BatteriAntall"><b>Antall batterier:</b></label>
      <div class="col-sm-10">
        <input type="number" class="form-control" id="BatteriAntall" name="BatteriAntall" value="<?php echo set_value('BatteriAntall',$Materiell['BatteriAntall']); ?>">
      </div>
    </div>
<?php } ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Notater"><b>Notater:</b></label>
      <div class="col-sm-10">
        <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Materiell['Notater']); ?></textarea>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="StatusID"><b>Status:</b></label>
      <div class="col-sm-10">
        <select class="custom-select" id="StatusID" name="StatusID">
	  <option value="1"<?php if ($Materiell['StatusID'] == 1) { echo ' selected'; } ?>>Operativt</option>
          <option value="0"<?php if ($Materiell['StatusID'] == 0) { echo ' selected'; } ?>>IKKE operativt</option>
        </select>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <div class="btn-group" role="group" aria-label="Skjema lagre">
      <input type="submit" class="btn btn-primary" value="Lagre" name="SkjemaLagre" />
      <input type="submit" class="btn btn-primary" value=">>" name="SkjemaLagreLukk" />
    </div>
    <div class="btn-group" role="group">
      <button id="SkjemaAvansert" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Flere valg
      </button>
      <div class="dropdown-menu" aria-labelledby="SkjemaAvansert">
        <a href="<?php echo site_url('materiell/slettmateriell?materiellid='.$Materiell['MateriellID']); ?>" class="dropdown-item">Slett materiell</a>
	<a href="<?php echo site_url('vedlikehold/nyttavvik?materiellid='.$Materiell['MateriellID']); ?>" class="dropdown-item">Nytt avvik</a>
	<a href="<?php echo site_url('vedlikehold/materielltelling?materiellid='.$Materiell['MateriellID']); ?>" class="dropdown-item">Telling</a>
        <a href="<?php echo site_url('vedlikehold/materiellkontroll?materiellid='.$Materiell['MateriellID']); ?>" class="dropdown-item">Kontroll</a>
      </div>
    </div>
  </div>
</div>
</form>
<br />

<?php if (substr($Materiell['MateriellID'],-1,1) != 'T') { ?>
<h5>Avviksliste</h5>
<div class="table-responsive">
  <table class="table table-bordered table-sm table-striped table-hover">
    <thead>
      <tr>
        <th>Avvik ID</th>
        <th>Registrert dato</th>
        <th>Registrert av</th>
        <th>Beskrivelse</th>
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
        <td><?php echo date('d.m.Y',strtotime($Avvik['DatoRegistrert'])); ?></td>
        <td><?php echo $Avvik['BrukerNavn']; ?></td>
        <td><?php echo $Avvik['Beskrivelse']; ?></td>
        <td><?php echo $Avvik['Status']; ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="5" class="text-center">Ingen åpne avvik registrert på materiellet.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
<?php } ?>

<?php if (substr($Materiell['MateriellID'],-1,1) != 'T') { ?>
<h5>Kontroller</h5>
<div class="table-responsive">
  <table class="table table-bordered table-sm table-striped table-hover">
    <thead>
      <tr>
        <th>Registrert</th>
	<th>Bruker</th>
        <th>Tilstand</th>
        <th>Kommentar</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Kontroller)) {
    foreach ($Kontroller as $Kontroll) {
?>
      <tr>
        <td><?php echo date('d.m.Y',strtotime($Kontroll['DatoRegistrert'])); ?></td>
	<td><?php echo $Kontroll['BrukerNavn']; ?></td>
        <td><?php echo $Kontroll['Tilstand']; ?></td>
        <td><?php echo $Kontroll['Kommentar']; ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="4" class="text-center">Ingen kontroller er gjennomført av materiellet.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
<?php } ?>

<?php if (substr($Materiell['MateriellID'],-1,1) == 'T') { ?>
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
        <td colspan="5" class="text-center">Ingen endringer er gjort på lageret for forbruksmateriellet.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
<?php } ?>
