console.log("js");

var update = setInterval(updateData, 500);

function updateData() {
    updateProductionData();
    saveProductionData();
}

function updateProductionData() {
    $.ajax({
        url: "/productiondata/getProductionData",
        dataType: 'JSON',
        type: 'GET',
        success: function (result) {
            console.log(result);
            document.getElementById('AcceptableProducts').innerHTML = result['AcceptableProducts'];
            document.getElementById('ActualMachineSpeed').innerHTML = result['ActualMachineSpeed'];
            document.getElementById('BatchID').innerHTML = result['BatchID'];
            document.getElementById('BatchSize').innerHTML = result['BatchSize'];
            document.getElementById('CurrentState').innerHTML = result['CurrentState'];
            document.getElementById('DefectProducts').innerHTML = result['DefectProducts'];
            document.getElementById('ProducedProducts').innerHTML = result['ProducedProducts'];
            document.getElementById('MaintainenceMeter').innerHTML = result['MaintainenceMeter'];
            document.getElementById('Humidity').innerHTML = result['Humidity'];
            document.getElementById('Temperature').innerHTML = result['Temperature'];
            document.getElementById('Vibration').innerHTML = result['Vibration'];
            document.getElementById('Barley').innerHTML = result['Barley'];
            document.getElementById('Hops').innerHTML = result['Hops'];
            document.getElementById('Malt').innerHTML = result['Malt'];
            document.getElementById('Wheat').innerHTML = result['Wheat'];
            document.getElementById('Yeast').innerHTML = result['Yeast'];
        }
    });
}

function saveProductionData(){
    $.ajax({
        url: "/BatchReport/save",
        type: 'GET',
        success: function (result) {
            console.log(result);
        }
    });
}

