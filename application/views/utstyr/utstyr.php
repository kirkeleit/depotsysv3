<form method="POST" action="<?php echo site_url('utstyr/utstyr/'.$Utstyr['UtstyrID']); ?>">
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
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Plassering"><b>Plassering:</b></label>
      <div class="col-sm-10">
        <select class="custom-select custom-select-sm" id="Plassering" name="Plassering">
          <option value="">[ukjent/ingen plass]</option>
          <optgroup label="Kasser">
<?php
  foreach ($Kasser as $Kasse) {
?>
            <option value="=<?php echo $Kasse['KasseID']; ?>"<?php if ($Utstyr['KasseID'] == $Kasse['KasseID']) { echo " selected"; } ?>><?php echo '='.$Kasse['Kode']." ".$Kasse['Navn']; ?></option>
<?php
  }
?>
          </optgroup>
          <optgroup label="Lokasjoner">
<?php
  foreach ($Lokasjoner as $Lokasjon) {
?>
            <option value="+<?php echo $Lokasjon['LokasjonID']; ?>"<?php if ($Utstyr['LokasjonID'] == $Lokasjon['LokasjonID']) { echo " selected"; } ?>><?php echo '+'.$Lokasjon['Kode']." ".$Lokasjon['Navn']; ?></option>
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
        <input type="text" class="form-control" id="Beskrivelse" name="Beskrivelse" value="<?php echo set_value('Beskrivelse',$Utstyr['Beskrivelse']); ?>" required>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="ProdusentID"><b>Produsent:</b></label>
      <div class="col-sm-10">
        <select class="custom-select custom-select-sm" id="ProdusentID" name="ProdusentID">
          <option value="0">(ingen valgt)</option>
<?php
  foreach ($Produsenter as $Produsent) {
?>
          <option value="<?php echo $Produsent['ProdusentID']; ?>"<?php if ($Utstyr['ProdusentID'] == $Produsent['ProdusentID']) { echo " selected"; } ?>><?php echo $Produsent['Navn']; ?></option>
<?php
  }
?>
	</select>
      </div>
    </div>
<?php if (substr($Utstyr['UtstyrID'],-1,1) == 'T') { ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="AntallMin"><b>Antall minimum:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="AntallMin" name="AntallMin" value="<?php echo set_value('AntallMin',$Utstyr['AntallMin']); ?>">
      </div>
    </div>
<?php } ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="BatteriType"><b>Batteritype:</b></label>
      <div class="col-sm-10">
        <select class="custom-select custom-select-sm" id="BatteriType" name="BatteriType">
	  <option value=""<?php if ($Utstyr['BatteriType'] == '') { echo ' selected'; } ?>>Trenger ikke batteri</option>
	  <option value="AA"<?php if ($Utstyr['BatteriType'] == 'AA') { echo ' selected'; } ?>>AA batterier</option>
	  <option value="AAA"<?php if ($Utstyr['BatteriType'] == 'AAA') { echo ' selected'; } ?>>AAA batterier</option>
          <option value="C"<?php if ($Utstyr['BatteriType'] == 'C') { echo ' selected'; } ?>>C/LR6 batterier</option>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="BatteriAntall"><b>Antall batterier:</b></label>
      <div class="col-sm-10">
        <input type="number" class="form-control" id="BatteriAntall" name="BatteriAntall" value="<?php echo set_value('BatteriAntall',$Utstyr['BatteriAntall']); ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Notater"><b>Notater:</b></label>
      <div class="col-sm-10">
        <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Utstyr['Notater']); ?></textarea>
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
        <a href="<?php echo site_url('utstyr/slettutstyr?utstyrid='.$Utstyr['UtstyrID']); ?>" class="dropdown-item">Slett utstyret</a>
	<a href="<?php echo site_url('utstyr/nyttavvik?utstyrid='.$Utstyr['UtstyrID']); ?>" class="dropdown-item">Nytt avvik</a>
        <a href="<?php echo site_url('utstyr/utstyrtelling?utstyrid='.$Utstyr['UtstyrID']); ?>" class="dropdown-item">Telling</a>
      </div>
    </div>
  </div>
</div>
</form>
<br />

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
        <td colspan="5" class="text-center">Ingen åpne avvik registrert på utstyret.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>

<h5>Kontroller</h5>
<div class="table-responsive">
  <table class="table table-bordered table-sm table-striped table-hover">
    <thead>
      <tr>
        <th>Registrert</th>
        <th>Bruker</th>
        <th>Kommentar</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Kontrollogg)) {
    foreach ($Kontrollogg as $Logg) {
?>
      <tr>
        <td><?php echo date('d.m.Y',strtotime($Logg['DatoRegistrert'])); ?></td>
        <td><?php echo $Logg['BrukerNavn']; ?></td>
        <td><?php echo $Logg['Kommentar']; ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="5" class="text-center">Ingen kontroller er gjennomført av utstyret.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>

<?php if (substr($Utstyr['UtstyrID'],-1,1) == 'T') { ?>
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
