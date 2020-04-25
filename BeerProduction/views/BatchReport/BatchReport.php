<?php include '../BeerProduction/views/partials/menu.php'; ?>

BatchID, <?= $viewbag['BatchID'] ?></br>
BatchSize, <?= $viewbag['BatchSize'] ?></br>
ProductType, <?= $viewbag['ProductType'] ?></br>
Actual MachineSpeed, <?= $viewbag['ActualMachineSpeed'] ?></br>
ProducedProducts, <?= $viewbag['ProducedProducts'] ?></br>
Acceptable Products, <?= $viewbag['AcceptableProducts'] ?></br>
DefectProducts, <?= $viewbag['DefectProducts'] ?></br>

<form action="batchReport/save" method="POST">
    <input name="saveBatchReport" type="submit" value="Submit"></input>
</form>

<?php include '../BeerProduction/views/partials/footer.php'; ?>