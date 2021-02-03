$(document).ready(function() {

    $('.ui.checkbox').checkbox();

    $('input[name="throughput"]').change(function(){
        fetchjson($(this).val());
    })

    var derivers = $.pivotUtilities.derivers;
    var renderers = $.extend($.pivotUtilities.renderers,
            $.pivotUtilities.plotly_renderers);

    fetchjson('dis');
    function fetchjson(type){
        $.getJSON("pivot_get?type="+type, function(mps) {
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
    }


    
} );