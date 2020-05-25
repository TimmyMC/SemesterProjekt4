
$('document').ready(function (e) {
    if ($(location).attr('pathname').substring(0, 12) !== "/batchReport") { //don't update on batchReport pages.
        updateOEE();
    }
});

$('#startProductionForm').submit(function (e) {
    $.ajax({
        url: '/production/produceBatch',
        type: 'POST',
        data: $('#startProductionForm').serialize()
    });
    return false;
});

$('#stop').click(function (e) {
    e.preventDefault();
    $.ajax({
        url: '/production/stopBatch',
        type: 'GET'
    });
});

$('#abort').click(function (e) {
    e.preventDefault();
    $.ajax({
        url: '/production/abortBatch',
        type: 'GET'
    });
});

$('#getOptimalSpeed').click(function (e) {
    e.preventDefault();

    var productType = document.getElementById("batchProductType").value;
    $.ajax({
        url: "/production/getOptimalSpeed/" + encodeURI(productType),
        type: 'GET',
        dataType: 'JSON',
        success: function (result) {
            document.getElementById("batchSpeed").value = result['optimalSpeed'];
            document.getElementById("currentSpeedLabel").innerHTML = result['optimalSpeed'];
            document.getElementById("errorEstimate").innerHTML = result['estimatedError'];
        }
    });
});

function setMaxSpeed(productType) {
    $.ajax({
        url: "/production/getMaxSpeed/" + encodeURI(productType),
        type: 'GET',
        success: function (response) {
            document.getElementById("maxSpeedLabel").innerHTML = response;
            document.getElementById("batchSpeed").max = response;
            getEstimatedError(productType, document.getElementById("batchSpeed").value)
        }
    });
}

function getEstimatedError(productType, productionSpeed) {
    document.getElementById("currentSpeedLabel").innerHTML = productionSpeed;

    $.ajax({
        url: "/production/estimateErrorFunction/" + encodeURI(productType) + "/" + encodeURI(productionSpeed),
        type: 'GET',
        success: function (response) {
            document.getElementById("errorEstimate").innerHTML = response;
        }
    });
}

function updateOEE() {
    $.ajax({
        url: '/OEE',
        type: 'GET',
        dataType: 'JSON',
        success: function (result) {
            document.getElementById("pilsnerOEE").innerHTML = result['Pilsner'];
            document.getElementById("wheatOEE").innerHTML = result['Wheat'];
            document.getElementById("IPAOEE").innerHTML = result['Ipa'];
            document.getElementById("aleOEE").innerHTML = result['Ale'];
            document.getElementById("stoutOEE").innerHTML = result['Stout'];
            document.getElementById("alcoholFreeOEE").innerHTML = result['AlcoholFree'];
        }
    });
}
