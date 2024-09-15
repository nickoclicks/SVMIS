<?php

class Single_violators extends Controller
{
  function index($id = '')
  {
    if(!Auth::logged_in())
    {
      $this->redirect('login');
    }
  }

  $svio = new Sviolators();
}