//-----------------------------------------------------
//Function to Initialize draggable on the <li> elements
//-----------------------------------------------------
function init() {
  $('#makeMeDraggable li').draggable();
  $('#makeMeDroppable li').draggable();
  $('#makeMeDroppable').droppable( {
    drop: handleDropEvent
  } );
  $('#makeMeDraggable').droppable( {
    drop: handleDropEventReverse
  } );
}
 
function handleDropEvent( event, ui ) {
  var draggable = ui.draggable;
  var draggable1 = draggable.attr('id');
  var data = { 'add' : draggable1 };
  $.ajax({
          type: 'POST',
          url: 'getTable.php',
          data: data,
          success: function(data){
             $("#makeMeDroppable").html(data);
          } 
        });
  
  $.ajax({
          type: 'POST',
          url: 'getClass.php',
          success: function(data){
             $("#makeMeDraggable").html(data);
          } 
        });
  
}

function handleDropEventReverse( event, ui ) {
  var draggable = ui.draggable;
  var draggable1 = draggable.attr('id');
  //var data = "?add=" + draggable1;
  var data = { 'rem' : draggable1 };
  $.ajax({
          type: 'POST',
          url: 'getTable.php',
          data: data,
          success: function(data){
             $("#makeMeDroppable").html(data);
          } 
        });
  
  $.ajax({
          type: 'POST',
          url: 'getClass.php',
          success: function(data){
             $("#makeMeDraggable").html(data);
          } 
        });
  
}


function saveMembers(){
    alert('Members Saved!');
    window.location.href= "index.php";
    return false;
}