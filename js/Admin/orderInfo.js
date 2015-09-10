$(document).ready(function()
{
$('#add').click(function(e){
    e.preventDefault();
    var i = $('#products label:last').attr('name');
    i=+i+1;
    $('#products').append(' <div>'+
                            '<label name="'+i+'">'+i+'</label>'+
                            '<input type="text" name="product'+i+'" id="product'+i+'" value="">'+
                            '<input type="number" name="quantity'+i+'" id="quantity'+i+'" value="">'+
                            '</div>');
    });
    
    
});
