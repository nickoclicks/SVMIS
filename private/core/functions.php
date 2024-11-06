<?php



function get_var($key,$default = "")
{
  if(isset($_POST[$key]))
  {
    return $_POST[$key];
  }
  return $default;
}

function get_select($key,$value)
{
  if(isset($_POST[$key]))
  {
    if($_POST[$key] == $value)
    {
      return "selected";
    };
  }
  return "";
}

function esc($var)
{
  return htmlspecialchars($var);
}

function random_string($length)
  {
    $array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    $text = "";

    for($x = 0; $x < $length; $x++)
    {
      $random = rand(0,61);
      $text .= $array[$random];
    }

    return $text;
  }

  function get_date($date)
  {
    return date("F jS, Y", strtotime($date));
  }

  function helper($data)
  {
    echo "<pre>";
    print_r($data);
    echo "</pre>";

  }

  function get_image($image, $gender = 'male') {
    // If the image exists, return its URL
    if (file_exists($image)) {
        return ASSETS . '/' . $image;
    }

    // Return the default image based on gender
    return ($gender == 'male') ? ASSETS . '/male.jpg' : ASSETS . '/female.png';
}


  function views_path($view)
  {
    if(file_exists("../private/views/" . $view . ".inc.php"))
    {
      return ("../private/views/" . $view . ".inc.php");
    } else {
      return ("../private/views/404.view.php");
    }
  }

  function formatOffense($offenseCount) {
    if ($offenseCount == 1) {
        return "1st Offense";
    } elseif ($offenseCount == 2) {
        return "2nd Offense";
    } elseif ($offenseCount == 3) {
        return "3rd Offense";
    } else {
        return $offenseCount . "th Offense";
    }
}

function formatYearLevel($yearLevel) {
  switch ($yearLevel) {
      case 1:
          return '1st';
      case 2:
          return '2nd';
      case 3:
          return '3rd';
      case 4:
          return '4th';
      default:
          return ''; // Return empty for invalid year levels
  }
}

function log_activity($log_name)
{
    $db = new Database();
    
    $data['log_name'] = $log_name; 
   
    $data['date'] = date('Y-m-d H:i:s'); 

    // Insert log into activity_logs table
    $query = "INSERT INTO good_moral_logs (log_name, date) VALUES (:log_name, :date)";
    
    $db->query($query, $data);
}


// Check if the form has been submitte


function log_certificate($log_name)
{
    $db = new Database();
    
    $data['log_name'] = $log_name;
    $data['date'] = date('Y-m-d');
    
    
    $query = "INSERT INTO good_moral_logs (log_name, date) VALUES (:log_name, :date)";
    
    $db->query($query, $data);
}

function getViolationCountsByDay($result) {
  $DatePresentCounts = [];

  // Process the result set
  while ($row = mysqli_fetch_assoc($result)) {
      $date = $row['date'];
      $count = $row['count']; // Assuming you have a count field from your query

      // Get the day name (e.g., Monday, Tuesday)
      $dayName = date('l', strtotime($date));

      // Initialize the array if it doesn't exist
      if (!isset($DatePresentCounts[$dayName])) {
          $DatePresentCounts[$dayName] = 0;
      }

      // Add the count to the corresponding day
      $DatePresentCounts[$dayName] += $count;
  }

  // Ensure the days are in order
  $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  $orderedCounts = [];
  foreach ($daysOfWeek as $day) {
      $orderedCounts[$day] = $DatePresentCounts[$day] ?? 0; // Default to 0 if not set
  }

  return $orderedCounts;
}


function countUpcomingAppointmentsForNextWeek()
{
    $db = new Form(); // Create a new instance of the Database class

    // Set the date range for counting appointments
    
    // Set the date range for today
    $today = new DateTime();
    $today->setTime(0, 0, 0); // Reset time to 00:00:00
    $endOfDay = clone $today;
    $endOfDay->setTime(23, 59, 59); // Set to 23:59:59 of today

    // Prepare the SQL query to count appointments for today
    $query = "SELECT COUNT(*) as count FROM notice WHERE appt_date >= :today AND appt_date <= :endOfDay";

    // Define the parameters for the query
    $params = [
        'today' => $today->format('Y-m-d H:i:s'),
        'endOfDay' => $endOfDay->format('Y-m-d H:i:s')
    ];

    // Execute the query and fetch the result
    $result = $db->query($query, $params);

    // Return the count or 0 if no results
    return $result ? (int)$result[0]->count : 0;
}