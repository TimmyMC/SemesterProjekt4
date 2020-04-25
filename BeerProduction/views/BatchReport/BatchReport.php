<?php include '../BeerProduction/views/partials/menu.php'; ?>

BatchID, <?= $viewbag['BatchID'] ?></br>
BatchSize, <?= $viewbag['BatchSize'] ?></br>
Actual MachineSpeed, <?= $viewbag['ActualMachineSpeed'] ?></br>
ProducedProducts, <?= $viewbag['ProducedProducts'] ?></br>
Acceptable Products, <?= $viewbag['AcceptableProducts'] ?></br>
DefectProducts, <?= $viewbag['DefectProducts'] ?></br>



<?
    //Form method with POST to save batch report here.
?>
<?php include '../BeerProduction/views/partials/footer.php'; ?>