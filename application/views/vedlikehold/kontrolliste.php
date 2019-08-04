<div class="card card-body">
<a data-toggle="collapse" href="#ListeFilter" role="button" aria-expanded="false" aria-controls="ListeFilter">Trykk her for å vise filter for listene.</a></div>
</div>
<br />

<form method="POST" action="<?php echo site_url('vedlikehold/kontrolliste'); ?>">
<div class="card card-body collapse" id="ListeFilter">
  <div class="form-group row">
    <label class="col-sm-2 col-form-label" for="LokasjonID"><b>Lokasjon:</b></label>
    <div class="col-sm-10">
      <select class="form-control" id="FilterLokasjonID" name="FilterLokasjonID">
        <option value="">[ingen filter]</option>
<?php
  foreach ($Lokasjoner as $Lokasjon) {
?>
        <option value="<?php echo $Lokasjon['LokasjonID']; ?>"<?php if ($Lokasjon['LokasjonID'] == substr($this->input->get('filterplassering'),1)) { echo " selected"; } ?>><?php echo "+".$Lokasjon['Kode']." ".$Lokasjon['Navn']; ?></option>

<?php
  }
?>
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label" for="KasseID"><b>Kasse:</b></label>
    <div class="col-sm-10">
      <select class="form-control" id="FilterKasseID" name="FilterKasseID">
        <option value="">[ingen filter]</option>
<?php
  foreach ($Kasser as $Kasse) {
?>
        <option value="<?php echo $Kasse['KasseID']; ?>"<?php if ($Kasse['KasseID'] == substr($this->input->get('filterplassering'),1)) { echo " selected"; } ?>><?php echo "=".$Kasse['Kode']." ".$Kasse['Navn']; ?></option>
<?php
  }
?>
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">&nbsp;</label>
    <div class="col-sm-10">
      <input type="submit" class="btn btn-primary" name="FiltrerListe" value="Filtrer" />
    </div>
  </div>
</div>
</form>
<br />

<h2>Materielliste</h2>
<br />
<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead class="thead-dark">
      <tr>
        <th>Materiell ID</th>
        <th>Produsent</th>
	<th>Beskrivelse</th>
        <th>Plassering</th>
	<th>Sist kontrollert</th>
        <th>Kontrollintervall</th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Materielliste)) {
    foreach ($Materielliste as $Materiell) {
      if (($Materiell['KontrollDager'] > 0) and (((((time()-strtotime($Materiell['DatoKontrollert'])) / 60) / 60) / 24) >= $Materiell['KontrollDager'])) {
?>
        <tr>
	  <th><a href="<?php echo site_url('materiell/materiell/'.$Materiell['MateriellID']); ?>" target="_new"><?php echo "-".$Materiell['MateriellID']; ?></a></th>
          <td><?php echo $Materiell['ProdusentNavn']; ?></td>
	  <td><?php echo $Materiell['Beskrivelse']; ?></td>
          <td><?php if (strlen($Materiell['LokasjonID']) > 0) { echo $Materiell['Lokasjon']; } else { echo "&nbsp;"; } ?><?php if (strlen($Materiell['KasseID']) > 0) { echo $Materiell['Kasse']; } else { echo "&nbsp;"; } ?></td>
	  <td<?php if ($Materiell['DatoKontrollert'] == '') { echo ' class="bg-danger text-white"'; } ?>><?php if ($Materiell['DatoKontrollert'] == '') { echo "Aldri kontrollert"; } else { echo date('d.m.Y',strtotime($Materiell['DatoKontrollert'])).' ('.floor((((time()-strtotime($Materiell['DatoKontrollert'])) / 60) / 60) / 24).')'; } ?></td>
          <td><?php echo $Materiell['KontrollDager'].' dager'; ?></td>
          <td><a href="<?php echo site_url('vedlikehold/materiellkontroll?materiellid='.$Materiell['MateriellID']); ?>" target="_new">Kontroller</a></td>
        </tr>
<?php
      }
    }
  } else {
?>
      <tr>
        <td colspan="6" class="text-center">Ingen materiell er tilgjengelig for kontroll.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
<br />
