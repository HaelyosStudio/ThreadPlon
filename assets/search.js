$(document).ready(function() {
    $('#searchButton').click(function(event) {
      event.preventDefault();
      $('#overlay').toggle();
      $('#searchBar').focus();
    });
  
    $('#overlay').click(function() {
        $(this).hide();
      });
  });
  