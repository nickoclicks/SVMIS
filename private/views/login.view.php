<?php $this->view('includes/header'); ?>

<div class="">
<form method="post">
<h3 class="text-center" style="margin-top: 170px;">Northern Bukidnon State College</h3>
<h5 class="text-center fw-bold text-secondary" style="margin-bottom: 40px;">Prefect of Discipline Office</h5>
  <div class="p-4 mx-auto shadow rounded border" style="width: 100%; max-width: 490px;">
    <img src="assets/nbsc1.png" class="d-block mx-auto" style="width: 130px;">


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

<h5 class="text-secondary" style="margin-left: 8px;">Email</h5>
    <center><input class="form-control" value="<?=get_var('email')?>" type="email" style="width: 95%;" name="email" placeholder="Email" autofocus></center>
    <br>

    <h5 class="text-secondary" style="margin-left: 8px;">Password</h5>
    <center><input class="form-control" value="<?=get_var('password')?>" type="password" style="width: 95%;" name="password" placeholder="Password"></center>
    <br>
    <center><button class="btn btn-primary shadow" style="font-weight: 500; color: white; width: 95%; height: 25%">Login</button></center>
  </div>
  </form>
</div>



<?php $this->view('includes/footer'); ?>