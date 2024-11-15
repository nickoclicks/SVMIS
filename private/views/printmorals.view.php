<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<style>
    /* Add print styles */
    @media print {
        input {
            display: none; /* Hide input fields during printing */
        }
        button {
            display: none; /* Hide the print button */
        }
        .footer {
            position: relative; /* Ensure footer stays in place */
        }
    }
</style>

<div style="margin-left: -150px;">
    <div id="printcontent">
        <div class="certificate-header" style="text-align: center;">
            <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                <div>
                    <h5 style="margin: 0;">Republic of the Philippines</h5>
                    <h4 style="font-weight: bold; margin: 0;">NORTHERN BUKIDNON STATE COLLEGE</h4>
                    <p style="margin: 0;">(Formerly Northern Bukidnon Community College)</p>
                    <p style="margin: 0;">Manolo Fortich, 8703 Bukidnon</p>
                    <p style="margin: 0;"><i>Creando futura, Transformationis vitae, Ductae a Deo</i></p>
                </div>
            </div>
            <hr>
        </div>  

        <div class="content" style="text-align: center; margin-top: 20px;">
            <h4 style="margin: 0;">Office of the Prefect of Students</h4>
            <br>
            <h3 style="margin: 0;">CERTIFICATION</h3>
            <br>
        </div>

        <div id="name" class="content" style="text-align: justify; margin: 20px; font-size: 18px;">
            <p style="font-weight: bold; font-size: 20px;">TO WHOM IT MAY CONCERN:</p>
            <p>
                This is to certify that 
                <span id="fullnameDisplay">&nbsp;</span>
                <input type="text" id="fullname" name="fullname" placeholder="Enter full name" style="border: none; border-bottom: 1px solid black; outline: none; width: 200px; background: transparent; margin: 0; padding: 0;" />
                a 
                <span id="year_level_display">&nbsp;</span>
                <select id="year_level" name="year_level" style="border: none; border-bottom: 1px solid black; outline: none; background: transparent; margin: 0; padding: 0; width: 80px;">
                    <option value="1st">1st</option>
                    <option value="2nd">2nd</option>
                    <option value="3rd">3rd</option>
                    <option value="4th">4th</option>
                    <option value="Graduate">Graduate</option>
                </select> 
                <span id="yearText">year student</span> 
                from this institution under the 
                <span id="program_display">&nbsp;</span>
                <select id="program" name="program" style="border: none; border-bottom: 1px solid black; outline: none; background: transparent; margin: 0; padding: 0; width: 80px;">
                    <option value="BSBA">BSBA</option>
                    <option value="BSIT">BSIT</option>
                    <option value="TEP">TEP</option>
                </select> 
                <span id="programText">program</span>, has consistently shown good moral conduct and character, complying with the rules and regulations set forth while in attendance at this institution.
            </p>
            <p>
                This certification is issued upon request of the above-mentioned student for 
                <span id="reason_display">&nbsp;</span>
                <input type="text" id="reason" name="reason" placeholder="Enter Reason" style="border: none; border-bottom: 1px solid black; outline: none; width: 200px; background: transparent; margin: 0; padding: 0 ;" /> purpose.
            </p>
            <p>
                Given on <span id="date_display">&nbsp;</span> at Northern Bukidnon State College, Kihare, Tankulan, Manolo Fortich, Bukidnon, Mindanao, Philippines.
            </p>
        </div>

        <div class="footer" style="text-align: end; position: relative; height: 150px;">
            <p style="display: inline-block; border-bottom: 1px solid black; width: 200px; margin-bottom: 0;">&nbsp;</p>
            <p style="margin-right: 25px;">Prefect of Discipline</p>
        </div>

        <div class="footer" style="text-align: start; position: relative; height: 150px;">
            <p style="margin-left:  40px;">Not Valid Without</p>
            <p style="margin-top: -20px; font-size: 20px;">OFFICIAL COLLEGE SEAL</p>
        </div>

    </div>

    

    <?php 

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the log name from the form submission
    $log_name = $_POST['log_name'];

    // Call the log_activity function to log the activity
    log_activity($log_name);

    // Now proceed to print the certificate
    // You can include your logic here to generate the certificate
    $currentDate = date('jS') . ' day of ' . date('F Y'); // Example date formatting
    // Render the certificate or handle the print logic here
    

}
?>

<form action="" method="POST">
<input type="hidden" name="log_name" value="Printed Good Moral Certificate for graduate">
    <div style="text-align: center; margin-top: 20px;">
        <button onclick="printDiv('printcontent')" style="padding:  10px 20px; font-size: 16px;">Print Certificate</button>
    </div>
</form>
</div>

<script>
  
</script>
<script>
function getCurrentDate() {
    var today = new Date();
    var options = { year: 'numeric', month: 'long', day: 'numeric' };
    return today.toLocaleDateString('en-US', options);
}

// Function to set today's date in the content
function setTodaysDate() {
    var currentDate = getCurrentDate();
    document.getElementById('date_display').textContent = currentDate;
}

window.onload = setTodaysDate; // Call the function when the page loads

function printDiv(divId) {
    // Get the input fields
    var fullnameInput = document.getElementById('fullname');
    var yearLevelInput = document.getElementById('year_level');
    var programInput = document.getElementById('program');
    var reasonInput = document.getElementById('reason');
    
    // Hide the input fields
    fullnameInput.style.display = 'none';
    yearLevelInput.style.display = 'none';
    programInput.style.display = 'none';
    reasonInput.style.display = 'none';

    // Get the input values
    var fullname = fullnameInput.value;
    var year = yearLevelInput.value;
    var program = programInput.value;
    var reason = reasonInput.value;

    // Update the corresponding spans with the input values
    document.getElementById('fullnameDisplay').textContent = fullname;
    document.getElementById('year_level_display').textContent = year;
    document.getElementById('program_display').textContent = program;
    document.getElementById('reason_display').textContent = reason;

    // Update the date span
    document.getElementById('date_display').textContent = getCurrentDate();

    // Create a new window for printing
    var printWindow = window.open('', '_blank', 'width=1200,height=800');
    printWindow.document.write('<html><head><title>Print</title>');
    printWindow.document.write('</head><body>');
    printWindow.document.write(document.getElementById(divId).innerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close(); // Close the document to finish loading
    printWindow.print(); // Trigger the print dialog
    printWindow.close(); // Close the print window

    // Show the input fields again
    fullnameInput.style.display = 'block';
    yearLevelInput.style.display = 'block';
    programInput.style.display = 'block';
    reasonInput.style.display = 'block';
}

// Add this function to handle the dropdown change
document.getElementById('year_level').addEventListener('change', function() {
    var yearText = document.getElementById('yearText'); // Reference to the "year" span
    if (this.value === 'Graduate') {
        yearText.style.display = 'none'; // Hide the word "year"
    } else {
        yearText.style.display = 'inline'; // Show the word "year"
    }
});
</script>

<?php $this->view('includes/footer'); ?>