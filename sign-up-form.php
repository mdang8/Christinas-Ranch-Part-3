<?php
  $name = $email = $phone = $gen_rad1 = $gen_rad2 = $gen_rad3 = "";

  if (isset($_POST['name']))
    $name = $_POST['name'];
  if (isset($_POST['email']))
    $email = $_POST['email'];
  if (isset($_POST['phone']))
    $phone = $_POST['phone'];
  if (isset($_POST['gen_rad1']))
    $gen_rad1 = $_POST['gen_rad1'];
  if (isset($_POST['gen_rad2']))
    $gen_rad2 = $_POST['gen_rad2'];
  if (isset($_POST['gen_rad3']))
    $gen_rad3 = $_POST['gen_rad3'];
  if (isset($_POST['totalTime']))
    $totalTime = $_POST['totalTime'];

  class Leaderboard {
    private $name;
    private $totalTime;

    /*
     * Constructs a Leaderboard.
     */
    public function __construct($name, $totalTime) {
      $this->name = $name;
      $this->totalTime = $totalTime;
    }

    /* 
     * Makes a connection with the database 
     */
    private function database_connect() {
      $conn = mysql_connect('SERVER_NAME', 'USER', 'PASSWORD');  // replace the three fields

      if (! $conn) {
        throw new Exception('Database error: ' . mysql_error());
      }

      mysql_select_db('DATABASE', $conn);  // replace DATABASE with database name
    }

    /*
     * Displays the top 15 fastest times
     */
    public function display_leaderboards() {
      database_connect();  // makes the connection to the database

      $ordered_data = mysql_query("SELECT * FROM CRP3_leaderboards ORDER BY TIME ASC LIMIT 15");

      if (! $ordered_data) {
        throw new Exception("Error with MySQL query.");
      }

      $leaderboards_table = '';
      $rank = 1;

      while ($row_lb = mysql_fetch_assoc($ordered_data)) {
        $leaderboards_table .= "\n<tr>\n<td>" . $rank . ".</td>\n<td>" . $row_lb['NAME'] . "</td>\n<td>" . $row_lb['TIME'] . "</tr>";
        $rank += 1;
      }

      return $leaderboards_table;
    }

    /*
     * Adds a record into the table
     */
    public function add_to_database() {
      database_connect();
      $result = mysql_query("SELECT NAME FROM CRP3_leaderboards");
      $id = mt_rand();
      //$cmd = "INSERT INTO CRP3_leaderboards (ID, NAME, TIME)";
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="crsust_stylesheet.css">
    <title>Christina's Ranch Part III: Sign-up Speed Test</title>
    <script type="text/javascript">
      var startTime = Date.now();  // timestamp of when page loads (timer starts now)
    </script>
  </head>
  <body>
    <div id="header"></div>
    <div id="leaderboards">
      <span><u>Leaderboards</u></span><br>
      <table id="leaderboards-table">
        <thead>
          <tr>
            <td></td>
            <td><strong>Name</strong></td>
            <td><strong>Time</strong></td>
          </tr>
        </thead>
        <tbody>
          <?php echo display_leaderboards() ?>
        </tbody>
      </table>
    </div>
    <form id="sign-up-form">
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
    </form>
  </body>
  <script type="text/javascript">
    function submitData() {
      var endTime = Date.now();  // timestamp of when form is completed (timer ends now)
      var totalTime = endTime - startTime;  // time it took from page load to form completion (this gets logged)

      var name = document.getElementById('nameInput').value;
      var email = document.getElementById('emailInput').value;
      var phone = document.getElementById('phoneInput').value;
      var gen_rad1 = $('input[name=gen_rad1]:checked').val();
      var gen_rad2 = $('input[name=gen_rad2]:checked').val();
      var gen_rad3 = $('input[name=gen_rad3]:checked').val();

      $.ajax({
        type: 'post',
        data: {name: name, email: email, phone: phone, gen_rad1: gen_rad1, gen_rad2: gen_rad2, 
          gen_rad3: gen_rad3, totalTime: totalTime},
        success: function(data) {
          console.log("Data successfully sent!");
        }
      });
    }
  </script>
</html>