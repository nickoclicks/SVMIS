<?php

class Resolutions extends Controller
{
    public function index()
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }
        $this->view('resolutions', [
       ]);
    }
  }