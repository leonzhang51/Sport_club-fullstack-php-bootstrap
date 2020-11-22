<?php
// Handle AJAX request (start)
if( isset($_POST['ajax']) && isset($_POST['name']) ){
 echo "this is test"; //$_POST['name'];
 exit;
}
// Handle AJAX request (end)
?>

<!doctype html>
<html>

  <head>
  <title>Page de l’administrateur</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier un article</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" 
    integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    
    
    <script src="./js/site.js"></script>
    
    
</head>
 
 <body >
 
  <form method='post' action>

   <input type='text' name='name' placeholder='Enter your name' id='name'>
   <input type='submit' value='submit' name='submit'><br>
   <div id='response'></div>
  </form>

  <!-- Script -->
  
  <script>
  $(document).ready(function(){
    $('#name').keyup(function(){
     var name = $('#name').val();

     $.ajax({
      type: 'post',
      data: {ajax: 2,name: name},
      success: function(response){
       $('#response').text('name : ' + response);
      }
     });
    });
    
  });
  
    
  </script>
  
  <button id="opener">打开对话框</button>
<div id="dialog" title="对话框标题">
我是一个对话框
<p>
    <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
    Your files have downloaded successfully into the My Downloads folder.
  </p>
  <p>
    Currently using <b>36% of your storage space</b>.
  </p>
</div>
 
<script>
$( "#dialog" ).dialog({ 
  autoOpen: false,
  resizable: false,
      height:300,
      modal: true,
      buttons: {
        "Delete all items": function() {
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
  
});
$( "#opener" ).click(function() {
  $( "#dialog" ).dialog( "open" );
});
</script>


 </body>
</html>