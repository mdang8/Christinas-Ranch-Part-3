<?php
  include 'includes/main.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="crp3-confirmation_stylesheet.css">
    <title>Christina's Ranch Part III: Submission Confirmation</title>
  </head>
  <body>
    <div id="header"></div>
    <div id="message">
      <h2>Submission successful.</h2>
      <p>Did you make it on the leaderboard? Check below!</p>
    </div>
    <div id="leaderboards">
      <span><u>Leaderboard</u></span><br>
      <table id="leaderboards-table">
        <thead>
          <tr>
            <td></td>
            <td><strong>Name</strong></td>
            <td><strong>Time</strong></td>
          </tr>
        </thead>
        <tbody>
          <?php echo print_leaderboard() ?>
        </tbody>
      </table>
    </div>
  </body>
  <script type="text/javascript">
    if(window.innerWidth <= 540) {
      var $lb = $('#message');
      var lb_bottom = $lb.offset().top + $lb.outerHeight(true);
      $('#leaderboards').css('margin-top', lb_bottom + 20);
    }
  </script>
</html>