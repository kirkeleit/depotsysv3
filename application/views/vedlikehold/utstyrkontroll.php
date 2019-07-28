<?php if (substr($Utstyr['UtstyrID'],-1,1) == 'T') { ?>
<div class="card card-body bg-warning">
Utstyr '-<?php echo $Utstyr['UtstyrID']; ?>' er registrert som forbruksmateriell, og kan derfor ikke kontrolleres.
</div>
<?php } else { ?>
<form method="POST" action="<?php echo site_url('utstyr/utstyrkontroll?utstyrid='.$Utstyr['UtstyrID']); ?>">
<input type="hidden" name="UtstyrID" value="<?php echo set_value('UtstyrID',$Utstyr['UtstyrID']); ?>" />

<div class="card">
  <h5 class="card-header">Utstyrskontroll</h5>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="UtstyrID"><b>Utstyr ID:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="UtstyrID" value="-<?php echo $Utstyr['UtstyrID']; ?>" readonly>
      </div>
    </div>
<?php if ($Utstyr['LokasjonID'] > 0) { ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Lokasjon"><b>Lokasjon:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="Lokasjon" value="<?php echo $Utstyr['Lokasjon']; ?>" readonly>
      </div>
    </div>
<?php } ?>
<?php if ($Utstyr['KasseID'] > 0) { ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Kasse"><b>Kasse:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="Kasse" value="<?php echo $Utstyr['Kasse']; ?>" readonly>
      </div>
    </div>
<?php } ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label"><b>Beskrivelse:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="Beskrivelse" value="<?php echo $Utstyr['Beskrivelse']; ?>" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="ProdusentID"><b>Produsent:</b></label>
      <div class="col-sm-10">
	<input type="text" class="form-control-plaintext" id="ProdusentID" value="<?php echo $Utstyr['ProdusentNavn']; ?>" readonly>
      </div>
    </div>
<?php if ($Utstyrstype['KontrollPunkter'] != '') { ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="KontrollPunkter"><b>Kontrollpunkter:</b></label>
      <div class="col-sm-10">
        <ul class="list-group">
<?php
  $Utstyrstype['KontrollPunkter'] = nl2br($Utstyrstype['KontrollPunkter']);
  $Punkter = explode('<br />',$Utstyrstype['KontrollPunkter']);
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
