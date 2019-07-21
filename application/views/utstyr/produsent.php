<form method="POST" action="<?php echo site_url('utstyr/produsent/'.$Produsent['ProdusentID']); ?>">
<input type="hidden" name="ProdusentID" value="<?php echo set_value('ProdusentID',$Produsent['ProdusentID']); ?>" />

<div class="card">
  <div class="card-header">Produsent <?php echo $Produsent['Navn']; ?></div>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="ProdusentID">Produsent ID:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="ProdusentID" value="<?php echo $Produsent['ProdusentID']; ?>" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Navn">Navn:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Navn" name="Navn" value="<?php echo set_value('Navn',$Produsent['Navn']); ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Nettsted">Nettsted:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Nettsted" name="Nettsted" value="<?php echo set_value('Nettsted',$Produsent['Nettsted']); ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Notater">Notater:</label>
      <div class="col-sm-10">
        <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Produsent['Notater']); ?></textarea>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <input type="submit" class="btn btn-primary" value="Lagre" name="ProdusentLagre" />
    <input type="submit" class="btn btn-secondary" value="Slett" name="ProdusentSlett" />
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

