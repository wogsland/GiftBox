// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(renderTotalChart);
google.setOnLoadCallback(renderUniqueChart);
google.setOnLoadCallback(renderAverageChart);
google.setOnLoadCallback(renderBouncesChart);

var totalChartData = null;
var uniqueChartData = null;
var averageChartData = null;
var bouncesChartData = null;

function renderTotalChart() {

  for (var i = 0; i < totalChartData.rows.length; i++) {
      totalChartData.rows[i].c[1].v = parseInt(totalChartData.rows[i].c[1].v);
  }

  console.log(totalChartData);
  var data = new google.visualization.DataTable(totalChartData);
  console.log(data);

  // Set chart options
  var options = {
    title: 'Total PageViews',
    width: 400,
    height: 300
  };

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('total-timeline'));
  chart.draw(data, options);
}

function renderUniqueChart() {

  for (var i = 0; i < uniqueChartData.rows.length; i++) {
      uniqueChartData.rows[i].c[1].v = parseInt(uniqueChartData.rows[i].c[1].v);
  }

  console.log(uniqueChartData);
  var data = new google.visualization.DataTable(uniqueChartData);
  console.log(data);

  // Set chart options
  var options = {
    title: 'Unique PageViews',
    width: 400,
    height: 300
  };

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('unique-timeline'));
  chart.draw(data, options);
}

function renderAverageChart() {

  for (var i = 0; i < averageChartData.rows.length; i++) {
      averageChartData.rows[i].c[1].v = parseInt(averageChartData.rows[i].c[1].v);
  }

  console.log(averageChartData);
  var data = new google.visualization.DataTable(averageChartData);
  console.log(data);

  // Set chart options
  var options = {
    title: 'Average Time on Page',
    width: 400,
    height: 300
  };

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('average-time-timeline'));
  chart.draw(data, options);
}

function renderBouncesChart() {

  for (var i = 0; i < bouncesChartData.rows.length; i++) {
      bouncesChartData.rows[i].c[1].v = parseInt(bouncesChartData.rows[i].c[1].v);
  }

  console.log(bouncesChartData);
  var data = new google.visualization.DataTable(bouncesChartData);
  console.log(data);

  // Set chart options
  var options = {
    title: 'Bounces',
    width: 400,
    height: 300
  };

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('bounces-timeline'));
  chart.draw(data, options);
}
