$(document).ready(function() {

    $('.ui.checkbox').checkbox();

    // $('#reg').css('color','#db2828');
    // $('#reg').css('font-weight','bold');
    // $('input[name="type"]').change(function(){
    //     var checked=$(this).is(":checked");
    //     if(checked){
    //         $('#reg').css('color','#000000');
    //         $('#reg').css('font-weight','normal');
    //         $('#dis').css('color','#2185d0');
    //         $('#dis').css('font-weight','bold');
    //         fetchjson('reg');
    //     }else{
    //         $('#dis').css('color','#000000');
    //         $('#dis').css('font-weight','normal');
    //         $('#reg').css('color','#db2828');
    //         $('#reg').css('font-weight','bold');
    //         fetchjson('dis');
    //     }
    // })

    $('input[name="type"]').change(function(){
        fetchjson($(this).val())
    });

    var derivers = $.pivotUtilities.derivers;
    var renderers = $.extend($.pivotUtilities.renderers,
            $.pivotUtilities.plotly_renderers);

    fetchjson('reg');
    function fetchjson(type){
        $.getJSON("pivot_get?type="+type, function(mps) {
            $("#output").pivotUI(mps, {
                renderers: renderers,
                unusedAttrsVertical: false,
                cols: ["month"], rows: ["religion"],
                rendererName: "Table",
                rowOrder: "value_z_to_a", colOrder: "value_z_to_a"
            });
        });
    }
} );