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

</form>

<?php if (isset($Komponenter)) { ?>
<div class="card">
  <div class="card-header">Komponenter</div>
  <div class="table-responsive">
    <table class="table table-sm table-striped table-hover">
      <tbody>
<?php foreach ($Komponenter as $Komponent) { ?>
        <tr>
	  <th><a href="<?php echo site_url('komponenter/komponent/'.$Komponent['KomponentID']); ?>"><?php echo $Komponent['KomponentID']; ?></a></th>
        </tr>
<?php } ?>
      </tbody>
    </table>
  </div>
</div>
<?php } ?>