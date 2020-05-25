<?php include '../BeerProduction/views/partials/menu.php'; ?>

<div class="row">
  <div class="p-2 col-auto col-lg-3">
    <div class="card h-100">
      <div class="card-body">
        <form id="startProductionForm">
          <div class="form-group">
            <label for="batchProductType">Choose a beer:</label>
            <select id="batchProductType" name="batchProductType" onchange="setMaxSpeed(this.value)">
              <option value=0>Pilsner</option>
              <option value=1>Wheat</option>
              <option value=2>IPA</option>
              <option value=3>Stout</option>
              <option value=4>Ale</option>
              <option value=5>Alcohol Free</option>
            </select>
          </div>
          <div class="form-group">
            <label id="currentSpeedLabel" for="batchSpeed"><?= $viewbag['machineSpeed'] ?></label>
            <input id="batchSpeed" name="batchSpeed" type="range" min="1" max="<?= $viewbag['maxSpeed'] ?>" value="<?= $viewbag['machineSpeed'] ?>" onInput="getEstimatedError(batchProductType.value, this.value)">
            <!-- TODO oninput creates a massive amount of ajax calls which may lag due to the cisco vpn, if this happens change it to onchange -->
            <label id="maxSpeedLabel" for="batchSpeed"><?= $viewbag['maxSpeed'] ?></label>
            </br>
            <label>Estimated Error:&nbsp;</label><label id="errorEstimate"></label>
          </div>
          <div class="form-group">
            <label>BatchSize</label>
            <input type="number" id="batchSize" name="batchSize" min=1 max=65535 required><br>
          </div>
          <input type="submit" value="Produce" id="produce"></button>
          <button id="stop">Stop</button>
          <button id="abort">Abort</button>
        </form>
        Current State: <label id='CurrentState'></label>
      </div>
    </div>
  </div>

  <div class="p-2 col-lg-9">
    <div class="card h-100">
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-auto col-auto p-2 col-md-3">
            <img src="/pictures/Temperature.png">
            <label id='Temperature'></label>
          </div>
          <div class="col-auto col-auto p-2 col-md-3">
            <img src="/pictures/BatchID.png">
            <label id='BatchID'></label>
          </div>
          <div class="col-auto col-auto p-2 col-md-3">
            <img src="/pictures/AcceptableProducts.png">
            <label id='AcceptableProducts'></label>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-auto p-2 col-md-3">
            <img src="/pictures/Humidity.png">
            <label id='Humidity'></label>
          </div>
          <div class="col-auto p-2 col-md-3">
            <img src="/pictures/Produced.png">
            <label id='ProducedProducts'></label>
          </div>
          <div class="col-auto p-2 col-md-3">
            <img src="/pictures/DefectProducts.png">
            <label id='DefectProducts'></label>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-auto p-2 col-md-3">
            <img src="/pictures/Vibration.png">
            <label id='Vibration'></label>
          </div>
          <div class="col-auto p-2 col-md-3">
            <img src="/pictures/AmountToProduce.png">
            <label id='BatchSize'></label>
          </div>
          <div class="col-auto p-2 col-md-3">
            <img src="/pictures/ProductsPerMinute.png">
            <label id='ActualMachineSpeed'></label>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="p-2 col-md-10">
    <div class="card h-100">
      <div class="card-body">
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
        </div>
      </div>
    </div>
  </div>
  <div class="p-2 col-md-2">
    <div class="card h-100">
      <div class="card-body text-center">
        <label>Maintainence Meter</label><br>
        <div class="progress mx-auto position-relative" style="width:50%; height:80%; min-height:200px">
          <div id="MaintainenceMeter" class="progress-bar progress-bar-striped w-100 position-absolute" role="progressbar" aria-valuemin="0" aria-valuemax="30000" style="bottom:0%"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="p-2 col-md-12">
    <div class="card h-100">
      <div class="card-body">
        <label>Overall Equipment Effectiveness</label><br>
        <div class="row">
          <div class="p-2 col-md-2 border">
            <label>Pilsner</label>
          </div>
          <div class="p-2 col-md-2 border">
            <label>Wheat</label>
          </div>
          <div class="p-2 col-md-2 border">
            <label>IPA</label>
          </div>
          <div class="p-2 col-md-2 border">
            <label>Stout</label>
          </div>
          <div class="p-2 col-md-2 border">
            <label>Ale</label>
          </div>
          <div class="p-2 col-md-2 border">
            <label>Alcohol Free</label>
          </div>
        </div>
        <div class="row">
          <div class="p-2 col-md-2 border">
            <label id="pilsnerOEE"></label>
          </div>
          <div class="p-2 col-md-2 border">
            <label id="wheatOEE"></label>
          </div>
          <div class="p-2 col-md-2 border">
            <label id="IPAOEE"></label>
          </div>
          <div class="p-2 col-md-2 border">
            <label id="stoutOEE"></label>
          </div>
          <div class="p-2 col-md-2 border">
            <label id="aleOEE"></label>
          </div>
          <div class="p-2 col-md-2 border">
            <label id="alcoholFreeOEE"></label>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<?php include '../BeerProduction/views/partials/footer.php'; ?>