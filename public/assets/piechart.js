
function createPieChart(pieLabels, pieData) {
var ctxPie = document.getElementById('pieChart').getContext('2d');

// Define vibrant colors for the chart
var colors = [
  'rgba(28, 200, 138, 0.9)', // Green
  'rgba(54, 185, 204, 0.9)', // Blue
  'rgba(246, 194, 62, 0.9)', // Yellow
  'rgba(231, 74, 59, 0.9)'   // Red
];

var hoverColors = [
  'rgba(28, 200, 138, 1)',
  'rgba(54, 185, 204, 1)',
  'rgba(246, 194, 62, 1)',
  'rgba(231, 74, 59, 1)'
];

// Calculate total percentage
var totalValue = pieData.reduce((acc, val) => acc + val, 0);
var totalPercentage = 100; // Since we're displaying the entire chart

var pieChart = new Chart(ctxPie, {
  type: 'pie',
  data: {
    labels: pieLabels,
    datasets: [{
      data: pieData,
      backgroundColor: colors,
      hoverBackgroundColor: hoverColors,
      borderWidth: 2, // Thicker border to make it pop
      borderColor: '#fff' // White border for separation between slices
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'top', // Keep legend on top for better layout
        labels: {
          color: '#5a5c69', // Text color
          font: {
            size: 14, // Font size
            weight: 'bold' // Bold for readability
          }
        }
      },
      tooltip: {
        backgroundColor: 'rgba(255, 255, 255, 0.9)', // Light tooltip background
        titleColor: '#333', // Darker title
        bodyColor: '#666', // Subtle body color
        borderColor: '#ddd', // Light border
        borderWidth: 1,
        caretSize: 6, // Caret size for clarity
        padding: 12, // Padding for better tooltip spacing
        callbacks: {
          label: function(tooltipItem) {
            var percentage = (tooltipItem.raw / totalValue * 100).toFixed(2);
            return `${tooltipItem.label}: ${percentage}%`;
          }
        }
      }
    },
    cutout: '60%', // Larger hole for a modern look
    elements: {
      arc: {
        borderWidth: 0, // Cleaner look by default
        hoverBorderWidth: 2, // Slight border on hover for emphasis
        hoverBorderColor: '#fff', // White hover border for slice contrast
        shadowOffsetX: 0,
        shadowOffsetY: 0,
        shadowBlur: 12, // Soft shadow for a 3D effect
        shadowColor: 'rgba(0, 0, 0, 0.15)' // Light shadow color
      }
    },
    animation: {
      animateScale: true, // Scale animation for smooth entry
      animateRotate: true // Rotation animation for smooth transition
    }
  },
  plugins: []
});
}