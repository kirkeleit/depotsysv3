<form method="POST" action="<?php echo site_url('aktivitet/aktivitet/'.$Aktivitet['AktivitetID']); ?>">
<input type="hidden" name="AktivitetID" value="<?php echo set_value('AktivitetID',$Aktivitet['AktivitetID']); ?>" />
<div class="card">
  <h6 class="card-header bg-secondary text-white"><?php echo (!isset($Aktivitet)?'Ny ':''); ?>Aktivitet<?php echo (isset($Aktivitet)?' #'.$Aktivitet['AktivitetID']:''); ?></h6>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Navn"><b>Navn:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Navn" name="Navn" value="<?php echo set_value('Navn',$Aktivitet['Navn']); ?>" required>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Notater"><b>Notater:</b></label>
      <div class="col-sm-10">
        <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Aktivitet['Notater']); ?></textarea>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <div class="btn-group" role="group" aria-label="Skjema lagre">
    <input type="submit" class="btn btn-success" value="<?php echo (isset($Aktivitet)?'Lagre':'Opprett'); ?>" name="SkjemaLagre" />
      <input type="submit" class="btn btn-success" value=">>" name="SkjemaLagreLukk" />
    </div>
<?php if (isset($Aktivitet)) { ?>
    <div class="btn-group" role="group">
      <button id="SkjemaAvansert" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Flere valg
      </button>
      <div class="dropdown-menu" aria-labelledby="SkjemaAvansert">
	<a href="<?php echo site_url('aktivitet/slettaktivitet?aktivitetid='.$Aktivitet['AktivitetID']); ?>" class="dropdown-item">Slett aktivitet</a>
        <a href="<?php echo site_url('aktivitet/nyplukkliste?aktivitetid='.$Aktivitet['AktivitetID']); ?>" class="dropdown-item">Ny plukkliste</a>
      </div>
    </div>
<?php } ?>
  </div>
</div>
</form>
<br />

<?php if (isset($Aktivitet)) { ?>
<h5>Plukklister</h5>
<div class="table-responsive">
  <table class="table table-bordered table-sm table-striped table-hover">
    <thead>
      <tr>
        <th>#</th>
	<th>Registrert</th>
        <th>Beskrivelse</th>
        <th>Ansvarlig</th>
	<th>Materiell</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Plukklister)) {
    foreach ($Plukklister as $Plukkliste) {
?>
      <tr>
        <th><a href="<?php echo site_url('aktivitet/plukkliste/'.$Plukkliste['PlukklisteID']); ?>"><?php echo $Plukkliste['PlukklisteID']; ?></a></th>
        <td><?php if ($Plukkliste['DatoRegistrert'] != '') { echo date('d.m.Y',strtotime($Plukkliste['DatoRegistrert'])); } else { echo "&nbsp;"; } ?></td>
        <td><?php echo $Plukkliste['Navn']; ?></td>
	<td><?php if ($Plukkliste['AnsvarligBrukerID'] > 0) { echo $Plukkliste['AnsvarligBrukerNavn']; } else { echo "&nbsp;"; } ?></td>
	<td><?php if ($Plukkliste['MateriellAntall'] > 0) { echo $Plukkliste['MateriellAntall']." stk"; } else { echo "&nbsp;"; } ?></td>
        <td><?php echo $Plukkliste['Status']; ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
      <td colspan="6" class="text-center">Ingen plukklister er lagt til på denne aktiviteten enda. Trykk <a href="<?php echo site_url('aktivitet/nyplukkliste?aktivitetid='.$Aktivitet['AktivitetID']); ?>" target="_new">her</a> for å opprette ny.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
<?php } ?>
