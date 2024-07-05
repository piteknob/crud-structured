<!DOCTYPE html> 
<html lang="en"> 
<head> 
  <meta charset="UTF-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <title>Live Search Ajax jQuery</title> 
  <link rel="stylesheet" href="style.css"> 
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
  <script src="script.js"></script> 
</head> 
<body> 
  <h1>Live Search Ajax jQuery</h1> 
  <input type="text" id="search-box" placeholder="Masukkan kata kunci"> 
  <ul id="search-results"></ul> 

  <script>
$(document).ready(function() {  $('#search-box').on('keyup', function() {
    var keyword = $(this).val();
    if (keyword.length >= 3) {      $.ajax({
        url: 'search.php',        type: 'POST',
        data: { keyword: keyword },        success: function(data) {
          $('#search-results').html(data);        }
      });    } else {
      $('#search-results').html('');    }
  });});
  </script>
</body> 
</html>
