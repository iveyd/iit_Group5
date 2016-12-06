$(window).load(function() {
  /* Act on the event */

  $( "#mainContainer" ).sortable({ //allow the contents of the main container to be sorted
    // placeholder: "highlight",
    connectWith:'#mainContainer',
    accept: ".listObject",
    // containment: 'parent',
    start: function(event, ui) {
      // Resize elements
      $(this).sortable('refreshPositions');
    }
  });
  
  $("#listGen").on("click", function() { //add new element to the main container
    $('#mainContainer').append(
      '<div class="listObject">\
        <input name=listName></input>\
        <button type="button" class="objectButton" onclick="makeObj(this)">Create a new object</button>\
      </div>'
    );
    $(".listObject").sortable({ //add sortable functionality to the new list
      // placeholder: "highlight",
      connectWith:'.listObject',
      accept: ".itemObject",
      // containment: 'parent',
      start: function(event, ui) {
        // Resize elements
        $(this).sortable('refreshPositions');
      }
    });
  });

  
  window.makeObj = function(obj) { //add a new object to the list that containes the clicked button
    $('<div class="itemObject">\
        <input name="itemName"></input>\
        <div class="attrObject">\
        Value:\
        <input name="attrName"></input>\
      </div>\
      </div>').insertBefore(obj); //insert before the button

    $(".itemObject").sortable({ //add sortable functionality to the new object
      // placeholder: "highlight",
      connectWith:'.attrObject',
      accept: ".attrObject",
      // containment: 'parent',
      start: function(event, ui) {
        // Resize elements
        $(this).sortable('refreshPositions');
      }
    });
  // });
}

 
  $( "#trashCan" ).droppable({ //when an object is dragged to the trash can, promt user, then delete the element
    accept: "div:not(#objectGen,#listGen)",
    drop: function(event, ui) {
      check = confirm("Are you sure you want to delete this item?");
      if (check == true) {
        ui.draggable.remove();
      }
    }
  });

  $( "#mainContainer" ).disableSelection(); //make the main container unselectable

});