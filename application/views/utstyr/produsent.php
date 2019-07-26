<form method="POST" action="<?php echo site_url('utstyr/produsent/'.$Produsent['ProdusentID']); ?>">
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
	<a href="<?php echo site_url('utstyr/slettprodusent?produsentid='.$Produsent['ProdusentID']); ?>" class="dropdown-item">Slett produsent</a>
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
        <th>Plassering</th>
        <th>Endret</th>
        <th>Kontrollert</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
?>
      <tr>
        <th><a href="<?php echo site_url('utstyr/utstyr/'.$Utstyr['UtstyrID']); ?>"><?php echo "-".$Utstyr['UtstyrID']; ?></a></th>
        <td><?php echo $Utstyr['ProdusentNavn']; ?></td>
        <td><?php echo $Utstyr['Beskrivelse']; ?></td>
        <td><?php if (substr($Utstyr['UtstyrID'],-1,1) == 'T') { echo $Utstyr['Antall']." stk"; } else { echo "&nbsp;"; } ?></td>
        <td><?php if (strlen($Utstyr['LokasjonID']) > 0) { echo $Utstyr['Lokasjon']; } else { echo "&nbsp;"; } ?><?php if (strlen($Utstyr['KasseID']) > 0) { echo $Utstyr['Kasse']; } else { echo "&nbsp;"; } ?></td>
        <td><?php echo date("d.m.Y",strtotime($Utstyr['DatoEndret'])); ?></td>
        <td><?php if ($Utstyr['DatoKontrollert'] != '') { echo date("d.m.Y",strtotime($Utstyr['DatoKontrollert'])); } else { echo "&nbsp;"; } ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="7" class="text-center">Ingen utstyr registrert med denne produsenten.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
