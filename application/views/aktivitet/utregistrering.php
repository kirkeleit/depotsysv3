<form method="POST" action="<?php echo site_url('utstyr/utregistrering/'.$Plukkliste['PlukklisteID']); ?>">
<input type="hidden" name="PlukklisteID" value="<?php echo set_value('PlukklisteID',$Plukkliste['PlukklisteID']); ?>" />

<div class="card">
  <div class="card-body">
    <div class="form-group row">
      <a class="btn btn-sm btn-primary" href="<?php echo site_url('utstyr/plukkliste/'.$Plukkliste['PlukklisteID']); ?>" role="button">Tilbake</a>
      <input type="text" name="UtstyrID" id="UtstyrID" class="form-control" placeholder="Skriv inn utstyrs ID og trykk enter" autofocus>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered table-sm table-striped table-hover">
      <thead>
        <tr>
          <th>Utstyr ID</th>
          <th>Produsent</th>
	  <th>Beskrivelse</th>
          <th>Avvik</th>
	  <th>Antall ut</th>
          <th>Antall inn</th>
	  <th>Status</th>
          <th>&nbsp;</th>
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
          <td<?php if ($Utstyr['AntallAvvik'] > 0) { echo ' class="bg-danger text-white"'; } ?>><?php if ($Utstyr['AntallAvvik'] > 0) { echo $Utstyr['AntallAvvik'].' stk'; } else { echo '&nbsp;'; } ?></td>
	  <td><?php echo $Utstyr['UtAntall']." stk"; ?></td>
	  <td><?php echo $Utstyr['InnAntall']." stk"; ?></td>
	  <td><?php if ($Utstyr['UtAntall'] == $Utstyr['InnAntall']) { echo "OK"; } else { echo "Utlevert"; } ?></td>
	  <td><a class="btn btn-sm btn-primary" href="<?php echo site_url('utstyr/plukklistefjernutstyr?utstyrid='.$Utstyr['UtstyrID'].'&plukklisteid='.$Plukkliste['PlukklisteID']); ?>" role="button">Fjern</a></td>
        </tr>
<?php
    }
  } else {
?>
        <tr>
          <td colspan="8" class="text-center">Ingen utstyr er lagt til på denne plukklisten enda.</td>
        </tr>
<?php
  }
?>
      </tbody>
    </table>
  </div>
</div>
</form>
