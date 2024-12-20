<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<style>
 /* Calendar Container */
.calendar-container {
    border-radius: 10px;
    background-color: #fdfdfd;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

#calendar-header h4 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
}

#prev-month, #next-month {
    border-radius: 50%;
    width: 35px;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: bold;
    font-size: 1.2rem;
}

.calendar-table th {
    font-size: 1rem;
    font-weight: 600;
    color: #666;
    padding: 10px;
    text-align: center;
    background-color: #f5f5f5;
}

.calendar-table td {
    text-align: center;
    padding: 15px;
    font-size: 1rem;
    color: #333;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.calendar-table td:hover {
    background-color: #dce3f7;
    border-radius: 10px;
}

.calendar-table td.selected {
    background-color: #6c5ce7;
    color: white;
    border-radius: 50%;
}

.calendar-table td.disabled {
    color: #bbb;
}

.calendar-table td.today {
    font-weight: bold;
    color: #2d3436;
    background-color: #fab1a0;
    border-radius: 10px;
}

/* Calendar Search Bar */
/* Calendar Search Bar */
#calendar-search {
    position: relative;
}

#calendar-search input {
    border-radius: 20px;
    padding: 10px 15px 10px 40px; /* Extra left padding for the icon */
    font-size: 1rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border: 1px solid #ddd;
    transition: all 0.3s ease;
    width: 100%;
}

#calendar-search input:focus {
    border-color: #6c5ce7;
    outline: none;
    box-shadow: 0 2px 8px rgba(108, 92, 231, 0.5);
}

/* Search Icon inside the Search Bar */
#calendar-search .search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.2rem;
    color: #6c5ce7;
}

#calendar-search input::placeholder {
    color: #aaa;
}


/* Icon Style */
.search-btn i {
    font-size: 1.2rem;
}

/* Responsive for mobile */
@media (max-width: 768px) {
    #calendar-header h4 {
        font-size: 1.2rem;
    }

    .calendar-table th, .calendar-table td {
        padding: 8px;
        font-size: 0.9rem;
    }
}

.user-schedule {
  margin-top: 20px;
  padding: 20px;
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.user-schedule h5 {
  margin-top: 0;
  font-weight: bold;
  color: #333;
}

.table {
  margin-bottom: 0;
}

.table thead th {
  background-color: #f5f5f5;
  border-bottom: 2px solid #ddd;
  font-weight: bold;
  text-align: center;
}

.table tbody td {
  text-align: center;
  vertical-align: middle;
}

.table-striped tbody tr:nth-child(even) {
  background-color: #f5f5f5;
}

.table-bordered {
  border: 1px solid #ddd;
}

.table-bordered th, .table-bordered td {
  border: 1px solid #ddd;
}


</style>

<?php
$year_level_id = $_GET['year_level_id'] ?? null;

// Format the year level using your function
$formatted_year_level = formatYearLevel($year_level_id);
?>
<div style="margin-left: -150px">
<div class="row dashboard-container mx-auto" style="width: 1650px;">
    <div class="row">
        <div class="col-8">
    <div class="card shadow p-5 rounded" style="height: 820px; overflow-y: auto;">

    <center><h4>Add a Complaint</h4></center>
    <form action="<?= ROOT ?>/forms?user_id=<?= $_GET['user_id'] ?>&year_level_id=<?= $_GET['year_level_id'] ?>&course=<?= $_GET['course'] ?>" method="post" id="complaint-form" class="needs-validation" novalidate>
    <input type="hidden" id="user_id" name="user_id" value="<?= htmlspecialchars(ucwords(str_replace('.', ' ', $_GET['user_id']))) ?>">
    <input type="hidden" id="year_level_id" name="year_level_id" value="<?= $formatted_year_level ?>">
    <input type="hidden" id="course" name="course" value="<?= htmlspecialchars($_GET['course']) ?>">

<fieldset class="step active">
    <legend class="font-weight-bold" style="font-size: 15px;">Type of Complaint <i style="color: red;">*</i></legend>
    <div class="mb-4">
    
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="complaint" value="Student against Student" id="type1" style="border-color: red;" required>
        <label class="form-check-label" for="type1">
            Student against another Student
        </label>
    </div>
    <?php if (Auth::isStudent()): ?>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="complaint" value="Student against Faculty" id="type2" style="border-color: red;">
        <label class="form-check-label" for="type2">
            Student against Faculty/Staff/Administrator
        </label>
    </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="complaint" value="Faculty/Staff/Administrator against Student" id="type3">
            <label class="form-check-label" for="type3">Faculty/Staff/Administrator against Student</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="complaint" value="School against Student" id="type4">
            <label class="form-check-label" for="type4">School against Student</label>
        </div>
        <?php endif ?>
        <div class="invalid-feedback">Please select the type of complaint.</div>
    </div>
</fieldset>                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-dark text-white text-center">
                            <tr>
                                <th class="text-dark" colspan="2" style="text-align: center;">Respondent Information</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <label for="resp_name">Name <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="resp_name" id="resp_name" autocomplete="off" required>
                                    <div id="student-name-list" class="dropdown-menu"></div>
                                    <div class="invalid-feedback">Please enter the name.</div>
                                </td>
                                <td>
                                    <label for="resp_id">Student ID No. <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="resp_id" id="resp_id" autocomplete="off" required>
                                    <div id="student-id-list" class="dropdown-menu"></div>
                                    <div class="invalid-feedback">Please enter a student ID.</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="resp_course_year">Course/Year <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="resp_course_year" id="resp_course_year" autocomplete="off"  required>
                                </td>
                                <td>
                                    <label for="resp_phone">Phone Number <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="resp_phone" id="resp_phone" autocomplete="off" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="resp_address">Home Address <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="resp_address" id="resp_address" autocomplete="off">
                                </td>
                                <td>
                                    <label for="resp_email">e-Mail Address <b style="color: red;">*</b></label>
                                    <input type="email" class="form-control" name="resp_email" id="resp_email" autocomplete="on" required>
                                    <div id="student-email-list" class="dropdown-menu"></div>
                                </td>
                            </tr>
                            <tr>
                            <td> 
                                    <label for="date" required>Date Filed <b style="color: red;">*</b></label>
                                    <input type="date" class="form-control" name="date" id="date">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Violations Committed -->
                <legend class="font-weight-bold" style="font-size: 15px;">Violation Committed: <b style="color: red;">*</b></legend>
                <div class="form-group mb-4">
                    <select class="form-control" name="violations" id="violations" required>
                        <option value="" disabled selected>Select Violation</option>
                        <?php foreach($violations as $violation): ?>
                            <option value="<?= $violation->violation ?>"><?= $violation->violation ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Please select a violation.</div>
                </div>

                <!-- Evidence Section -->
                 <div class="row">
                    <div class="col-md-6">
                <legend class="font-weight-bold" style="font-size: 15px;">Do you have any evidence(s)? <b style="color: red;">*</b></legend>
                <div class="form-group mb-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="evidence" value="yes" id="evidence_yes" style="border-color: black;">
                        <label class="form-check-label" for="evidence_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="evidence" value="no" id="evidence_no" style="border-color: black;">
                        <label class="form-check-label" for="evidence_no">No</label>
                    </div>
                    <p class="small text-muted">If yes, please present it to the Prefect of Students.</p>
                </div>
                    </div>

                <!-- Witnesses Section -->
                 <div class="col-md-6">
                <legend class="font-weight-bold" style="font-size: 15px;">Do you have any witness? <b style="color: red;">*</b></legend>
                <div class="form-group mb-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="witness" value="yes" id="witness_yes" style="border-color: black;">
                        <label class="form-check-label" for="witness_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="witness" value="no" id="witness_no" style="border-color: black;">
                        <label class="form-check-label" for="witness_no">No</label>
                    </div>
                    <p class="small text-muted">If yes, please provide the following:</p>
                </div>
                 </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>
                                        <label for="wit_name">Witness Name</label>
                                        <input type="text" class="form-control" name="wit_name" id="wit_name" disabled>
                                    </td>
                                    <td>
                                        <label for="wit_contact">Witness Contact No.</label>
                                        <input type="text" class="form-control" name="wit_contact" id="wit_contact" disabled>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                    <legend class="font-weight-bold" style="font-size: 15px;">Appointment Scheduling: <b style="color: red;">*</b></legend>
                    <div class="col-md-6">
                    <td>
                                    <label for="appt_date" required>Date</label>
                                    <input type="date" class="form-control" name="appt_date" id="appt_date">
                                </td>
                    </div>
                    <div class="col-md-6">
                                <td>
                                    <label for="appt_time">Time</label>
                                    <input type="time" class="form-control" name="appt_time" id="appt_time" autocomplete="off">
                                </td>
                    </div>
                                </div>
                 </div>
                

                <!-- Submit Button -->
                <div class="d-flex justify-content-center" style="margin-top: 20px;">
                <button type="submit" id="submit-complaint-button" class="btn btn-primary">Submit</button>
                </div>
            </fieldset>
        </form>
    </div>
        </div>

        

        <script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('complaint-form').addEventListener('submit', function(event) {
        let isValid = true; // Track overall form validity

        // Validate complaint type
        const complaint = document.querySelector('input[name="complaint"]:checked');
        if (!complaint) {
            isValid = false;
            document.querySelector('.invalid-feedback').style.display = 'block';
        } else {
            document.querySelector('.invalid-feedback').style.display = 'none';
        }

        // Validate respondent name
        const respName = document.getElementById('resp_name');
        if (!respName.value.trim()) {
            isValid = false;
            respName.classList.add('is-invalid');
            respName.nextElementSibling.style.display = 'block';
        } else {
            respName.classList.remove('is-invalid');
            respName.nextElementSibling.style.display = 'none';
        }

         // Validate violations committed
         const violations = document.getElementById('violations');
        if (!violations.value) {
            isValid = false;
            violations.classList.add('is-invalid');
            violations.nextElementSibling.style.display = 'block';
        } else {
            violations.classList.remove('is-invalid');
            violations.nextElementSibling.style.display = 'none';
        }

        if (isValid) {
        printReport(); // Call the print function if the form is valid
    }
    });
});
function printReport() {
    // Gather data from the form
    const complaintType = document.querySelector('input[name="complaint"]:checked').nextSibling.textContent;
    const respName = document.getElementById('resp_name').value;
    const yearLevel = document.getElementById('year_level_id').value;
    const course = document.getElementById('course').value;
    const userId = document.getElementById('user_id').value;
    const respId = document.getElementById('resp_id').value;
    const respCourseYear = document.getElementById('resp_course_year').value;
    const respPhone = document.getElementById('resp_phone').value;
    const respAddress = document.getElementById('resp_address').value;
    const respEmail = document.getElementById('resp_email').value;
    const dateFiled = document.getElementById('date').value;
    const violation = document.getElementById('violations').value;
    const evidence = document.querySelector('input[name="evidence"]:checked').value;
    const witness = document.querySelector('input[name="witness"]:checked').value;
    const apptDate = document.getElementById('appt_date').value;
    const apptTime = document.getElementById('appt_time').value;
    const formattedApptTime = formatTimeToAMPM(apptTime);
    const formattedDateFiled = formatDate(dateFiled);
    const formattedApptDate = formatDate(apptDate); // Format the appointment date

    // Generate a unique control number
    const controlNumber = generateControlNumber();

    // Create a new window for printing
    const printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Print Report</title>');
    
    // Link to Bootstrap CSS
    printWindow.document.write('</head><body>');

    // Add the header
    printWindow.document.write(`
         <div style="text-align: center; margin-bottom: 0;">
                <img src="assets/nbsc1.png" alt="University Logo" style="width: 100px; height: 95px; margin-right: 10px; float: left;">
                <img src="assets/nbsc1.png" alt="University Logo" style="width: 100px; height: 95px; margin-right: 10px; float: right;">
                <h4 style="margin-bottom: -20px;">Republic of the Philippines</h4>
                <h4 style="margin-bottom: -20px;"><b>NORTHERN BUKIDNON STATE COLLEGE</b></h4>
                <h4 style="margin-bottom: -20px;"><i>(Formerly Northern Bukidnon Community College)</i> R.A.11284</h4>
                <h4 style="margin-bottom: -5px;"><i>Creando futura, Transformationis vitae, Ductae a Deo</i></h4> 
                <hr>
            </div>
    `);

    // Add the report content wrapped in a div
    printWindow.document.write(`
        <div class="container">
        <br>
                    <p><strong>Date Filed: ${formattedDateFiled}</strong></p>
              <br>
                
                    <p><strong>Dear ${respName}</strong></p>
                
                
                    <p style="text-align: center"><strong>Subject: Notice to Report for </strong> ${respName} </p>
               
                    <p><strong>Good day!</strong></p>
                
                    <p><strong>In reference to Complaint Number ${controlNumber} filed by ${userId}, a ${yearLevel} year student of ${course} program.
                     I would like to request that your office require ${respName} to report to the Office of the Prefect of Students located at
                      the New Student Center Building on ${formattedApptDate} at exactly ${formattedApptTime} for initial inquiry into the case.</strong></p>

                      <p><strong>Should you have any questions, please do not hesitate to address it to this office.</strong></p>

                      <p ><strong>Thank you very much.</strong></p>
                      <p><strong>Respectfully.</strong></p>

                      <br>

                      <hr style="width: 100px; font-weight: bold; text-align: start">
                      <p><strong>Prefect of Students</strong></p>
                </div>
    `);

    printWindow.document.write('</body></html>');
    
    printWindow.document.close(); // Close the document

    // Trigger the print dialog
    printWindow.print();

    // Close the print window after printing
    printWindow.onafterprint = function () {
        printWindow.close();
    };
}

function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', options); // Format the date
}

function formatTimeToAMPM(time) {
    const [hour, minute] = time.split(':');
    const formattedHour = hour % 12 || 12; // Convert to 12-hour format
    const ampm = hour >= 12 ? 'PM' : 'AM'; // Determine AM or PM
    return `${formattedHour}:${minute} ${ampm}`; // Return formatted time
}

// Function to generate a unique control number
function generateControlNumber() {
    const timestamp = Date.now(); // Get the current timestamp
    const randomNum = Math.floor(Math.random() * 10000); // Generate a random number
    return `CN-${timestamp}-${randomNum}`; // Format the control number as CN-timestamp-randomNumber
}
</script>

        <!--calendar column-->
        <div class="col-4">
        <!-- Search input -->
            <div id="calendar" class="calendar-container p-4 shadow rounded" style="height: 410px">
                <div id="calendar-header" class="d-flex justify-content-between align-items-center">
                <button id="prev-month" class="btn btn-outline-primary"><i class="fas fa-chevron-left"></i></button>
                    <h4 id="calendar-month" class="m-0">September 2024</h4>
                    <button id="next-month" class="btn btn-outline-primary"><i class="fas fa-chevron-right"></i></button>
                </div>
                <table class="table calendar-table mt-3">
                    <thead>
                        <tr>
                            <th>Sun</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                        </tr>
                    </thead>
                    <tbody id="calendar-body">
                        <!-- Calendar days will be dynamically generated here -->
                    </tbody>
                </table>
            </div>
            <div class="user-schedule bg-white" style="height: 410px; overflow-y: auto">
  <h5>Appointments Scheduled this Week</h5>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Complainant</th>
        <th>Respondent</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php foreach ($appointmentsThisWeek as $user): ?>
    <?php if ($user->status === 'Unresolved'): ?>
        <tr>
            <td><?= ucwords(str_replace(".", " ", $user->user_id)) ?></td>
            <td><?= $user->resp_name?></td>
            <td><?= get_date($user->appt_date)?></td>
            <td><?= date('g:i A', strtotime($user->appt_time)) ?></td>
            <td><?= $user->status?></td>
        </tr>
    <?php endif; ?>
<?php endforeach; ?>
</tbody>
</div>
    </div>
    </div>
</div>
</div>

<script>

document.addEventListener('DOMContentLoaded', function() {
    const witnessYes = document.getElementById('witness_yes');
    const witnessNo = document.getElementById('witness_no');
    const witName = document.getElementById('wit_name');
    const witContact = document.getElementById('wit_contact');

    function toggleWitnessFields() {
        if (witnessYes.checked) {
            witName.disabled = false;
            witContact.disabled = false;
        } else if (witnessNo.checked) {
            witName.disabled = true;
            witContact.disabled = true;
        }
    }

    witnessYes.addEventListener('change', toggleWitnessFields);
    witnessNo.addEventListener('change', toggleWitnessFields);

    // Initialize the fields based on the default radio button state
    toggleWitnessFields();
});

document.getElementById('resp_name').addEventListener('keyup', function() {
    var searchTerm = this.value;

    if (searchTerm.length > 1) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '<?= ROOT ?>/forms/getStudentName?term=' + searchTerm, true);
        xhr.onload = function() {
            if (this.status === 200) {
                var results = JSON.parse(this.responseText);
                var suggestions = '';
                if (results.length > 0) {
                    results.forEach(function(result) {
                        suggestions += '<div class="dropdown-item" onclick="setStudentName(\'' + result.firstname + ' ' + result.lastname + '\', ' + result.std_id + ', \'' + result.email + '\', \'' + result.phone + '\', \'' + result.street + '\', \'' + result.barangay + '\', \'' + result.city + '\', \'' + result.municipality + '\', \'' + result.year_level + '\', \'' + result.course + '\')">' + result.firstname + ' ' + result.lastname + '</div>';
                    });
                    document.getElementById('student-name-list').style.display = 'block';
                    
                } else {
                    document.getElementById('student-name-list').style.display = 'none';
                }
                document.getElementById('student-name-list').innerHTML = suggestions;
            }
        };
        xhr.send();
    } else {
        document.getElementById('student-name-list').style.display = 'none';
    }
});

function setStudentName(fullname, std_id, email, phone, street, barangay, city, municipality, year_level, course) {
    document.getElementById('resp_name').value = fullname;
    document.getElementById('resp_id').value = std_id;
    document.getElementById('resp_email').value = email;
    document.getElementById('resp_phone').value = phone;
    document.getElementById('resp_address').value = street + ' ' + barangay + ' ' + city + ' ' + municipality;
    document.getElementById('resp_course_year').value = course + ' - ' + year_level;

    document.getElementById('student-name-list').style.display = 'none';
   
}





document.addEventListener('DOMContentLoaded', function () {
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    let currentDate = new Date();

    const calendarMonth = document.getElementById('calendar-month');
    const calendarBody = document.getElementById('calendar-body');

    function renderCalendar() {
        calendarBody.innerHTML = '';
        let firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
        let lastDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
        calendarMonth.innerText = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

        let row = document.createElement('tr');
        for (let i = 0; i < firstDay; i++) {
            let cell = document.createElement('td');
            cell.classList.add('disabled');
            row.appendChild(cell);
        }

        for (let day = 1; day <= lastDate; day++) {
            if (row.children.length === 7) {
                calendarBody.appendChild(row);
                row = document.createElement('tr');
            }

            let cell = document.createElement('td');
            cell.innerText = day;
            if (day === new Date().getDate() && currentDate.getMonth() === new Date().getMonth()) {
                cell.classList.add('today');
            }
            cell.addEventListener('click', function () {
                document.querySelectorAll('.calendar-table td').forEach(td => td.classList.remove('selected'));
                cell.classList.add('selected');
            });
            row.appendChild(cell);
        }
        calendarBody.appendChild(row);
    }

    document.getElementById('prev-month').addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    document.getElementById('next-month').addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    renderCalendar();
});




</script>

<?php $this->view('includes/footer'); ?>
