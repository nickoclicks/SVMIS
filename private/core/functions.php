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

  