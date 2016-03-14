<?php
  include 'includes/main.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="crsust_stylesheet.css">
    <title>Christina's Ranch Part III: Sign-up Speed Test</title>
    <script type="text/javascript">
      var startTime = Date.now();  // timestamp of when page loads (timer starts now)
    </script>
  </head>
  <body>
    <div id="header"></div>
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
    <div id="form-container">
      <form id="sign-up-form" action="javascript:submitData();">
        <div id="accentBanner"></div>
        <div id="formTitle">★ Christina's Ranch Part III: How Fast Can U Sign-Up? ★</div>
        <div id="name-container" class="inputs">
          <span class="inputTitle">Full Name:</span></br></br>
          <input type="text" id="nameInput" name="name" required>
        </div>
        <div id="email-container" class="inputs">
          <span class="inputTitle">Email Address:</span></br></br>
          <input type="text" id="emailInput" name="email" required>
        </div>
        <div id="phone-container" class="inputs">
          <span class="inputTitle">Random 10-digit String of Numbers:</span></br></br>
          <input type="text" id="phoneInput" name="phone" required>
        </div>
        <div id="generic-radio1-container" class="inputs">
          <span class="inputTitle">Generic Yes/No Question #1:</span></br></br>
          <input type="radio" name="gen_rad1" value="yes" required>Yes<br>
          <input type="radio" name="gen_rad1" value="no">No
        </div>
        <div id="generic-radio2-container" class="inputs">
          <span class="inputTitle">Generic Yes/No Question #2:</span></br></br>
          <input type="radio" name="gen_rad2" value="yes" required>Yes<br>
          <input type="radio" name="gen_rad2" value="no">No
        </div>
        <div id="generic-radio3-container" class="inputs">
          <span class="inputTitle">Generic Radio Select Question:</span></br></br>
          <input type="radio" name="gen_rad3" value="v1" required>1&nbsp
          <input type="radio" name="gen_rad3" value="v2">2<br>
          <input type="radio" name="gen_rad3" value="v3">3
          <input type="radio" name="gen_rad3" value="v4">4
        </div>
        <div id="generic-text-input-container" class="inputs">
          <span class="inputTitle">Generic Text Input Question:</span></br></br>
          <input type="text" id="genTextInput" name="gen_text1" required>
        </div>
        <input type="submit" id="submitButton" value="Submit">
      </form>
    </div>
  </body>
  <script type="text/javascript">
    if(window.innerWidth <= 540) {
      var $lb = $('#leaderboards');
      var lb_bottom = $lb.offset().top + $lb.outerHeight(true);
      $('#form-container').css('margin-top', lb_bottom + 20);
    }

    function submitData() {
      var endTime = Date.now();  // timestamp of when form is completed (timer ends now)
      var totalTime = (endTime - startTime) / 1000;  // time it took from page load to form completion (this gets logged)

      var name = document.getElementById('nameInput').value;

      $.ajax({
        type: 'post',
        url: 'includes/main.php',
        data: {name: name, totalTime: totalTime},
        success: function(data) {
          console.log("Data successfully sent!");
          location.reload();
        }
      });
    }
  </script>
</html>