console.log("liveUpdate");

var update = setInterval(updateData, 500); //TODO consider 1 sec
var update = setInterval(updateLogs, 1000);
var update = setInterval(updateBatchReport, 5000);

function updateData() {
    if ($(location).attr('pathname').substring(0, 12) !== "/batchReport") { //don't update on batchReport pages.
        updateProductionData();
    }
}

function updateProductionData() {
    $.ajax({
        url: "/production/getProductionData",
        dataType: 'JSON',
        type: 'GET',
        success: function (result) {
            // console.log(result);
            document.getElementById('AcceptableProducts').innerHTML = (result['ProducedProducts']) - (result['DefectProducts']);
            document.getElementById('ActualMachineSpeed').innerHTML = result['ActualMachineSpeed'];
            document.getElementById('BatchID').innerHTML = result['CurrentBatchID'];
            document.getElementById('BatchSize').innerHTML = result['BatchSize'];
            document.getElementById('DefectProducts').innerHTML = result['DefectProducts'];
            document.getElementById('ProducedProducts').innerHTML = result['ProducedProducts'];
            document.getElementById('Humidity').innerHTML = result['Humidity'];
            document.getElementById('Temperature').innerHTML = result['Temperature'];
            document.getElementById('Vibration').innerHTML = result['Vibration'];

            document.getElementById('Barley').innerHTML = result['Barley'];
            document.getElementById('Hops').innerHTML = result['Hops'];
            document.getElementById('Malt').innerHTML = result['Malt'];
            document.getElementById('Wheat').innerHTML = result['Wheat'];
            document.getElementById('Yeast').innerHTML = result['Yeast'];
            document.getElementById('MaintainenceMeter').innerHTML = result['MaintainenceMeter'];
            document.getElementById('Barley').style.width = result['Barley'] / 35000 * 100 + '%';
            document.getElementById('Hops').style.width = result['Hops'] / 35000 * 100 + '%';
            document.getElementById('Malt').style.width = result['Malt'] / 35000 * 100 + '%';
            document.getElementById('Wheat').style.width = result['Wheat'] / 35000 * 100 + '%';
            document.getElementById('Yeast').style.width = result['Yeast'] / 35000 * 100 + '%';

            maintainencePercent = result['MaintainenceMeter'] / 30000 * 100;
            // maintainencePercent = 63;
            document.getElementById('MaintainenceMeter').style.height = maintainencePercent + '%';

            if (maintainencePercent >= 85) {
                document.getElementById('MaintainenceMeter').classList.add("bg-danger");
                document.getElementById('MaintainenceMeter').classList.remove("bg-warning");
                document.getElementById('MaintainenceMeter').classList.remove("bg-success");
            } else if (maintainencePercent >= 60) {
                document.getElementById('MaintainenceMeter').classList.add("bg-warning");
                document.getElementById('MaintainenceMeter').classList.remove("bg-danger");
                document.getElementById('MaintainenceMeter').classList.remove("bg-success");
            } else {
                document.getElementById('MaintainenceMeter').classList.add("bg-success");
                document.getElementById('MaintainenceMeter').classList.remove("bg-warning");
                document.getElementById('MaintainenceMeter').classList.remove("bg-danger");
            }

            var currentState = result['CurrentState'].replace('_', ' ');
            document.getElementById('CurrentState').innerHTML = currentState;

            if (currentState == "Execute state") {
                document.getElementById('produce').disabled = true;
                document.getElementById('stop').disabled = false;
            } else {
                document.getElementById('stop').disabled = true;
                document.getElementById('produce').disabled = false;
            }
        }
    });
}

function updateBatchReport() {
    $.ajax({
        url: "/BatchReport/update",
        type: 'GET',
        success: function (result) {
            console.log(result);
        }
    });
}

function updateLogs() {
    $.ajax({
        url: "/ProductionData/logUpdate",
        type: 'GET',
        success: function (result) {
            // console.log(result);
        }
    });
}