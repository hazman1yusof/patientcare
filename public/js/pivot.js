$(document).ready(function() {

    var derivers = $.pivotUtilities.derivers;
    var renderers = $.extend($.pivotUtilities.renderers,
            $.pivotUtilities.plotly_renderers);

    $.getJSON("pivot_get", function(mps) {
        $("#output").pivotUI(mps, {
            renderers: renderers,
            unusedAttrsVertical :false,
            cols: ["gender"], rows: ["race"],
            rendererName: "Horizontal Stacked Bar Chart",
            rowOrder: "value_a_to_z", colOrder: "value_z_to_a",
        });
    });
} );