<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<style>
 /* Global Styles */



</style>

<div class="container mt-5">
    <div class="form-container bg-light p-5 shadow rounded">
        <form action="<?= ROOT ?>/forms?user_id=<?= $_GET['user_id'] ?>" method="post" id="complaint-form" class="needs-validation" novalidate>
            <h2 class="mb-4 text-center">Complaint Form</h2>

            <!-- Step 1: Type of Complaints -->
            <fieldset class="step active">
                <legend class="font-weight-bold">Type of Complaint</legend>
                <div class="form-group mb-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="complaint" value="Student against Student" id="type1">
                        <label class="form-check-label" for="type1">Student against another Student</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="complaint" value="Student against Faculty" id="type2">
                        <label class="form-check-label" for="type2">Student against Faculty/Staff/Administrator</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="complaint" value="Faculty/Staff/Administrator against Student" id="type3">
                        <label class="form-check-label" for="type3">Faculty/Staff/Administrator against Student</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="complaint" value="School against Student" id="type4">
                        <label class="form-check-label" for="type4">School against Student</label>
                    </div>
                    <div class="invalid-feedback">Please select the type of complaint.</div>
                </div>

                <!-- Respondent Information -->
                <legend class="font-weight-bold">Respondent Information</legend>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-secondary text-white text-center">
                            <tr>
                                <th colspan="2" style="color: white; text-align: center;">Respondent Information</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <label for="resp_id">Student ID No.</label>
                                    <input type="text" class="form-control" name="resp_id" id="resp_id" autocomplete="off" required>
                                    <div id="student-id-list" class="dropdown-menu"></div>
                                    <div class="invalid-feedback">Please enter a student ID.</div>
                                </td>
                                <td>
                                    <label for="resp_name">Name</label>
                                    <input type="text" class="form-control" name="resp_name" id="resp_name" autocomplete="off" required>
                                    <div class="invalid-feedback">Please enter the name.</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="resp_course_year">Course/Year</label>
                                    <input type="text" class="form-control" name="resp_course_year" id="resp_course_year" autocomplete="off">
                                </td>
                                <td>
                                    <label for="resp_phone">Phone Number</label>
                                    <input type="text" class="form-control" name="resp_phone" id="resp_phone" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="resp_address">Home Address</label>
                                    <input type="text" class="form-control" name="resp_address" id="resp_address" autocomplete="off">
                                </td>
                                <td>
                                    <label for="resp_email">e-Mail Address</label>
                                    <input type="email" class="form-control" name="resp_email" id="resp_email" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                            <td>
                                    <label for="date">Date</label>
                                    <input type="date" class="form-control" name="date" id="date">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Violations Committed -->
                <legend class="font-weight-bold">Violations Committed</legend>
                <div class="form-group mb-4">
                    <select class="form-control" name="violations" id="violations" required>
                        <option value="" disabled selected>Select Violation</option>
                        <?php foreach($violations as $violation): ?>
                            <option value="<?= $violation->id ?>"><?= $violation->violation ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Please select a violation.</div>
                </div>

                <!-- Evidence Section -->
                <legend class="font-weight-bold">Do you have any evidences?</legend>
                <div class="form-group mb-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="evidence" value="yes" id="evidence_yes">
                        <label class="form-check-label" for="evidence_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="evidence" value="no" id="evidence_no">
                        <label class="form-check-label" for="evidence_no">No</label>
                    </div>
                    <p class="small text-muted">If yes, please submit it to the Prefect of Students.</p>
                </div>

                <!-- Witnesses Section -->
                <legend class="font-weight-bold">Do you have any witnesses?</legend>
                <div class="form-group mb-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="witness" value="yes" id="witness_yes">
                        <label class="form-check-label" for="witness_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="witness" value="no" id="witness_no">
                        <label class="form-check-label" for="witness_no">No</label>
                    </div>
                    <p class="small text-muted">If yes, please provide the following:</p>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>
                                        <label for="wit_name">Name</label>
                                        <input type="text" class="form-control" name="wit_name" id="wit_name" disabled>
                                    </td>
                                    <td>
                                        <label for="wit_contact">Contact No.</label>
                                        <input type="text" class="form-control" name="wit_contact" id="wit_contact" disabled>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                </div>
            </fieldset>
        </form>
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


document.getElementById('resp_id').addEventListener('keyup', function() {
    var searchTerm = this.value;

    if (searchTerm.length > 1) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '<?= ROOT ?>/forms/getStudentIds?term=' + searchTerm, true);
        xhr.onload = function() {
            if (this.status === 200) {
                var results = JSON.parse(this.responseText);
                var suggestions = '';
                if (results.length > 0) {
                    results.forEach(function(result) {
                        suggestions += '<div class="dropdown-item" onclick="setStudentId(\'' + result.std_id + '\')">' + result.std_id + '</div>';
                    });
                    document.getElementById('student-id-list').style.display = 'block';
                } else {
                    document.getElementById('student-id-list').style.display = 'none';
                }
                document.getElementById('student-id-list').innerHTML = suggestions;
            }
        };
        xhr.send();
    } else {
        document.getElementById('student-id-list').style.display = 'none';
    }
});

function setStudentId(std_id) {
    document.getElementById('resp_id').value = std_id;
    document.getElementById('student-id-list').style.display = 'none';

    // Perform an AJAX request to get the respondent details
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '<?= ROOT ?>/forms/getRespondentDetails?std_id=' + std_id, true);
    xhr.onload = function() {
        if (this.status === 200) {
            var details = JSON.parse(this.responseText);
            if (details) {
                // Fill in the respondent's information
                document.getElementById('resp_name').value = details.resp_name || '';
                document.getElementById('resp_course_year').value = details.resp_course_year || '';
                document.getElementById('resp_phone').value = details.resp_phone || '';
                document.getElementById('resp_address').value = details.resp_address || '';
                document.getElementById('resp_email').value = details.resp_email || '';
            }
        }
    };
    xhr.send();
}

function setStudentId(std_id) {
    document.getElementById('resp_id').value = std_id;
    document.getElementById('student-id-list').style.display = 'none';

    // Perform an AJAX request to get the respondent's details (firstname and lastname)
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '<?= ROOT ?>/forms/getRespondentDetails?std_id=' + std_id, true);
    xhr.onload = function() {
        if (this.status === 200) {
            var details = JSON.parse(this.responseText);
            if (details) {
               
                // Fill in the resp_name field with both firstname and lastname
                document.getElementById('resp_name').value = (details.firstname || '') + ' ' + (details.lastname || '');

                document.getElementById('resp_email').value = details.email || '';

                document.getElementById('resp_course_year').value = (details.course || '') + ' - ' + (details.year_level || '') + ' year ';

                document.getElementById('resp_phone').value = details.phone || '';

                document.getElementById('resp_address').value = (details.street || '')+ ' ' + (details.barangay || '')+ ' ' + (details.city || '')+ ' ' + (details.municipality || '');
            }
        }
    };
    xhr.send();
}


</script>

<?php $this->view('includes/footer'); ?>
