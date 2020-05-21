console.log("liveUpdate");

var update = setInterval(updateData, 500);

function updateData() {
    if ($(location).attr('pathname').substring(0,12) !== "/batchReport") {  //don't update on batchReport pages.
        updateProductionData();
    }
    updateLogs();
    updateProductionDataToDB();
}

function updateProductionData() {
    $.ajax({
        url: "/production/getProductionData",
        dataType: 'JSON',
        type: 'GET',
        success: function (result) {
            //console.log(result);
            document.getElementById('AcceptableProducts').innerHTML =(result['ProducedProducts'])-(result['DefectProducts']);
            document.getElementById('ActualMachineSpeed').innerHTML = result['ActualMachineSpeed'];
            document.getElementById('BatchID').innerHTML = result['CurrentBatchID'];
            document.getElementById('BatchSize').innerHTML = result['BatchSize'];
            document.getElementById('CurrentState').innerHTML = result['CurrentState'];
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
            document.getElementById('MaintainenceMeter').style.width = result['MaintainenceMeter'] / 35000 * 100 + '%';
        }
    });
}

function updateProductionDataToDB() {
    $.ajax({
        url: "/BatchReport/update",
        type: 'GET',
        success: function (result) {
            // console.log(result);
        }
    });
}
function updateLogs(){
    $.ajax({
        url: "/ProductionData/logUpdate",
        type: 'POST',
        success: function (result) {
            console.log(result);
        }
    });
}


