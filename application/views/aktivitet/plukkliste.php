<form method="POST" action="<?php echo site_url('utstyr/plukkliste/'.$Plukkliste['PlukklisteID']); ?>">
<input type="hidden" name="PlukklisteID" value="<?php echo set_value('PlukklisteID',$Plukkliste['PlukklisteID']); ?>" />

<div class="card">
  <h5 class="card-header">Plukkliste</h5>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Beskrivelse"><b>Beskrivelse:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Beskrivelse" name="Beskrivelse" value="<?php echo set_value('Beskrivelse',$Plukkliste['Beskrivelse']); ?>" required>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="AnsvarligBrukerID"><b>Ansvarlig:</b></label>
      <div class="col-sm-10">
        <select class="custom-select" id="AnsvarligBrukerID" name="AnsvarligBrukerID">
          <option value="0">(ikke valgt)</option>
          <option disabled>──────</option>
<?php
  if (isset($Brukere)) {
    foreach ($Brukere as $Bruker) {
?>
          <option value="<?php echo $Bruker['BrukerID']; ?>"<?php if ($Bruker['BrukerID'] == $Plukkliste['AnsvarligBrukerID']) { echo " selected"; } ?>><?php echo $Bruker['Fornavn'].' '.$Bruker['Etternavn']; ?></option>
<?php
    }
  }
?>
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
	<a href="<?php echo site_url('utstyr/slettplukkliste?plukklisteid='.$Plukkliste['PlukklisteID']); ?>" class="dropdown-item">Slett plukkliste</a>
<?php if ($Plukkliste['StatusID'] == 0) { ?>
	<a href="<?php echo site_url('utstyr/utregistrering/'.$Plukkliste['PlukklisteID']); ?>" class="dropdown-item">Utregistrering</a>
<?php } ?>
      </div>
    </div>
  </div>
</div>
</form>
<br />

<h5>Utstyrsliste</h5>
<div class="table-responsive">
  <table class="table table-bordered table-sm table-striped table-hover">
    <thead>
      <tr>
        <th>Utstyr ID</th>
        <th>Produsent</th>
        <th>Beskrivelse</th>
        <th>Antall</th>
        <th>Avvik</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
?>
      <tr>
        <th><a href="<?php echo site_url('utstyr/utstyr/'.$Utstyr['UtstyrID']); ?>"><?php echo "-".$Utstyr['UtstyrID']; ?></a></th>
        <td><?php if ($Utstyr['ProdusentID'] > 0) { echo $Utstyr['ProdusentNavn']; } else { echo "&nbsp;"; } ?></td>
        <td><?php echo $Utstyr['Beskrivelse']; ?></td>
        <td><?php if (substr($Utstyr['UtstyrID'],-1,1) == 'T') { echo $Utstyr['Antall']." stk"; } else { echo "&nbsp;"; } ?></td>
        <td<?php if ($Utstyr['AntallAvvik'] > 0) { echo ' class="bg-danger text-white"'; } ?>><?php if ($Utstyr['AntallAvvik'] > 0) { echo $Utstyr['AntallAvvik'].' stk'; } else { echo '&nbsp;'; } ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="5" class="text-center">Ingen utstyr er lagt til på denne plukklisten enda.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
