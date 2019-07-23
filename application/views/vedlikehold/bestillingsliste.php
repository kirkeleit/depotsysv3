<div class="card">
  <div class="card-header">Bestillingsliste</div>
  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
	  <th>Utstyr ID</th>
          <th>Kontrollert dato</th>
	  <th>Minimum</th>
	  <th>Antall</th>
	  <th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
<?php
  if (isset($Utstyrsliste)) {
    foreach ($Utstyrsliste as $Utstyr) {
      if ($Utstyr['Antall'] < $Utstyr['AntallMin']) {
?>
        <tr>
	  <th><a href="<?php echo site_url('utstyr/utstyr/'.$Utstyr['UtstyrID']); ?>"><?php echo '-'.$Utstyr['UtstyrID']; ?></a><input type="hidden" name="UtstyrID[]" value="<?php echo $Utstyr['UtstyrID']; ?>"></th>
          <td><?php if ($Utstyr['DatoKontrollert'] != '') { echo date("d.m.Y",strtotime($Utstyr['DatoKontrollert'])); } else { echo "&nbsp;"; } ?></td>
	  <td><?php echo $Utstyr['AntallMin']; ?></td>
	  <td><?php echo $Utstyr['Antall']; ?></td>
	  <td><input type="number" class="form-control" name="NyttAntall[]" size="6"><input type="hidden" name="Antall[]" value="<?php echo $Utstyr['Antall']; ?>"></td>
        </tr>
<?php
      }
    }
  }
?>
      </tbody>
    </table>
  </div>
  <div class="card-footer text-muted"><?php echo sizeof($Utstyrsliste); ?> stk forbruksmateriell</div>
</div>
