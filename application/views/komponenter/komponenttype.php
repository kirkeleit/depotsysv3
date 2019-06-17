<form method="POST" action="<?php echo site_url('komponenter/komponenttype/'.$Komponenttype['KomponenttypeID']); ?>">
<input type="hidden" name="KomponenttypeID" value="<?php echo set_value('KomponenttypeID',$Komponenttype['KomponenttypeID']); ?>" />

<div class="card">
  <div class="card-header">Komponenttype <?php echo $Komponenttype['KomponenttypeID']; ?></div>
  <div class="card-body">
    <div class="form-group">
      <label>ID:</label>
      <input type="text" class="form-control" value="<?php echo $Komponenttype['KomponenttypeID']; ?>" readonly>
    </div>
    <div class="form-group">
      <label for="Beskrivelse">Beskrivelse:</label>
      <input type="text" class="form-control" id="Beskrivelse" name="Beskrivelse" value="<?php echo set_value('Beskrivelse',$Komponenttype['Beskrivelse']); ?>">
    </div>
    <div class="form-group">
      <label for="Notater">Notater:</label>
      <textarea class="form-control" id="Notater" name="Notater" rows="3"><?php echo set_value('Notater',$Komponenttype['Notater']); ?></textarea>
    </div>
  </div>
  <div class="card-footer">
    <input type="submit" class="btn btn-primary" value="Lagre" name="KomponenttypeLagre" />
    <input type="submit" class="btn btn-secondary" value="Slett" name="KomponenttypeSlett" />
    <a href="<?php echo site_url('komponenter/nykomponent/'.$Komponenttype['KomponenttypeID']); ?>" class="btn btn-success" tabindex="-1" role="button">Ny komponent</a>
  </div>
</div>
<br />

</form>

<?php if (isset($Komponenter)) { ?>
<div class="card">
  <div class="card-header">Komponenter</div>
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
<?php foreach ($Komponenter as $Komponent) { ?>
        <tr>
          <th><a href="<?php echo site_url('komponenter/komponent/'.$Komponent['KomponentID']); ?>"><?php echo "-".$Komponent['KomponentID']; ?></a></th>
          <td><?php echo $Komponent['ProdusentNavn']; ?></td>
          <td><?php echo $Komponent['Beskrivelse']; ?></td>
          <td><?php if (substr($Komponent['KomponentID'],-1,1) == 'T') { echo $Komponent['Antall']." stk"; } else { echo "&nbsp;"; } ?></td>
          <td><?php if (strlen($Komponent['LokasjonID']) > 0) { echo "+".$Komponent['LokasjonID']; } else { echo "&nbsp;"; } ?><?php if (strlen($Komponent['KasseID']) > 0) { echo "=".$Komponent['KasseID']; } else { echo "&nbsp;"; } ?></td>
          <td><?php echo date("d.m.Y",strtotime($Komponent['DatoEndret'])); ?></td>
          <td><?php if ($Komponent['DatoKontrollert'] != '') { echo date("d.m.Y",strtotime($Komponent['DatoKontrollert'])); } else { echo "&nbsp;"; } ?></td>
        </tr>
<?php } ?>
      </tbody>
    </table>
  </div>
</div>
<?php } ?>
