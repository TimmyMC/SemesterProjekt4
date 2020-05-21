<?php include '../BeerProduction/views/partials/menu.php'; ?>

<form id="startProductionForm">
  <label for="batchProductType">Choose a beer:</label>
  <select id="batchProductType" name="batchProductType" onchange="setMaxSpeed(this.value)">
    <option value=0>Pilsner</option>
    <option value=1>Wheat</option>
    <option value=2>IPA</option>
    <option value=3>Stout</option>
    <option value=4>Ale</option>
    <option value=5>Alcohol Free</option>
  </select>
  </br>

  <label for="batchSpeed">0</label>
  <input id="batchSpeed" name="batchSpeed" type="range" min="1" max="<?= $viewbag['maxSpeed'] ?>" value="<?= $viewbag['machineSpeed'] ?>" onChange="getEstimatedError(batchProductType.value, this.value)">
  <!-- TODO oninput creates a massive amount of ajax calls which may lag due to the cisco vpn, if this happens change it to onchange -->
  <label id="maxSpeedLabel" for="batchSpeed"><?= $viewbag['maxSpeed'] ?></label>
  </br>
  <label>Estimated Error:&nbsp;</label><label id="errorEstimate"></label>
  </br>
  <label>BatchSize</label>
  <input type="number" id="batchSize" name="batchSize" min=1 max=65535 required><br>

  <input type="submit" value="Produce"></button>
</form>


Current State <label id='CurrentState'></label>


<div class="row">
  <div class="col-3">
    <img src="/pictures/Temperature.jpg">
    <label id='Temperature'></label>
  </div>
  <div class="col-3">
    <img src="/pictures/BatchID.jpg">
    <label id='BatchID'></label>
  </div>
  <div class="col-3">
    <img src="/pictures/AcceptableProducts.jpg">
    <label id='AcceptableProducts'></label>
  </div>

  <div class="w-100"></div>

  <div class="col-3">
    <img src="/pictures/Humidity.jpg">
    <label id='Humidity'></label>
  </div>
  <div class="col-3">
    <img src="/pictures/Produced.jpg">
    <label id='ProducedProducts'></label>
  </div>
  <div class="col-3">
    <img src="/pictures/DefectProducts.jpg">
    <label id='DefectProducts'></label>
  </div>

  <div class="w-100"></div>

  <div class="col-3">
    <img src="/pictures/Vibration.jpg">
    <label id='Vibration'></label>
  </div>
  <div class="col-3">
    <img src="/pictures/AmountToProduce.jpg">
    <label id='BatchSize'></label>
  </div>
  <div class="col-3">
    <img src="/pictures/ProductsPerMinute.jpg">
    <label id='ActualMachineSpeed'></label>
  </div>
</div>

<label>Barley</label><br>
<div class="progress">
  <div id="Barley" class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuemin="0" aria-valuemax="35000"></div>
</div>
<br>

<label>Hops</label><br>
<div class="progress">
  <div id="Hops" class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuemin="0" aria-valuemax="35000"></div>
</div>
<br>

<label>Malt</label><br>
<div class="progress">
  <div id="Malt" class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuemin="0" aria-valuemax="35000"></div>
</div>
<br>

<label>Wheat</label><br>
<div class="progress">
  <div id="Wheat" class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuemin="0" aria-valuemax="35000"></div>
</div>
<br>

<label>Yeast</label><br>
<div class="progress">
  <div id="Yeast" class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuemin="0" aria-valuemax="35000"></div>
</div><br>

<label>MaintainenceMeter</label><br>
<div class="progress">
  <div id="MaintainenceMeter" class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuemin="0" aria-valuemax="30000"></div>
</div><br>



<?php include '../BeerProduction/views/partials/footer.php'; ?>