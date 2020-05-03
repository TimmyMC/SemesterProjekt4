<?php include '../BeerProduction/views/partials/menu.php'; ?>

<h2>Estimate Error Function</h2>
<p>Production Speed:</p>
<form>
    <label for="beerType">Choose a beer:</label>
    <select id="beerType" name="beerType" onChange="setMaxSpeed(this.value)">
        <option value=0>Pilsner</option>
        <option value=1>Wheat</option>
        <option value=2>IPA</option>
        <option value=3>Stout</option>
        <option value=4>Ale</option>
        <option value=5>Alcohol Free</option>
    </select>
    </br>
    <label for="productionSpeedSlider">0</label>
    <input id="productionSpeedSlider" type="range" min="1" max="<?= $viewbag['maxSpeed'] ?>" oninput="getEstimatedError(beerType.value, this.value)">
    <label id="maxSpeedLabel" for="productionSpeedSlider"><?= $viewbag['maxSpeed'] ?></label>
</form>

The estimated error is: <p id="errorEstimate"><?= $viewbag['pilsner'] ?? "" ?></p></br>

<script src="/js/estimateErrorAjax.js"></script>
<?php include '../BeerProduction/views/partials/footer.php'; ?>