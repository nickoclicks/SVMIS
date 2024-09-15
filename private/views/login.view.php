<?php $this->view('includes/header'); ?>

<div class="">
<form method="post">
  <div class="p-4 mx-auto shadow rounded" style="width: 100%; max-width: 490px; margin-top: 150px">
    <h2 class="text-center">NBSC-Prefect of Discipline</h2>
    <img src="assets/nbsc1.png" class="border d-block mx-auto" style="width: 100px; margin: 30px">


    <?php if(count($errors) > 0): ?>

<div class="alert alert-warning alert-dismissable fade show" role="alert">
  <strong>Error:</strong>
  <?php foreach($errors as $error): ?>
    <br><?=$error?>
  <?php endforeach;?>
  <span type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</span>
</div>

<?php endif;?>

    <center><input class="form-control" value="<?=get_var('email')?>" type="email" style="width: 80%;" name="email" placeholder="Email" autofocus></center>
    <br>
    <center><input class="form-control" value="<?=get_var('password')?>" type="password" style="width: 80%;" name="password" placeholder="Password"></center>
    <br>
    <center><button class="btn btn-primary shadow" style="font-weight: 500; color: white; width: 25%; height: 25%">Login</button></center>
  </div>
  </form>
</div>



<?php $this->view('includes/footer'); ?>