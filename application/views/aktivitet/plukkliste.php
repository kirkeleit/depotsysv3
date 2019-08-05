<form method="POST" action="<?php echo site_url('aktivitet/plukkliste/'.$Plukkliste['PlukklisteID']); ?>">
<input type="hidden" name="PlukklisteID" value="<?php echo set_value('PlukklisteID',$Plukkliste['PlukklisteID']); ?>" />
<input type="hidden" name="PlukklisteTypeID" value="1" />
<div class="card">
  <h6 class="card-header bg-secondary text-white"><?php echo (!is_numeric($Plukkliste['PlukklisteID'])?'Ny ':''); ?>Plukkliste<?php echo (is_numeric($Plukkliste['PlukklisteID'])?' #'.$Plukkliste['PlukklisteID']:''); ?></h6>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="AktivitetID"><b>Aktivitet:</b></label>
      <div class="col-sm-10">
        <select class="custom-select" id="AktivitetID" name="AktivitetID">
          <option value="0">(ikke valgt)</option>
          <option disabled>──────</option>
<?php
  if (isset($Aktiviteter)) {
    foreach ($Aktiviteter as $Aktivitet) {
?>
          <option value="<?php echo $Aktivitet['AktivitetID']; ?>"<?php if ($Aktivitet['AktivitetID'] == $Plukkliste['AktivitetID']) { echo " selected"; } ?>><?php echo $Aktivitet['Navn']; ?></option>
<?php
    }
  }
?>
	</select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Navn"><b>Navn:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Navn" name="Navn" value="<?php echo set_value('Navn',$Plukkliste['Navn']); ?>" required>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="AnsvarligBrukerID"><b>Ansvarlig:</b></label>
      <div class="col-sm-10">
        <select class="custom-select" id="AnsvarligBrukerID" name="AnsvarligBrukerID" required>
          <option value="">(ikke valgt)</option>
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
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="StatusID"><b>Status:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="Status" value="<?php echo $Plukkliste['Status']; ?>" readonly>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <div class="btn-group" role="group" aria-label="Skjema lagre">
      <input type="submit" class="btn btn-success" value="<?php echo (isset($Plukkliste)?'Lagre':'Opprett'); ?>" name="SkjemaLagre" />
      <input type="submit" class="btn btn-success" value=">>" name="SkjemaLagreLukk" />
    </div>
<?php if (is_numeric($Plukkliste['PlukklisteID'])) { ?>
    <div class="btn-group" role="group">
      <button id="SkjemaAvansert" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Flere valg
      </button>
      <div class="dropdown-menu" aria-labelledby="SkjemaAvansert">
<?php if (isset($Plukkliste['PlukklisteID']) and ($Plukkliste['StatusID'] == 0)) { ?>
	<a href="<?php echo site_url('aktivitet/slettplukkliste?plukklisteid='.$Plukkliste['PlukklisteID']); ?>" class="dropdown-item">Slett plukkliste</a>
	<a href="<?php echo site_url('aktivitet/utregistrering/'.$Plukkliste['PlukklisteID']); ?>" class="dropdown-item">Utregistrering</a>
<?php } ?>
      </div>
    </div>
<?php if ($Plukkliste['StatusID'] == 0) { ?>
    <input type="submit" class="btn btn-success" value="Utlevert" name="PlukklisteUtlevert" />
<?php } ?>
<?php } ?>
  </div>
</div>
</form>
<br />

<?php if (is_numeric($Plukkliste['PlukklisteID'])) { ?>
<form method="POST" action="<?php echo site_url('aktivitet/plukkliste/'.$Plukkliste['PlukklisteID']); ?>">
<input type="hidden" name="PlukklisteID" value="<?php echo set_value('PlukklisteID',$Plukkliste['PlukklisteID']); ?>" />
<h5>Materielliste</h5>
<div class="table-responsive">
  <table class="table table-bordered table-sm table-striped table-hover">
    <thead>
      <tr>
        <th>Materiell ID</th>
        <th>Produsent</th>
        <th>Beskrivelse</th>
	<th>UT / INN</th>
        <th>&nbsp;</td>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Materielliste)) {
    foreach ($Materielliste as $Materiell) {
?>
      <tr>
        <th><a href="<?php echo site_url('materiell/materiell/'.$Materiell['MateriellID']); ?>" class="text-nowrap"><?php echo "-".$Materiell['MateriellID']; ?></a></th>
        <td><?php if ($Materiell['ProdusentID'] > 0) { echo $Materiell['ProdusentNavn']; } else { echo "&nbsp;"; } ?></td>
        <td><?php echo $Materiell['Beskrivelse']; ?></td>
	<td><?php echo $Materiell['UtAntall']." / ".$Materiell['InnAntall']; ?></td>
<?php
      if ($Plukkliste['StatusID'] == 0) {
        if (substr($Materiell['MateriellID'],-1,1) == 'T') {
?>
	<td><button type="submit" class="btn btn-sm btn-secondary" name="FjernMateriell" value="<?php echo $Materiell['MateriellID']; ?>">Fjern</button></td>
<?php
        } else {
?>
	<td><button type="submit" class="btn btn-sm btn-secondary" name="FjernMateriell" value="<?php echo $Materiell['MateriellID']; ?>">Fjern</button></td>
<?php
        }
      } elseif ($Plukkliste['StatusID'] < 3) {
        if ($Materiell['UtAntall'] > $Materiell['InnAntall']) {
?>
	<td><button type="submit" class="btn btn-sm btn-success" name="RegistrerInnMateriell" value="<?php echo $Materiell['MateriellID']; ?>">REG.INN</button></td>
<?php
        } else {
?>
        <td>&nbsp;</td>
<?php
        }
      } else {
?>
        <td>&nbsp;</td>
<?php
      }
?>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="6" class="text-center">Ingen materiell er lagt til på denne plukklisten enda.</td>
      </tr>
<?php
  }
  if ($Plukkliste['StatusID'] == 0) {
?>
</form>
<form method="POST" action="<?php echo site_url('aktivitet/plukkliste_leggtilmateriell'); ?>">
<input type="hidden" name="PlukklisteID" value="<?php echo $Plukkliste['PlukklisteID']; ?>" />
      <tr>
        <td colspan="2"><input type="text" name="MateriellID" id="MateriellID" class="form-control-sm" placeholder="Skriv inn materiell ID her!" autofocus></td>
        <td colspan="4">&nbsp;</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
</form>
<?php } ?>
