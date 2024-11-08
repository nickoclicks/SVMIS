<style>
/* Global Styles */

/* Global Styles */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Open Sans', sans-serif;
    font-size: 16px;
    line-height: 1.5;
    color: #333;
    background-color: #f9f9f9;
}

h1, h2, h3, h4, h5, h6 {
    font-weight: bold;
    color: #333;
}

h1 {
    font-size: 36px;
    margin-bottom: 20px;
}

h2 {
    font-size: 24px;
    margin-bottom: 15px;
}

h3 {
    font-size: 18px;
    margin-bottom: 10px;
}

h4 {
    font-size: 16px;
    margin-bottom: 5px;
}

h5 {
    font-size: 14px;
    margin-bottom: 5px;
}

h6 {
    font-size: 12px;
    margin-bottom: 5px;
}

/* Dashboard Container */
.dashboard-container {
    max-width: 1650px;
    margin: 40px auto;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Card Styles */


.card-body {
    font-family: 'Open Sans', sans-serif;
}

.card-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}

.card-text {
    font-size: 14px;
    color: #666;
    margin-bottom: 20px;
}

/* Table Styles */
table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 20px;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

/* Print Header Styles */
.print-header {
    text-align: center;
    margin-bottom: 20px;
}

.print-header img {
    width: 100px;
    height: 95px;
    margin-right: 10px;
    float: left;
}

.print-header h4 {
    margin-bottom: -20px;
}

.print-header hr {
    margin-top: 0;
}

/* No Print Styles */
.no-print {
    display: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-container {
        margin: 20px;
    }
}

@media (max-width: 480px) {
    .dashboard-container {
        margin: 10px;
    }
    .card {
        margin: 10px;
    }
}

/* Button Styles */
.print-button {
    position: absolute;
    top: 60px;
    right: 45px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 10%;
    transition: background-color 0.3s;
}

.print-button:hover {
    background-color: #3e8e41;
}

.print-button i {
    margin-right: 5px;
}

.btn {
    background-color: #007bff; /* Primary color */
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    transition: background-color 0.3s, transform 0.2s;
}

.btn:hover {
    background-color: #0056b3; /* Darker shade */
    transform: translateY(-2px); /* Lift effect */
}

/* Enhanced Chart Styles */


canvas {
    border-radius: 10px; /* Rounded corners for charts */
}

/* Utility Classes */
.text-light {
    color: #ffffff; /* Light text color for table headers */
}

.bg-dark {
    background-color: #343a40; /* Dark background for table headers */
}
/* Button Styles */
.btn {
    background-color: #007bff; /* Primary color */
    color: white;
    border: none;
    border-radius: 5px;
    padding: 12px 24px; /* Increased padding for a more substantial look */
    font-size: 16px; /* Increased font size for better readability */
    font-weight: 600; /* Bold font for emphasis */
    text-transform: uppercase; /* Uppercase text for a modern touch */
    letter-spacing: 1px; /* Spacing between letters for a cleaner look */
    transition: background-color 0.3s, transform 0.2s, box-shadow 0.3s; /* Smooth transitions */
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}

.btn:hover {
    background-color: #0056b3; /* Darker shade on hover */
    transform: translateY(-2px); /* Lift effect on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Enhanced shadow on hover */
}

.btn:active {
    transform: translateY(1px); /* Pressed effect */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Reduced shadow when pressed */
}

/* Additional styles for specific button types */
.btn-secondary {
    background-color: #6c757d; /* Secondary color */
}

.btn-secondary:hover {
    background-color: #5a6268; /* Darker shade for secondary button on hover */
}
/* Input and Select Styles */
.form-control, .form-select {
    border: 1px solid #ddd; /* Light border */
    border-radius: 5px; /* Rounded corners */
    padding: 10px 15px; /* Padding for comfort */
    font-size: 16px; /* Font size for readability */
    transition: border-color 0.3s, box-shadow 0.3s; /* Smooth transitions */
}

.form-control:focus, .form-select:focus {
    border-color: #007bff; /* Primary color on focus */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Subtle shadow effect on focus */
}

/* Label Styles */
.form-label {
    font-weight: bold; /* Bold labels for emphasis */
    margin-bottom: 5px; /* Spacing below labels */
    color: #333; /* Dark color for labels */
}

/* Button Styles for Filter Submission */
.filter-btn {
    background-color: #007bff; /* Primary color */
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px; /* Padding for comfort */
    font-size: 16px; /* Font size for readability */
    font-weight: 600; /* Bold font for emphasis */
    text-transform: uppercase; /* Uppercase text for a modern touch */
    letter-spacing: 1px; /* Spacing between letters for a cleaner look */
    transition: background-color 0.3s, transform 0.2s, box-shadow 0.3s; /* Smooth transitions */
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}

.filter-btn:hover {
    background-color: #0056b3; /* Darker shade on hover */
    transform: translateY(-2px); /* Lift effect on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Enhanced shadow on hover */
}

.filter-btn:active {
    transform: translateY(1px); /* Pressed effect */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Reduced shadow when pressed */
}
</style>



<center style="margin-bottom: 20px;">
<a href="reports" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black; width: 270px">Violation</a>
<a href="sdcs" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black; width: 270px">Notice</a>
<a href="goodmoral" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black; width: 270px">Certificate Report</a>
<a href="comparative" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black; width: 270px">Comparative Analysis</a>
</center>
<center><h2 style="font-size: 18px;">Violation Report</h2>
<h3>Total: <?php echo count($recentViolators); ?></h3>   
</center>
