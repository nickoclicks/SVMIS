<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
<?php $this->view('includes/crumbs',['crumbs'=>$crumbs]); ?>

    <?php if($row):?>
    <div class="card-group justify-content-center">

    
        <form method="post">
            <h3>Are you sure you want to delete?</h3>

            <input disabled autofocus class="form-control" type="text" value="<?=get_var('schools',$row->school) ?>" name="school" placeholder="Schoolname"> <br><br>
            <input type="hidden" name="id">
            <input class="btn btn-danger float-end" type="submit" value="Delete">
            <a href="<?=ROOT?>/schools"> 
            <input class="btn btn-success text-white" type="button" value="Cancel">
            </a>
          </form>
    </div>

    <?php else:?>
      <div style="text-align: center;">
            <h3>That school was not found </h3>

            <a href="<?=ROOT?>/schools"> 
            <input class="btn btn-warning text-white" type="button" value="Cancel">
            </a>
            <br><br>
            </div>
          <?php endif;?>
</div>

<?php $this->view('includes/footer'); ?>
