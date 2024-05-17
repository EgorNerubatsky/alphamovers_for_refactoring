
//   var ctx = document.getElementById('myChart2').getContext('2d');
  
//   var myChart = new Chart(ctx, {
//   type: 'line',
//   data: {
//     labels: {!! isset(_$labels) ? json_encode($labels) : 'null' !!},
//     datasets: [{
//       label: 'Замовлення',
//       data: {!! isset(_$data) ? json_encode($data) : 'null' !!},
//       backgroundColor: 'rgba(75, 192, 192, 0.2)',
//       borderColor: 'rgba(75, 192, 192, 1)',
//       borderWidth: 1
//     },
//     {
       
//       label: 'Залишок компанії',
//       data: {!! isset(_$balance) ? json_encode($balance) : 'null' !!},
//       backgroundColor: 'rgba(255, 99, 132, 0.2)',
//       borderColor: 'rgba(255, 99, 132, 1)',
//       borderWidth: 1
//       }]
//   },
//   options: {
//     scales: {
//       y: {
//         beginAtZero: true
//       }
//     }
//   }
// });


// var ctx = document.getElementById('myChart3').getContext('2d');
  
//   // Создайте график
//   var myChart = new Chart(ctx, {
//     type: 'line',
//     data: {
//       labels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн'],
//       datasets: [{
//         label: 'Замовлення',
//         data: [12, 19, 3, 5, 2, 3],
//         backgroundColor: 'rgba(75, 192, 192, 0.2)',
//         borderColor: 'rgba(75, 192, 192, 1)',
//         borderWidth: 1
//       },
//       {
//         label: 'Залишок компанії',
//         data: [8, 12, 5, 10, 6, 8],
//         backgroundColor: 'rgba(255, 99, 132, 0.2)',
//         borderColor: 'rgba(255, 99, 132, 1)',
//         borderWidth: 1
//       }]
//     },
//     options: {
//       scales: {
//         y: {
//           beginAtZero: true
//         }
//       }
//     }
//   });




// var ctx = document.getElementById('myChart3').getContext('2d');

// // Создайте график
// var myChart = new Chart(ctx, {
//     type: 'line',
//     data: {
//         labels: @json($labels),
//         datasets: [
//             {
//                 label: 'Замовлення',
//                 data: @json($data),
//                 backgroundColor: 'rgba(75, 192, 192, 0.2)',
//                 borderColor: 'rgba(75, 192, 192, 1)',
//                 borderWidth: 1
//             },
//             {
//                 label: 'Залишок компанії',
//                 data: @json($balance),
//                 backgroundColor: 'rgba(255, 99, 132, 0.2)',
//                 borderColor: 'rgba(255, 99, 132, 1)',
//                 borderWidth: 1
//             }
//         ]
//     },
//     options: {
//         scales: {
//             y: {
//                 beginAtZero: true
//             }
//         }
//     }
// });



// In your TypeScript file
var ctx = document.getElementById('myChart3').getContext('2d');

// Create a chart
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: window.chartData.labels,
        datasets: [
            {
                label: 'Замовлення',
                data: window.chartData.data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: 'Залишок компанії',
                data: window.chartData.balance,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});


var ctx = document.getElementById('myChart4').getContext('2d');

// Create a chart
var myChart = new Chart(ctx, {
    type: 'polarArea',
    data: {
        labels: window.chartData.labels,
        datasets: [
            {
                label: 'Замовлення',
                data: window.chartData.data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: 'Залишок компанії',
                data: window.chartData.balance,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});







// displaying file names in fields
function updateFileName(input, labelId) {
  var fileName = input.files[0].name;
  document.getElementById(labelId).innerHTML = fileName;
}

function toggleExecutionDateRequired(input) {
}

