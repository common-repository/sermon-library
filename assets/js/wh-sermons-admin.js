jQuery(document).ready(function($) {
  $('#wh_insert_shortcode').click(function() {

    var series = $('#wh_sermons_series').val();
    if(series != "") {
      series = ' series="' + series + '"';
    }

    var teachers = $('#wh_sermons_teacher').val();
    if(teachers != "") {
      teachers = ' teacher="' + teachers + '"';
    }

    var books = $('#wh_sermons_books').val();
    if(books != "") {
      books = ' books="' + books + '"';
    }

    var page_size = $('#wh_page_size').val();
    if(page_size != "") {
      if( isNaN(page_size) ) {
        page_size = ""; // Ignore non-numeric page sizes
      }
      else {
        page_size = parseInt(page_size);
        page_size = ' page_size="' + page_size + '"';
      }
    }

    var player = ' player="HTML5"';
    var player_selected = $("input[name='wh_player']:checked").val();
    if(player_selected == 'WP') {
      player = ' player="WP"'; 
    }

    window.send_to_editor("[wh_sermons" + series + teachers + books + page_size + player + "]");
  });

  $('.wh_data_link').click(function( e ) {
    e.preventDefault();    
    var dest = $(this).attr('data-dest');
    var textbox = $('#' + dest);
    var current_value = textbox.val();
    var new_value = $(this).text();

    if(current_value != '') {
      new_value = current_value + ', ' + new_value;
    }

    console.log( "Dest: " + dest + " New value: " + new_value );

    textbox.val( new_value );
  });

});
