$(document).ready(function() {

    var derivers = $.pivotUtilities.derivers;
    var renderers = $.extend($.pivotUtilities.renderers,$.pivotUtilities.c3_renderers);

    $.getJSON("pivot_get", function(mps) {
        $("#output").pivotUI(mps, {
            renderers: renderers,
            cols: ["gender"], rows: ["race"],
            rendererName: "Horizontal Stacked Bar Chart",
            rowOrder: "value_z_to_a", colOrder: "value_z_to_a",
            rendererOptions: {
                c3: { data: {colors: {
                    Liberal: '#dc3912', Conservative: '#3366cc', NDP: '#ff9900',
                    Green:'#109618', 'Bloc Quebecois': '#990099'
                }}}
            }
        });
    });
} );