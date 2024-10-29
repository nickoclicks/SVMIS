<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<div class="dashboard-container">
    

   <center><div class="row">
       <h1>Archiving and School Year Elevation Coming Soon</h1>
    </div></center>

    <div class="row">
        <div class="col-md-12">
            <h2>Activity Logs</h2>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Activity Name</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activityLogs as $log) { ?>
                        <tr>
                            <td><?= $log->activity_name; ?></td>
                            <td><?= get_date($log->date); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // When the user selects a filter
const schoolYearFilter = document.getElementById('school_year_id');
schoolYearFilter.addEventListener('change', (e) => {
  const selectedFilter = e.target.value;
  sessionStorage.setItem('schoolYearFilter', selectedFilter);
});

// On page load, check if the filter value is stored in sessionStorage
document.addEventListener('DOMContentLoaded', () => {
  const storedFilter = sessionStorage.getItem('schoolYearFilter');
  if (storedFilter) {
    document.getElementById('school_year_id').value = storedFilter;
    // Apply the filter to the dashboard
    applyFilter(storedFilter);
  }
});

// Function to apply the filter to the dashboard
function applyFilter(filterValue) {
  // Your code to apply the filter to the dashboard
}
</script>

<?php $this->view('includes/footer'); ?>