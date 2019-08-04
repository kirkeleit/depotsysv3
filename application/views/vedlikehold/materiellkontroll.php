<?php if (substr($Materiell['MateriellID'],-1,1) == 'T') { ?>
<div class="card card-body bg-warning">
Materiell '-<?php echo $Materiell['MateriellID']; ?>' er registrert som forbruksmateriell, og kan derfor ikke kontrolleres.
</div>
<?php } else { ?>
<form method="POST" action="<?php echo site_url('vedlikehold/materiellkontroll?materiellid='.$Materiell['MateriellID']); ?>">
<input type="hidden" name="MateriellID" value="<?php echo set_value('MateriellID',$Materiell['MateriellID']); ?>" />

<div class="card">
  <h5 class="card-header">Materiellkontroll</h5>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="MateriellID"><b>Materiell ID:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="MateriellID" value="-<?php echo $Materiell['MateriellID']; ?>" readonly>
      </div>
    </div>
<?php if ($Materiell['LokasjonID'] > 0) { ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Lokasjon"><b>Lokasjon:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="Lokasjon" value="<?php echo $Materiell['Lokasjon']; ?>" readonly>
      </div>
    </div>
<?php } ?>
<?php if ($Materiell['KasseID'] > 0) { ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Kasse"><b>Kasse:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="Kasse" value="<?php echo $Materiell['Kasse']; ?>" readonly>
      </div>
    </div>
<?php } ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label"><b>Beskrivelse:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="Beskrivelse" value="<?php echo $Materiell['Beskrivelse']; ?>" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="ProdusentID"><b>Produsent:</b></label>
      <div class="col-sm-10">
	<input type="text" class="form-control-plaintext" id="ProdusentID" value="<?php echo $Materiell['ProdusentNavn']; ?>" readonly>
      </div>
    </div>
<?php if ($Materielltype['KontrollPunkter'] != '') { ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="KontrollPunkter"><b>Kontrollpunkter:</b></label>
      <div class="col-sm-10">
        <ul class="list-group">
<?php
  $Materielltype['KontrollPunkter'] = nl2br($Materielltype['KontrollPunkter']);
  $Punkter = explode('<br />',$Materielltype['KontrollPunkter']);
  for ($x=0; $x<sizeof($Punkter); $x++) {
?>
	  <li class="list-group-item"><?php echo $Punkter[$x]; ?></li>
<?php
  }
?>
        </ul>
      </div>
    </div>
<?php } ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="TilstandID"><b>Tilstand:</b></label>
      <div class="col-sm-10">
	<select class="custom-select" id="TilstandID" name="TilstandID">
<?php for ($x=0; $x<sizeof($Tilstander); $x++) { ?>
          <option value="<?php echo $x; ?>"><?php echo $Tilstander[$x]; ?></option>
<?php } ?>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Kommentar"><b>Kommentar:</b></label>
      <div class="col-sm-10">
        <textarea class="form-control" id="Kommentar" name="Kommentar" rows="3"></textarea>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <div class="btn-group" role="group" aria-label="Skjema lagre">
      <input type="submit" class="btn btn-primary" value="Lagre" name="SkjemaLagre" />
    </div>
  </div>
</div>
</form>
<br />

<h5>Kontroller</h5>
<div class="table-responsive">
  <table class="table table-bordered table-sm table-striped table-hover">
    <thead>
      <tr>
        <th>Dato</th>
	<th>Bruker</th>
        <th>Tilstand</th>
        <th>Kommentar</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Kontroller)) {
    foreach ($Kontroller as $Kontroll) {
?>
      <tr>
        <td><?php echo date('d.m.Y',strtotime($Kontroll['DatoRegistrert'])); ?></td>
	<td><?php echo $Kontroll['BrukerNavn']; ?></td>
        <td><?php echo $Kontroll['Tilstand']; ?></td>
        <td><?php echo $Kontroll['Kommentar']; ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="4" class="text-center">Ingen kontroller er gjort på utstyret.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
<?php } ?>
