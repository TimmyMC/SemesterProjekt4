$('document').ready(function(e) {
    if ($(location).attr('pathname').substring(0, 12) == "/batchReport") { //only update batchReport page
        $.ajax({
            url: '/BatchReport/getBatchReports',
            type: 'GET',
            success: function(result) {

                $.each(JSON.parse(result), function(i, item) {
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
                    //console.log(JSON.parse(stateLog));
                    var stateLog = function() {
                        var stateInfo;
                        $.ajax({
                            async: false,
                            url: '/BatchReport/getStateLog/' + encodeURI(item.batch_id),
                            type: 'GET',
                            success: function(result) {
                                console.log(result);
                                stateInfo = result;
                            }
                        });
                        return stateInfo;
                    }();

                    console.log(stateLog);


                    //Call to get environmental log information
                    //Attach to text
                    var environmentalLog = function() {
                        var environmentalInfo;
                        $.ajax({
                            async: false,
                            url: '/BatchReport/getEnvironmentalLog/' + encodeURI(item.batch_id),
                            type: 'GET',
                            success: function(result) {
                                console.log(result);
                                environmentalInfo = result;
                            }
                        });
                        return environmentalInfo;
                    }();

                    console.log(stateLog);


                    information.appendChild(
                        document.createTextNode(
                            "State Log Information:" +
                            "\n" +
                            stateLog +
                            "\n" +
                            "Environmental Log Information:" +
                            "\n" +
                            environmentalLog
                        )
                    );

                    var _pre = document.createElement("pre");
                    _pre.appendChild(information);

                    collapsedElement.appendChild(_pre);
                    batchitem.appendChild(collapsedElement);

                    document.getElementById("batchReportList").appendChild(batchitem);
                });
            }
        });
    }
});