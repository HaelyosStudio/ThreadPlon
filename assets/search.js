$(document).ready(function() {
    $(document).on('click', '#searchButton', function(event) {
      console.log('Search button clicked');
      event.preventDefault();
      $('#overlay').toggle();
      $('#searchBar').focus();
    });
  
    $(document).on('click', function(event) {
      if ($(event.target).is('#overlay')) {
        $('#overlay').hide();
      }
    });
  
    $('#searchBar').blur(function() {
      $('#overlay').hide();
    });
  });
  