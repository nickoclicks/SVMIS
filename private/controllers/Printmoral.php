<?php

class Printmoral extends Controller {
  public function index()
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $this->view('printmorals');
}
}