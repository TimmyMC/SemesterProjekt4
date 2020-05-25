$('document').ready(function (e) {
    if ($(location).attr('pathname').substring(0, 12) == "/batchReport") { //only update batchReport page
        $.ajax({
            url: '/BatchReport/getBatchReports',
            type: 'GET',
            dataType: 'JSON',
            success: function (allBatchReports) {
                console.log(allBatchReports);

                $.each(allBatchReports, function (i, batchReport) {

                    var batchitem = document.createElement("button");
                    batchitem.appendChild(
                        document.createTextNode(
                            '  Batch id= ' + batchReport.batch_id +
                            ', Product type= ' + batchReport.product_type +
                            ', Batch size= ' + batchReport.batch_size +
                            ', Production speed= ' + batchReport.production_speed +
                            ', Produced products= ' + batchReport.produced_products +
                            ', Defect products= ' + batchReport.defect_products
                        ));
                    batchitem.classList.add("list-group-item", "list-group-item-action");
                    batchitem.setAttribute("id", batchReport.batch_id);
                    batchitem.setAttribute("type", "button");
                    batchitem.setAttribute("data-toggle", "collapse");
                    batchitem.setAttribute("data-target", "#collapse" + batchReport.batch_id);
                    batchitem.setAttribute("aria-controls", "collapse" + batchReport.batch_id);
                    batchitem.setAttribute("aria-expanded", "false");

                    var collapsedElement = document.createElement("div");
                    collapsedElement.classList.add("collapse");
                    collapsedElement.setAttribute("id", "collapse" + batchReport.batch_id);

                    var information = document.createElement("div");
                    information.classList.add("card", "card-body");


                    //Create tables
                    var infoRow = document.createElement("div");
                    infoRow.classList.add("row");

                    stateLogGrid = generateTable("State Logs", batchReport.stateLog);
                    environmentalLogGrid = generateTable("Environmental Logs", batchReport.environmentalLog);

                    infoRow.appendChild(stateLogGrid);
                    infoRow.appendChild(environmentalLogGrid);
                    information.appendChild(infoRow);

                    var _pre = document.createElement("pre");
                    _pre.appendChild(information);

                    collapsedElement.appendChild(_pre);
                    batchitem.appendChild(collapsedElement);

                    document.getElementById("batchReportList").appendChild(batchitem);
                });

                removeLoader();
            }
        });
    }
});

function generateTable(tableHeader, tableData) {
    var logGrid = document.createElement("div");
    logGrid.classList.add("col-12", "col-md-4", "m-1");

    //Table Header
    var logContent = document.createElement("div");
    logContent.classList.add("row", "border", "p-1", "border-dark");
    logContent.innerHTML = tableHeader;
    logGrid.appendChild(logContent);

    //Table Data
    for (let [key, value] of Object.entries(tableData)) {
        prettyKey = key.charAt(0).toUpperCase() + key.slice(1);
        prettyKey = prettyKey.replace('_', ' ');
        var item = `${prettyKey}: ${value}`;
        var logContent = document.createElement("div");
        logContent.classList.add("row", "border", "p-1");

        logContent.innerHTML = item;
        logGrid.appendChild(logContent);
    }

    return logGrid;
}

function removeLoader() {
    var loading = document.getElementById("loading");
    loading.parentNode.removeChild(loading);
}