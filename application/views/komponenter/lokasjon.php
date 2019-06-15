<form method="POST" action="<?php echo site_url('komponenter/lokasjon/'.$Lokasjon['LokasjonID']); ?>">
<?php if (isset($Lokasjon)) { ?>
<input type="hidden" name="LokasjonID" value="<?php echo set_value('LokasjonID',$Lokasjon['LokasjonID']); ?>" />
<?php } ?>

<div class="card">
  <div class="card-header">Lokasjon <?php echo $Lokasjon['LokasjonID']; ?></div>
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

