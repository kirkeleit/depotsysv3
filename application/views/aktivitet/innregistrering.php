<form method="POST" action="<?php echo site_url('utstyr/innregistrering/'); ?>">

<div class="card">
  <div class="card-header">
    <div class="form-group row">
      <input type="text" name="UtstyrID" id="UtstyrID" class="form-control" placeholder="Skriv inn utstyrs ID og trykk enter" autofocus>
    </div>
  </div>
<?php if (isset($Utstyr)) { ?>
  <div class="card-header text-center bg-success text-white">
    <h5>Utstyr registrert inn</h5>
  </div>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="UtstyrID"><b>Utstyr ID:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="UtstyrID" value="-<?php echo $Utstyr['UtstyrID']; ?>" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="Beskrivelse"><b>Beskrivelse:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="Beskrivelse" value="<?php echo $Utstyr['Beskrivelse']; ?>" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="ProdusentNavn"><b>ProdusentNavn:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="ProdusentNavn" value="<?php echo $Utstyr['ProdusentNavn']; ?>" readonly>
      </div>
    </div>
<?php
  if (isset($Plukkliste)) {
?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="AnsvarligBrukerNavn"><b>Ansvarlig:</b></label>
      <div class="col-sm-10">
        <input type="text" class="form-control-plaintext" id="AnsvarligBrukerNavn" value="<?php echo $Plukkliste['AnsvarligBrukerNavn']; ?>" readonly>
      </div>
    </div>
<?php
  }
?>
  </div>
  <div class="card-footer">
<a href="<?php echo site_url('utstyr/nyttavvik?utstyrid='.$Utstyr['UtstyrID']); ?>" class="dropdown-item">Nytt avvik</a>
  </div>
<?php } ?>
</div>
</form>
