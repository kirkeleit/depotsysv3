<form method="POST" action="<?php echo site_url('utstyr/utstyr/'.$Utstyr['UtstyrID']); ?>">
<input type="hidden" name="UtstyrID" value="<?php echo set_value('UtstyrID',$Utstyr['UtstyrID']); ?>" />

<div class="card">
  <div class="card-header"><b>Utstyr -<?php echo $Utstyr['UtstyrID']; ?></b></div>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="UtstyrID">Utstyr ID:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="UtstyrID" value="-<?php echo $Utstyr['UtstyrID']; ?>" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Plassering">Plassering:</label>
      <div class="col-sm-10">
        <select class="custom-select custom-select-sm" id="Plassering" name="Plassering">
          <option value="">[ukjent/ingen plass]</option>
          <optgroup label="Kasser">
<?php
  foreach ($Kasser as $Kasse) {
?>
            <option value="=<?php echo $Kasse['KasseID']; ?>"<?php if ($Utstyr['KasseID'] == $Kasse['KasseID']) { echo " selected"; } ?>><?php echo '='.$Kasse['KasseID']." ".$Kasse['Navn']; ?></option>
<?php
  }
?>
          </optgroup>
          <optgroup label="Lokasjoner">
<?php
  foreach ($Lokasjoner as $Lokasjon) {
?>
            <option value="+<?php echo $Lokasjon['LokasjonID']; ?>"<?php if ($Utstyr['LokasjonID'] == $Lokasjon['LokasjonID']) { echo " selected"; } ?>><?php echo '+'.$Lokasjon['LokasjonID']." ".$Lokasjon['Navn']; ?></option>
<?php
  }
?>

          </optgroup>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Beskrivelse:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Beskrivelse" name="Beskrivelse" value="<?php echo set_value('Beskrivelse',$Utstyr['Beskrivelse']); ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="ProdusentID">Produsent:</label>
      <div class="col-sm-10">
        <select class="custom-select custom-select-sm" id="ProdusentID" name="ProdusentID">
          <option value="0">[ingen]</option>
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
      <label class="col-sm-2 col-form-label" for="AntallMin">Antall minimum:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="AntallMin" name="AntallMin" value="<?php echo set_value('AntallMin',$Utstyr['AntallMin']); ?>">
      </div>
    </div>
<?php } ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Notater">Notater:</label>
      <div class="col-sm-10">
        <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Utstyr['Notater']); ?></textarea>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <input type="submit" class="btn btn-primary" value="Lagre" name="UtstyrLagre" />
    <input type="submit" class="btn btn-secondary" value="Slett" name="UtstyrSlett" />
    <a href="<?php echo site_url('utstyr/nyttavvik?uid='.$Utstyr['UtstyrID']); ?>" class="btn btn-warning" tabindex="-1" role="button">Nytt avvik</a>
  </div>
</div>
<br />

<div class="card">
  <div class="card-header"><b>Avviksliste</b></div>
  <div class="table-responsive">
    <table class="table table-sm table-striped table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Registrert dato</th>
	  <th>Registrert av</th>
          <th>Beskrivelse</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
<?php if (isset($Avviksliste)) { ?>
<?php
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
?>
<?php } ?>
      </tbody>
    </table>
  </div>
</div>

</form>
