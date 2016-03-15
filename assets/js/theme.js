



  $(".scrollbar").scroller();

    
    

 // Alert Message


  $('#message_trigger_ok').on('click', function(e) {
    e.preventDefault();
    $.scojs_message('<i class="fa fa-check-circle"></i> <strong>Well done!</strong> You successfully read this important alert message.', $.scojs_message.TYPE_OK);
  });
  $('#message_trigger_err').on('click', function(e) {
    e.preventDefault();
    $.scojs_message('<i class="fa fa-exclamation-circle"></i> <strong>Oh snap!</strong> Change a few things up and try submitting again.', $.scojs_message.TYPE_ERROR);
    });


       

 // Tooltips

    $('.tooltip-demo').tooltip({
      selector: "[data-toggle=tooltip]",
      container: "body"
    })

    $('.tooltip-test').tooltip()
    $('.popover-test').popover()




 // Methods

    function removeImage(img_id) {
      r = confirm("Êtes-vous sûr de vouloir supprimer cette image ? Cette action supprime également les tags associés");
      if (r){
       $.post("remove_image.php", {"img_id" : img_id}).success(function( data ) {
       if(data.status == 'success'){
             window.top.location.href = "index.php";
 //          alert(data.msg);
       }else if(data.status == 'error'){
         alert(data.msg);
       }
       });
     
     }
   }

                function onAddTag(tag) {
//                      alert("Added a tag: " + tag);
                }
                function onRemoveTag(tag) {
//                      alert("Removed a tag: " + tag);
                }

                function onChangeTag(input,tag) {
//                      alert("Changed a tag: " + tag);
                }

                function saveTags(img_id) {
           $("span.tag").each(function(){
tag= $(this).children('span').text().trim();
$.post("add_tag.php", {"img_id" : img_id, "tag" : tag}).success(function( data ) {
    if(data.status == 'success'){
  //      alert(data.msg);
    }else if(data.status == 'error'){
        alert(data.msg);
    }
  });
});
}

                function saveOwner(img_id) {
           owner=$( "#owner option:selected" ).text();
$.post("add_owner.php", {"img_id" : img_id, "owner" : owner}).success(function( data ) {
    if(data.status == 'success'){
    //    alert(data.msg);
    }else if(data.status == 'error'){
        alert(data.msg);
    }
  });
}

                function savePeriod(img_id) {
           period=$( "#period option:selected" ).text();
$.post("add_period.php", {"img_id" : img_id, "period" : period}).success(function( data ) {
    if(data.status == 'success'){
    //    alert(data.msg);
    }else if(data.status == 'error'){
        alert(data.msg);
    }
  });
}

                function saveTitle(img_id) {
           title=$( "#title" ).val();
$.post("add_title.php", {"img_id" : img_id, "title" : title}).success(function( data ) {
    if(data.status == 'success'){
    //    alert(data.msg);
    }else if(data.status == 'error'){
        alert(data.msg);
    }
  });
}

                function saveDate(img_id) {
      today = new Date();
      dd = today.getDate();
      mm = today.getMonth()+1; //January is 0!

      yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 
    date=yyyy + "-" + mm + "-" + dd
$.post("add_date.php", {"img_id" : img_id, "date" : date}).success(function( data ) {
    if(data.status == 'success'){
    //    alert(data.msg);
    }else if(data.status == 'error'){
        alert(data.msg);
    }
  });
}


