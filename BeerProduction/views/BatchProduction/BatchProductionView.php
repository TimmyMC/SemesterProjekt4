<?php
?>


<h2> Batch Production </h2>
<form action="/BeerProduction/public/BatchProduction/produceBatch" method="POST">
    <label>BatchID</label>
    <input type="text" id="batchID" name="batchID" required><br>
    <label>BatchProductType</label>
    <input type="text" id="batchProductType" name="batchProductType" required><br>
    <label>BatchSpeed</label>
    <input type="text" id="batchSpeed" name="batchSpeed" required><br>
    <label>BatchSize</label>
    <input type="text" id="batchSize" name="batchSize" required><br>
    <input type="submit" value="Produce"></button>
</form>