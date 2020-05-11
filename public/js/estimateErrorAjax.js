function setMaxSpeed(productType) {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("maxSpeedLabel").innerHTML = this.response;
            document.getElementById("productionSpeedSlider").max = this.response;
            getEstimatedError(productType, document.getElementById("productionSpeedSlider").value)
        }
    };
    xmlhttp.open("GET", "/estimateError/getMaxSpeed/" + encodeURI(productType), true);
    xmlhttp.send();
}

function getEstimatedError(productType, productionSpeed) {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("errorEstimate").innerHTML = this.response;
        }
    };
    xmlhttp.open("GET", "/estimateError/estimateErrorFunction/" + encodeURI(productType) + "/" + encodeURI(productionSpeed), true);
    xmlhttp.send();

}