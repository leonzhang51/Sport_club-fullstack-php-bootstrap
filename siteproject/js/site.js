
   $(document).ready(function() {
    $('.btn').click(function(e){
        e.preventDefault();
        var value = parseInt($(this).attr('data-emp-id'),10);     
        $('#response').text( value );
        document.cookie = "id="+ (value);
    });
    
    

});
   
   



