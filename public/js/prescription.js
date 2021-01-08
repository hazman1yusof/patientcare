$(document).ready(function() {

    $('table.basic tr').click(function(){
        window.location.href = "/prescription/"+$(this).data('id');
    })
} );