$(document).ready(function() {
  $('#summernote').summernote({
    height: 200
  });
});

$(document).ready(function(){
  $('#selectAllBoxes').click(function(event){
    if(this.checked){
      $('.checkBoxes').each(function(){
        this.checked = true;
      });
    } else {
      $('.checkBoxes').each(function(){
        this.checked = false;
      });
    };
  });

  // var div_box = "<div id='load-screen'><div id='loading'></div></div>";

  // $("body").prepend(div_box);

  //NOTE: as soon as you prepend this specific div box, the php breaks, and nothing works. 

  // $('#load-screen').delay(700).fadeout(600, function(){
  //   $(this).remove();
  // });

  });
