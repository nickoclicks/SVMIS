<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">


    <div class="card-group justify-content-center">
        <form method="post">
            <h3>Add New Office</h3>

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

            <input autofocus class="form-control" type="text" value="<?= htmlspecialchars(get_var('schools')) ?>" name="school" placeholder="Schoolname"> <br><br>
            <input class="btn btn-primary float-end" type="submit" value="Create">
            <a href="<?=ROOT?>/schools"> 
            <input class="btn btn-warning text-white" type="button" value="Cancel">
            </a>
          </form>
    </div>
</div>

<?php $this->view('includes/footer'); ?>
