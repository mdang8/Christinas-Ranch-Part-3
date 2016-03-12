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

  function print_leaderboard() {
    $top15_lb = new Leaderboard($name, $totalTime);
    return $top15_lb->display_leaderboards();
  }

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
      $conn = new mysqli('SERVER', 'USER', 'PASSWORD', 'DATABASE');

      if ($conn->connect_errno > 0) {
        die("Error in connecting to database: " . $conn->connect_error);
      }

      return $conn;
    }

    /*
     * Displays the top 15 fastest times
     */
    public function display_leaderboards() {
      $conn = $this->database_connect();  // makes the connection to the database

      $query = <<<SQL
          SELECT * FROM CRP3_leaderboards
          ORDER BY TIME ASC LIMIT 15;
SQL;

      if (!$result = $conn->query($query)) {
        die("Error with query: " . $conn->error);
      }

      $leaderboards_table = '';
      $rank = 1;

      while ($row = $result->fetch_assoc()) {
        $leaderboards_table .= "\n<tr>\n<td>" . $rank . ".</td>\n<td>" . $row['NAME'] . 
            "</td>\n<td>" . $row['TIME'] . "</tr>";
        $rank += 1;
      }

      $conn->close();

      return $leaderboards_table;
    }

    /*
     * Adds a record into the table
     */
    public function add_to_database() {
      $conn = $this->database_connect();  // makes the connection to the database
      $names = $conn->query("SELECT * FROM CRP3_leaderboards");

      if ($names === FALSE) {
        die("Error with names query: " . $conn->error);
      }

      $name_to_add = mysqli_real_escape_string($conn, $this->name);
      $name_in_table = FALSE;
      $names->data_seek(0);
      while($row = $names->fetch_assoc()) {
        if ($row['NAME'] == $name_to_add) {  // name is already in table
          $name_in_table = TRUE;
          return;  // exit function
        }
      }

      $id = mt_rand();
      $insert = <<<SQL
          INSERT INTO CRP3_leaderboards (ID, NAME, TIME)
          VALUES ($id, '$this->name', $this->totalTime);
SQL;

      if ($conn->query($insert) === TRUE) {
        echo "Successfully inserted record";
      } else {
        die("Error with insert: " . $conn->error);
      }
    }
  }
?>