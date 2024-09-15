<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<div class="container mt-4">
        <h1>Reports</h1>

        <!-- Filter Form -->
        <form method="GET" action="">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">All</option>
                        <option value="Referred to SDC" <?php echo $filters['status'] == 'Referred to SDC' ? 'selected' : ''; ?>>Referred to SDC</option>
                        <option value="Solved" <?php echo $filters['status'] == 'Solved' ? 'selected' : ''; ?>>Solved</option>
                        <option value="Unresolved" <?php echo $filters['status'] == 'Unresolved' ? 'selected' : ''; ?>>Unresolved</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="year_level" class="form-label">Year Level</label>
                    <select id="year_level" name="year_level" class="form-select">
                        <option value="">All</option>
                        <!-- Add your year levels here -->
                        <option value="1st" <?php echo $filters['year_level'] == '1st' ? 'selected' : ''; ?>>1st Year</option>
                        <option value="2nd" <?php echo $filters['year_level'] == '2nd' ? 'selected' : ''; ?>>2nd Year</option>
                        <option value="3rd" <?php echo $filters['year_level'] == '3rd' ? 'selected' : ''; ?>>3rd Year</option>
                        <option value="4th" <?php echo $filters['year_level'] == '4th' ? 'selected' : ''; ?>>4th Year</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="course" class="form-label">Course</label>
                    <select id="course" name="course" class="form-select">
                        <option value="">All</option>
                        <option value="BSBA" <?php echo $filters['course'] == 'BSBA' ? 'selected' : ''; ?>>BSBA</option>
                        <option value="BSIT" <?php echo $filters['course'] == 'BSIT' ? 'selected' : ''; ?>>BSIT</option>
                        <option value="TEP" <?php echo $filters['course'] == 'TEP' ? 'selected' : ''; ?>>TEP</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="month" class="form-label">Month</label>
                    <select id="month" name="month" class="form-select">
                        <option value="">All</option>
                        <!-- Generate month options dynamically -->
                        <?php
                        $months = [
                            '1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April',
                            '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August',
                            '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
                        ];
                        foreach ($months as $value => $name) {
                            $selected = $filters['month'] == $value ? 'selected' : '';
                            echo "<option value=\"$value\" $selected>$name</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <center><button type="submit" class="btn btn-secondary" style="width: 10%; color: black; font-weight: 600">OK</button></center>
        </form>

        <!-- Display Tables -->
        <div class="mt-4">
            <!--<h2>Total Violations: <?php echo $totalViolations; ?></h2>
            <h2>Total Violators: <?php echo $totalViolators; ?></h2>
            <h2>Total Notices: <?php echo $totalNotices; ?></h2>

            <!-- Recent Violators Table -->
            
            <?php if (!empty($recentViolators)): ?>
    <table class="table table-bordered table-hovered table-striped" id="table">
        <thead style="background-color: gray;">
            <tr>
                <th>Student ID</th>
                <th>Complaint</th>
                <th>Date</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Course</th>
                <th>Year Level</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recentViolators as $violator): ?>
                <tr>
                    <td><?php echo htmlspecialchars($violator->std_id); ?></td>
                    <td><?php echo htmlspecialchars($violator->complaint); ?></td>
                    <td><?php echo htmlspecialchars(get_date($violator->date)); ?></td>
                    <td><?php echo htmlspecialchars($violator->firstname); ?></td>
                    <td><?php echo htmlspecialchars($violator->middlename); ?></td>
                    <td><?php echo htmlspecialchars($violator->lastname); ?></td>
                    <td><?php echo htmlspecialchars($violator->course); ?></td>
                    <td><?php echo htmlspecialchars($violator->year_level); ?></td>
                    <td><?php echo htmlspecialchars($violator->status); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No records found.</p>
<?php endif; ?>
    </div>

    <center><button onclick="printContent()" style="width: 10%;"><i class="fa fa-print"></i></button></center>
    <!-- Printable Section -->
    


    




<script>


function printContent() {
    // Hide no-print elements
    document.querySelectorAll('.no-print').forEach(el => el.style.display = 'none');

    // Get the table to print
    var printContent = document.querySelector('.table.table-bordered.table-hovered.table-striped');

    // Create a new header for the print
    var header = `
   
    <div style="text-align: center; margin-bottom: 0;">
    <img src="assets/nbsc1.png" alt="University Logo" style="width: 100px; height: 95px; margin-right: 10px; float: left;">
    <img src="assets/nbsc1.png" alt="University Logo" style="width: 100px; height: 95px; margin-right: 10px; float: right;">
        <h4 style="margin-bottom: -20px;">Republic of the Philippines</h4>
        <h4 style="margin-bottom: -20px;"><b>NORTHERN BUKIDNON STATE COLLEGE</b></h4>
        <h4 style="margin-bottom: -20px;"><i>(Formerly Northern Bukidnon Community College)</i> R.A.11284</h4>
        <h4 style="margin-bottom: -20px;">Manolo Fortich, 8703 Bukidnon</h4>
        <h4 style="margin-bottom: -5px;"><i>Creando futura, Transformationis vitae, Ductae a Deo</i></h4> 
        <hr>
    </div>
    
    `;

    // Create a new table with border
    var table = printContent.outerHTML;
    table = table.replace('<table', '<table border="1" cellpadding="5" cellspacing="0"');

    // Create the print content
    var printHtml = header + table;

    // Open a new window for printing
    var windowUrl = 'about:blank';
    var windowName = 'Print';
    var windowFeatures = 'width=800,height=600,left=100,top=100';
    var windowOpen = window.open(windowUrl, windowName, windowFeatures);
    windowOpen.document.write(printHtml);
    windowOpen.document.close();
    windowOpen.focus();
    windowOpen.print();

    // Restore original visibility after printing
    document.querySelectorAll('.no-print').forEach(el => el.style.display = '');
}


    document.addEventListener('DOMContentLoaded', function () {
    const filterElement = document.getElementById('complaintFilter');
    const complaintTables = document.querySelectorAll('.complaint-table');

    // Function to filter tables
    const filterComplaints = () => {
        const filterValue = filterElement.value;

        complaintTables.forEach(table => {
            table.style.display = 'none'; // Hide all tables first
        });

        if (filterValue === 'sdc') {
            document.getElementById('sdcComplaints').style.display = 'block';
        } else if (filterValue === 'resolved') {
            document.getElementById('resolvedComplaints').style.display = 'block';
        } else if (filterValue === 'unresolved') {
            document.getElementById('unresolvedComplaints').style.display = 'block';
        } else {
            // Show all if "All Complaints" is selected
            complaintTables.forEach(table => {
                table.style.display = 'block';
            });
        }
    };

    // Event listener for the filter dropdown
    filterElement.addEventListener('change', filterComplaints);

    // Initial call to filter the complaints
    filterComplaints();
});

</script>

<?php $this->view('includes/footer'); ?>
