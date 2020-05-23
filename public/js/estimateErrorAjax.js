console.log("EEF");

$('#produce').click(function(e) {
    e.preventDefault();
    $.ajax({
        url: '/production/produceBatch',
        type: 'POST',
        data: $('#startProductionForm').serialize(),
        success: function(result) {
            // console.log(result)
        }
    });
});

$('#stop').click(function(e) {
    e.preventDefault();
    $.ajax({
        url: '/production/stopBatch',
        type: 'GET',
        success: function(result) {
            // console.log(result)
        }
    });
});

$('#abort').click(function(e) {
    e.preventDefault();
    $.ajax({
        url: '/production/abortBatch',
        type: 'GET',
        success: function(result) {
            // console.log(result)
        }
    });
});

function setMaxSpeed(productType) {
    $.ajax({
        url: "/production/getMaxSpeed/" + encodeURI(productType),
        type: 'GET',
        success: function(response) {
            document.getElementById("maxSpeedLabel").innerHTML = response;
            document.getElementById("batchSpeed").max = response;
            getEstimatedError(productType, document.getElementById("batchSpeed").value)
        }
    });
}

function getEstimatedError(productType, productionSpeed) {
    $.ajax({
        url: "/production/estimateErrorFunction/" + encodeURI(productType) + "/" + encodeURI(productionSpeed),
        type: 'GET',
        success: function(response) {
            document.getElementById("errorEstimate").innerHTML = response;
        }
    });
}