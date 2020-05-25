$('document').ready(function (e) {
    if ($(location).attr('pathname').substring(0, 12) == "/batchReport") { //only update batchReport page
        $.ajax({
            url: '/BatchReport/getBatchReports',
            type: 'GET',
            dataType: 'JSON',
            success: function (result) {
                $.each(result, function (i, item) {
                    var batchitem = document.createElement("button");
                    batchitem.appendChild(
                        document.createTextNode(
                            '  Batch id= ' + item.batch_id +
                            ', Product type= ' + item.product_type +
                            ', Batch size= ' + item.batch_size +
                            ', Production speed= ' + item.production_speed +
                            ', Produced products= ' + item.produced_products +
                            ', Defect products= ' + item.defect_products
                        ));
                    batchitem.classList.add("list-group-item", "list-group-item-action");
                    batchitem.setAttribute("id", item.batch_id);
                    batchitem.setAttribute("type", "button");
                    batchitem.setAttribute("data-toggle", "collapse");
                    batchitem.setAttribute("data-target", "#collapse" + item.batch_id);
                    batchitem.setAttribute("aria-controls", "collapse" + item.batch_id);
                    batchitem.setAttribute("aria-expanded", "false");


                    var collapsedElement = document.createElement("div");
                    collapsedElement.classList.add("collapse");
                    collapsedElement.setAttribute("id", "collapse" + item.batch_id);

                    var information = document.createElement("div");
                    information.classList.add("card", "card-body");
                    //Call to get state log information

                    //Attach to text
                    var stateLog = function () {
                        var stateInfo;
                        $.ajax({
                            async: false,
                            url: '/BatchReport/getStateLog/' + encodeURI(item.batch_id),
                            type: 'GET',
                            dataType: 'JSON',
                            success: function (result) {
                                stateInfo = result;
                            }
                        });
                        return stateInfo;
                    }();


                    //Call to get environmental log information
                    //Attach to text
                    var environmentalLog = function () {
                        var environmentalInfo;
                        $.ajax({
                            async: false,
                            url: '/BatchReport/getEnvironmentalLog/' + encodeURI(item.batch_id),
                            type: 'GET',
                            dataType: 'JSON',
                            success: function (result) {
                                environmentalInfo = result;
                            }
                        });
                        return environmentalInfo;
                    }();

                    var infoRow = document.createElement("div");
                    infoRow.classList.add("row");


                    var stateLogGrid = document.createElement("div");
                    stateLogGrid.classList.add("col-12", "col-md-4", "m-1");

                    var stateLogContent = document.createElement("div");
                    stateLogContent.classList.add("row", "border", "p-1", "border-dark");
                    stateLogContent.innerHTML = "State Logs";
                    stateLogGrid.appendChild(stateLogContent);

                    for (let [key, value] of Object.entries(stateLog)) {
                        prettyKey = key.charAt(0).toUpperCase() + key.slice(1);
                        var item = `${prettyKey.replace('_', ' ')}: ${value}`;
                        var stateLogContent = document.createElement("div");
                        stateLogContent.classList.add("row", "border", "p-1");

                        stateLogContent.innerHTML = item;
                        stateLogGrid.appendChild(stateLogContent);
                    }


                    var environmentalLogGrid = document.createElement("div");
                    environmentalLogGrid.classList.add("col-12", "col-md-4", "m-1");

                    var environmentalLogContent = document.createElement("div");
                    environmentalLogContent.classList.add("row", "border", "p-1", "border-dark");
                    environmentalLogContent.innerHTML = "Environmental Logs";
                    environmentalLogGrid.appendChild(environmentalLogContent);

                    for (let [key, value] of Object.entries(environmentalLog)) {
                        prettyKey = key.charAt(0).toUpperCase() + key.slice(1);
                        var item = `${prettyKey}: ${value}`;
                        var environmentalLogContent = document.createElement("div");
                        environmentalLogContent.classList.add("row", "border", "p-1");

                        environmentalLogContent.innerHTML = item;
                        environmentalLogGrid.appendChild(environmentalLogContent);
                    }


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


function removeLoader() {
    var loading = document.getElementById("loading");
    loading.parentNode.removeChild(loading);
}