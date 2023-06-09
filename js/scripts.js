/*!
    * Start Bootstrap - SB Admin v7.0.5 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2022 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

function create_chartRight(file_path, canvasId){
    fetch(file_path)
      .then(response => response.text())
      .then(data => {
        // Split the data into rows
        const rows = data.trim().split('\n');

        // Initialize arrays for each column
        const column1 = [];
        const column2 = [];
        const column3 = [];

        // Process each row and split into columns
        rows.forEach(row => {
          const columns = row.split(',');

          // Store values in respective columns
          column1.push(columns[0]);
          column2.push(columns[1]);
          column3.push(columns[2]);
        });

        // Create a chart using Chart.js
        const ctx = document.getElementById(canvasId).getContext('2d');
        new Chart(ctx, {
          type: 'line',
          data: {
            labels: Array.from({ length: column1.length }, (_, i) => i + 1),
            datasets: [
            {
                label: 'X Axis',
                data: column1,
                borderColor: 'red',
                fill: false
              },  
            {
                label: 'Y Axis',
                data: column2,
                borderColor: 'blue',
                fill: false
              },
              {
                label: 'Z Axis',
                data: column3,
                borderColor: 'green',
                fill: false
              }
            ]
          },
          options: {
            scales: {
              x: { 
                type: 'linear',
                display: true,
                beginAtZero: true
              },
              y: { 
                display: true
              }
            }
          }
        });
      })
      .catch(error => {
        console.log('Error:', error);
      });
}

function create_chartLeft(file_path, canvasId){
  fetch(file_path)
    .then(response => response.text())
    .then(data => {
      // Split the data into rows
      const rows = data.trim().split('\n');

      // Initialize arrays for each column
      const column1 = [];
      const column2 = [];
      const column3 = [];

      // Process each row and split into columns
      rows.forEach(row => {
        const columns = row.split(',');

        // Store values in respective columns
        column1.push(columns[3]);
        column2.push(columns[4]);
        column3.push(columns[5]);
      });

      // Create a chart using Chart.js
      const ctx = document.getElementById(canvasId).getContext('2d');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: Array.from({ length: column1.length }, (_, i) => i + 1),
          datasets: [
          {
              label: 'X Axis',
              data: column1,
              borderColor: 'red',
              fill: false
            },  
          {
              label: 'Y Axis',
              data: column2,
              borderColor: 'blue',
              fill: false
            },
            {
              label: 'Z Axis',
              data: column3,
              borderColor: 'green',
              fill: false
            }
          ]
        },
        options: {
          scales: {
            x: { 
              type: 'linear',
              display: true,
              beginAtZero: true
            },
            y: { 
              display: true
            }
          }
        }
      });
    })
    .catch(error => {
      console.log('Error:', error);
    });
}

function create_chart3D(file_path, canvasId){
  fetch(file_path)
      .then(response => response.text())
      .then(data => {
        const rows = data.trim().split('\n');
        const x = [];
        const y = [];
        const z = [];
        const x2 = [];
        const y2 = [];
        const z2 = [];

        rows.forEach(row => {
          const columns = row.split(',');
          x.push(parseFloat(columns[0]));
          y.push(parseFloat(columns[1]));
          z.push(parseFloat(columns[2]));
          x2.push(parseFloat(columns[3]));
          y2.push(parseFloat(columns[4]));
          z2.push(parseFloat(columns[5]));
        });

        const trace1 = {
          x: x,
          y: y,
          z: z,
          mode: 'markers',
          marker: {
            size: 5,
            color: 'blue'
          },
          name: 'Pinza Azul',
          type: 'scatter3d'
        };

        const trace2 = {
          x: x2,
          y: y2,
          z: z2,
          mode: 'markers',
          marker: {
            size: 5,
            color: 'red'
          },
          name: 'Pinza Roja',
          type: 'scatter3d'
        };

        const datos = [trace1, trace2];

        const layout = {
          scene: {
            xaxis: { title: 'X' },
            yaxis: { title: 'Y' },
            zaxis: { title: 'Z' }
          }
        };

        Plotly.newPlot(canvasId, datos, layout);
      })
      .catch(error => {
        console.log('Error:', error);
      });
}

function createBoxPlot(user_name, key, value, canvasId) {
  // Replace the file loading logic with your own code to load data from the specified file
  // For simplicity, I'm using the data directly from the example you provided

  var Intermedio = {
    "Time": 60.69212508201599,
    "Path Length": [1.0834174477703973, 0.8626897225825423],
    "Depth Perception": [0.8973606284583586, 0.7029533480712526],
    "Motion Smoothness": [3859.5452143342245, 3695.2684941249317],
    "Average Speed": [23.313913493805757, 20.293038839770727],
    "Average Acceleration": [37.59735584564821, 29.29539756003708],
    "Idle Time": [5.263157894736842, 10.526315789473683],
    "Economy of Area": [0.04903512069825732, 0.05606392524308314],
    "Economy of Volume": [0.047644686588056616, 0.05716182508368424],
    "Bimanual Dexterity": 0.5006336809813486,
    "Energy of Area": [9.36681793493183, 20.79798705001913],
    "Energy of Volume": [266.36656565646183, 456.0563869967829]
  };

  var Experto = {
    "Time": 62.464,
    "Path Length": [1.0485479928454495, 1.5210094133464467],
    "Depth Perception": [0.8066538878079352, 1.0655522285022376],
    "Motion Smoothness": [2903.9495729320306, 3059.058112621159],
    "Average Speed": [9.703856912561717, 15.75492108686466],
    "Average Acceleration": [13.625294503504211, 23.487254128503107],
    "Idle Time": [41.269841269841265, 19.047619047619047],
    "Economy of Area": [0.05385910878243402, 0.05762944154437898],
    "Economy of Volume": [0.05161328746767764, 0.04813891260483486],
    "Bimanual Dexterity": 0.7877681456985463,
    "Energy of Area": [7.4889306875130295, 16.250286760421957],
    "Energy of Volume": [309.8271513400223, 398.6185136067834]
  };

  var Novato = {
    "Time": 115.607,
    "Path Length": [2.113869478293112, 2.007913639546737],
    "Depth Perception": [1.609053015605344, 1.604949498654789],
    "Motion Smoothness": [9079.537591190789, 10125.354564604262],
    "Average Speed": [10.112240389198368, 9.107563478895742],
    "Average Acceleration": [14.074449028413245, 12.721248110863852],
    "Idle Time": [25.833333333333336, 32.5],
    "Economy of Area": [0.03421097158957899, 0.03962094746281161],
    "Economy of Volume": [0.030839899493252106, 0.03427741374528265],
    "Bimanual Dexterity": 0.6458159566082172,
    "Energy of Area": [12.907784209192766, 41.02092463268704],
    "Energy of Volume": [476.2594261320753, 967.8274632334897]
  };

  var intermediate_data = Intermedio[key];
  var expert_data = Experto[key];
  var rookie_data = Novato[key];
  var user_data = value;
  
  var data = [
    { y: expert_data, type: 'box', name: 'Experto' },
    { y: intermediate_data, type: 'box', name: 'Intermedio' },
    { y: rookie_data, type: 'box', name: 'Novato' },
    { y: user_data, type: 'box', name: user_name }
  ];

  var layout = {
    title: key,
    yaxis: { title: key }
  };
  Plotly.newPlot(canvasId, data, layout);
}

