<form method="POST" action="<?php echo site_url('utstyr/aktivitet/'.$Aktivitet['AktivitetID']); ?>">
<input type="hidden" name="AktivitetID" value="<?php echo set_value('AktivitetID',$Aktivitet['AktivitetID']); ?>" />

<div class="card">
  <h5 class="card-header bg-info text-white">Aktivitet</h5>
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
      <input type="submit" class="btn btn-primary" value="Lagre" name="SkjemaLagre" />
      <input type="submit" class="btn btn-primary" value=">>" name="SkjemaLagreLukk" />
    </div>
    <div class="btn-group" role="group">
      <button id="SkjemaAvansert" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Flere valg
      </button>
      <div class="dropdown-menu" aria-labelledby="SkjemaAvansert">
	<a href="<?php echo site_url('utstyr/slettaktivitet?aktivitetid='.$Aktivitet['AktivitetID']); ?>" class="dropdown-item">Slett aktivitet</a>
        <a href="<?php echo site_url('utstyr/nyplukkliste?aktivitetid='.$Aktivitet['AktivitetID']); ?>" class="dropdown-item">Ny plukkliste</a>
      </div>
    </div>
  </div>
</div>
</form>
<br />

<h5>Plukklister</h5>
<div class="table-responsive">
  <table class="table table-bordered table-sm table-striped table-hover">
    <thead>
      <tr>
        <th>#</th>
	<th>Registrert</th>
        <th>Beskrivelse</th>
        <th>Ansvarlig</th>
	<th>Utstyr</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Plukklister)) {
    foreach ($Plukklister as $Plukkliste) {
?>
      <tr>
        <th><a href="<?php echo site_url('utstyr/plukkliste/'.$Plukkliste['PlukklisteID']); ?>"><?php echo $Plukkliste['PlukklisteID']; ?></a></th>
        <td><?php if ($Plukkliste['DatoRegistrert'] != '') { echo date('d.m.Y',strtotime($Plukkliste['DatoRegistrert'])); } else { echo "&nbsp;"; } ?></td>
        <td><?php echo $Plukkliste['Beskrivelse']; ?></td>
	<td><?php if ($Plukkliste['AnsvarligBrukerID'] > 0) { echo $Plukkliste['AnsvarligBrukerNavn']; } else { echo "&nbsp;"; } ?></td>
	<td><?php if ($Plukkliste['UtstyrAntall'] > 0) { echo $Plukkliste['UtstyrAntall']." stk"; } else { echo "&nbsp;"; } ?></td>
        <td><?php echo $Plukkliste['Status']; ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
      <td colspan="5" class="text-center">Ingen plukklister er lagt til på denne aktiviteten enda. Trykk <a href="<?php echo site_url('utstyr/nyplukkliste?aktivitetid='.$Aktivitet['AktivitetID']); ?>" target="_new">her</a> for å opprette ny.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
