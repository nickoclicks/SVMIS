<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<style>
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
</style>
<div class="dashboard-container mt-4" style="background: linear-gradient(135deg, #ffffff, #f9f9f9); max-width: 1650px; margin: 40px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);">

    <a href="reports" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Violation</a>
    <a href="sdcs" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Notice</a>
    <a href="goodmoral" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Good Moral Report</a>
    <a href="comparative" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Comparative Analysis</a>

    <canvas id="violationsChart" width="400" height="200"></canvas>
    <script>
       const ctx = document.getElementById('violationsChart').getContext('2d');

// Days of the week from Monday to Sunday
const daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

// Initialize an array for total violations for each day
const violationsData = new Array(7).fill(0);

// Populate the violations data based on the query result
const violationsPerDay = <?= json_encode($violationsPerDay) ?>;
violationsPerDay.forEach(item => {
    const dayIndex = item.day_of_week - 1; // Adjust for zero-based index
    violationsData[dayIndex] = item.total_violations;
});

// Create a gradient for the chart background
const gradient = ctx.createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, 'rgba(75, 192, 192, 0.6)');
gradient.addColorStop(1, 'rgba(75, 192, 192, 0.2)');

const violationsChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: daysOfWeek,
        datasets: [{
            label: 'Total Violations per Day',
            data: violationsData,
            backgroundColor: gradient,
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2,
            hoverBackgroundColor: 'rgba(75, 192, 192, 0.8)',
            hoverBorderColor: 'rgba(75, 192, 192, 1)',
            borderRadius: 5,
            barPercentage: 0.6,
            categoryPercentage: 0.5,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Number of Violations',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                },
                grid: {
                    color: 'rgba(200, 200, 200, 0.5)',
                    lineWidth: 1
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Days of the Week',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                },
                grid: {
                    display: false
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    font: {
                        size: 14,
                        weight: 'bold'
                    },
                    boxWidth: 20,
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                callbacks: {
                    label: function(tooltipItem) {
                        return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
                    }
                }
            }
        }
    }
});
    </script>
<?php $this->view('includes/footer'); ?>