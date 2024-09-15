<nav class="navbar bg-body-tertiary shadow" style="background-color: gray;">
        <form class="fomr-inline">
          <div class="input-group">
            <span class="input-group-text" id="basic-addon1" style="margin-left: 10px;"><i class="fa fa-search"></i></span>
            <input type="text" class="form-control" placeholder="Search" aria-label="Username" aria-describedby="basic-addon1">
          </div>
        </form>

        <a href="<?=ROOT?>/single_violations/<?=$row->violation_id?>?tab=lecturers-add">
          <button class="btn btn-sm btn-primary" style="margin-right: 10px;"><i class="fa fa-plus"></i>Add New Lecturer</button>
    </a>

      </nav>