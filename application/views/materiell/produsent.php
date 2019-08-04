<form method="POST" action="<?php echo site_url('materiell/produsent/'.$Produsent['ProdusentID']); ?>">
<input type="hidden" name="ProdusentID" value="<?php echo set_value('ProdusentID',$Produsent['ProdusentID']); ?>" />

<div class="card">
  <h5 class="card-header">Produsent</h5>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Navn"><b>Navn:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Navn" name="Navn" value="<?php echo set_value('Navn',$Produsent['Navn']); ?>" required>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Nettsted"><b>Nettsted:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Nettsted" name="Nettsted" value="<?php echo set_value('Nettsted',$Produsent['Nettsted']); ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Notater"><b>Notater:</b></label>
      <div class="col-sm-10">
        <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Produsent['Notater']); ?></textarea>
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
	<a href="<?php echo site_url('materiell/slettprodusent?produsentid='.$Produsent['ProdusentID']); ?>" class="dropdown-item">Slett produsent</a>
      </div>
    </div>
  </div>
</div>
</form>
<br />

<h5>Materielliste</h5>
<div class="table-responsive">
  <table class="table table-bordered table-sm table-striped table-hover">
    <thead>
      <tr>
        <th>Materiell ID</th>
        <th>Produsent</th>
        <th>Beskrivelse</th>
        <th>Antall</th>
        <th>Minimum antall</th>
        <th>Plassering</th>
        <th>Kontrollert</th>
        <th>Avvik</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Materielliste)) {
    foreach ($Materielliste as $Materiell) {
?>
      <tr<?php if ($Materiell['StatusID'] == 0) { echo ' class="bg-danger text-white"'; } ?>>
        <th><a href="<?php echo site_url('materiell/materiell/'.$Materiell['MateriellID']); ?>"<?php if ($Materiell['StatusID'] == 0) { echo ' class="text-white"'; } ?>><?php echo "-".$Materiell['MateriellID']; ?></a></th>
        <td><?php if ($Materiell['ProdusentID'] > 0) { echo $Materiell['ProdusentNavn']; ?>&nbsp;<a href="<?php echo site_url('materiell/produsent/'.$Materiell['ProdusentID']); ?>" target="_new"><img src="/res/open_in_new_window.png" height="16" width="16"></a><?php } else { echo "&nbsp;"; } ?></td>
        <td><?php echo $Materiell['Beskrivelse']; ?></td>
        <td><?php if (substr($Materiell['MateriellID'],-1,1) == 'T') { echo $Materiell['Antall']." stk"; } else { echo "&nbsp;"; } ?></td>
        <td><?php echo $Materiell['AntallMin']; ?></td>
        <td><?php if ($Materiell['LokasjonID'] > 0) { echo $Materiell['Lokasjon'].' <a href="'.site_url('materiell/lokasjon/'.$Materiell['LokasjonID']).'" target="_new"><img src="/res/open_in_new_window.png" height="16" width="16"></a>'; } else { echo "&nbsp;"; } ?><?php if ($Materiell['KasseID'] > 0) { echo $Materiell['Kasse'].' <a href="'.site_url('materiell/kasse/'.$Materiell['KasseID']).'" target="_new"><img src="/res/open_in_new_window.png" height="16" width="16"></a>'; } else { echo "&nbsp;"; } ?></td>
        <td><?php if (substr($Materiell['MateriellID'],-1,1) == 'T') { if ($Materiell['DatoTelling'] != '') { echo date('d.m.Y',strtotime($Materiell['DatoTelling'])); } else { echo "&nbsp;"; } } else { if ($Materiell['DatoKontrollert'] != '') { echo date("d.m.Y",strtotime($Materiell['DatoKontrollert'])); } else { echo "&nbsp;"; } } ?></td>
        <td<?php if ($Materiell['AntallAvvik'] > 0) { echo ' class="bg-danger text-white"'; } ?>><?php if ($Materiell['AntallAvvik'] > 0) { echo $Materiell['AntallAvvik'].' stk'; } else { echo '&nbsp;'; } ?></td>
        <td class="text-center<?php if ($Materiell['StatusID'] == 1) { echo ' bg-success text-white'; } elseif ($Materiell['StatusID'] == 2) { echo ' bg-warning'; } ?>"><?php if ($Materiell['StatusID'] == 0) { echo "IKKE OPERATIVT"; } elseif ($Materiell['StatusID'] == 2) { echo "UTREGISTRERT"; } else { echo "OPERATIVT"; } ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="9" class="text-center">Ingen materiell registrert med denne produsenten enda.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
