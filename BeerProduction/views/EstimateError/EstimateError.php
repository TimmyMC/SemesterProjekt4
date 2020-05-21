
<h2>Estimate Error Function</h2>
<p>Production Speed:</p>
<form>
    <label for="beerType">Choose a beer:</label>
    <select id="beerType" name="beerType" onchange="setMaxSpeed(this.value)">
        <option value=0>Pilsner</option>
        <option value=1>Wheat</option>
        <option value=2>IPA</option>
        <option value=3>Stout</option>
        <option value=4>Ale</option>
        <option value=5>Alcohol Free</option>
    </select>
    </br>
    <label for="productionSpeedSlider">0</label>
    <input id="productionSpeedSlider" type="range" min="1" max="<?= $viewbag['maxSpeed'] ?>" value="<?= $viewbag['machineSpeed'] ?>" oninput="getEstimatedError(beerType.value, this.value)">
    <!-- TODO oninput creates a massive amount of ajax calls which may lag due to the cisco vpn, if this happens change it to onchange -->
    <label id="maxSpeedLabel" for="productionSpeedSlider"><?= $viewbag['maxSpeed'] ?></label>
</form>

The estimated error is: <p id="errorEstimate"><?= $viewbag['estimatedError'] ?></p></br>
