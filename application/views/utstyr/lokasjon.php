<form method="POST" action="<?php echo site_url('komponenter/lokasjon/'.$Lokasjon['LokasjonID']); ?>">
<?php if (isset($Lokasjon)) { ?>
<input type="hidden" name="LokasjonID" value="<?php echo set_value('LokasjonID',$Lokasjon['LokasjonID']); ?>" />
<?php } ?>

<div class="card">
  <div class="card-header">Lokasjon +<?php echo $Lokasjon['LokasjonID']; ?></div>
  <div class="card-body">
    <div class="form-group">
      <label>ID:</label>
<?php if (isset($Lokasjon)) { ?>
      <input type="text" class="form-control" value="<?php echo '+'.$Lokasjon['LokasjonID']; ?>" readonly>
<?php } else { ?>
      <input type="text" class="form-control" id="NyLokasjonID" name="NyLokasjonID">
<?php } ?>
    </div>
    <div class="form-group">
      <label for="Navn">Navn:</label>
      <input type="text" class="form-control" id="Navn" name="Navn" value="<?php echo set_value('Navn',$Lokasjon['Navn']); ?>">
    </div>
    <div class="form-group">
      <label for="Notater">Notater:</label>
      <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Lokasjon['Notater']); ?></textarea>
    </div>
  </div>
  <div class="card-footer">
    <input type="submit" class="btn btn-primary" value="Lagre" name="LokasjonLagre" />
    <input type="submit" class="btn btn-secondary" value="Slett" name="LokasjonSlett" />
  </div>
</div>
<br />

</form>

<?php if (isset($Utstyrsliste)) { ?>
<div class="card">
  <div class="card-header">Utstyrsliste</div>
  <div class="table-responsive">
    <table class="table table-sm table-striped table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Produsent</th>
          <th>Beskrivelse</th>
          <th>Antall</th>
          <th>Plassering</th>
          <th>Endret</th>
          <th>Kontrollert</th>
        </tr>
      </thead>
      <tbody>
<?php foreach ($Utstyrsliste as $Utstyr) { ?>
        <tr>
          <th><a href="<?php echo site_url('utstyr/utstyr/'.$Utstyr['UtstyrID']); ?>"><?php echo "-".$Utstyr['UtstyrID']; ?></a></th>
          <td><?php echo $Utstyr['ProdusentNavn']; ?></td>
          <td><?php echo $Utstyr['Beskrivelse']; ?></td>
          <td><?php if (substr($Utstyr['UtstyrID'],-1,1) == 'T') { echo $Utstyr['Antall']." stk"; } else { echo "&nbsp;"; } ?></td>
          <td><?php if (strlen($Utstyr['LokasjonID']) > 0) { echo "+".$Utstyr['LokasjonID']; } else { echo "&nbsp;"; } ?><?php if (strlen($Utstyr['KasseID']) > 0) { echo "=".$Utstyr['KasseID']; } else { echo "&nbsp;"; } ?></td>
          <td><?php echo date("d.m.Y",strtotime($Utstyr['DatoEndret'])); ?></td>
          <td><?php if ($Utstyr['DatoKontrollert'] != '') { echo date("d.m.Y",strtotime($Utstyr['DatoKontrollert'])); } else { echo "&nbsp;"; } ?></td>
        </tr>
<?php } ?>
      </tbody>
    </table>
  </div>
</div>
<?php } ?>
