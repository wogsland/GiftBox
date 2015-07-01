
// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages':['corechart']});
google.load("visualization", "1", {packages:["geochart"]});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(renderTotalChart);
google.setOnLoadCallback(renderUniqueChart);
google.setOnLoadCallback(renderAverageChart);
google.setOnLoadCallback(renderBouncesChart);
google.setOnLoadCallback(renderFacebookChart);
google.setOnLoadCallback(renderTwitterChart);
google.setOnLoadCallback(renderEmailChart);
google.setOnLoadCallback(renderGenderChart);
google.setOnLoadCallback(renderAgeChart);
google.setOnLoadCallback(renderGeoChart);
google.setOnLoadCallback(renderDeviceChart);
google.setOnLoadCallback(renderDesktopChart);
google.setOnLoadCallback(renderTabletChart);
google.setOnLoadCallback(renderMobileChart);

var totalChartData = null;
var uniqueChartData = null;
var averageChartData = null;
var bouncesChartData = null;
var facebookChartData = null;
var twitterChartData = null;
var emailChartData = null;
var genderChartData = null;
var ageChartData = null;
var geoChartData = null;
var deviceChartData = null;
var desktopChartData = null;
var tabletChartData = null;
var mobileChartData = null;

function renderTotalChart() {

  for (var i = 0; i < totalChartData.rows.length; i++) {
      totalChartData.rows[i].c[1].v = parseInt(totalChartData.rows[i].c[1].v);
  }

  console.log(totalChartData);
  var data = new google.visualization.DataTable(totalChartData);
  console.log(data);

  // Set chart options
  var options = {
    title: 'Total Page Views',
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'}, 
    fontName: 'Lane'
  };

  console.log(data.getColumnLabel(1));
  data.setColumnLabel(1, 'Page Views');

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
    title: 'Unique Page Views',
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
    fontName: 'Lane'
  };

  console.log(data.getColumnLabel(1));
  data.setColumnLabel(1, 'Unique Views');

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
    title: 'Average Time on the Page',
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
    fontName: 'Lane'
  };

  console.log(data.getColumnLabel(1));
  data.setColumnLabel(1, 'Averga Time');

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
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
    fontName: 'Lane'
  };

  console.log(data.getColumnLabel(1));
  data.setColumnLabel(1, 'Bounces');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('bounces-timeline'));
  chart.draw(data, options);
}

function renderFacebookChart() {

  for (var i = 0; i < facebookChartData.rows.length; i++) {
      facebookChartData.rows[i].c[1].v = parseInt(facebookChartData.rows[i].c[1].v);
  }

  console.log(facebookChartData);
  var data = new google.visualization.DataTable(facebookChartData);
  console.log(data);

  // Set chart options
  var options = {
    title: 'Facebook Visitors',
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
    fontName: 'Lane'
  };

  console.log(data.getColumnLabel(1));
  data.setColumnLabel(1, 'Visitors');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('facebook-timeline'));
  chart.draw(data, options);
}

function renderTwitterChart() {

  for (var i = 0; i < twitterChartData.rows.length; i++) {
      twitterChartData.rows[i].c[1].v = parseInt(twitterChartData.rows[i].c[1].v);
  }

  console.log(twitterChartData);
  var data = new google.visualization.DataTable(twitterChartData);
  console.log(data);

  // Set chart options
  var options = {
    title: 'Twitter Visitors',
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
    fontName: 'Lane'
  };

  console.log(data.getColumnLabel(1));
  data.setColumnLabel(1, 'Visitors');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('twitter-timeline'));
  chart.draw(data, options);
}

function renderEmailChart() {

  for (var i = 0; i < emailChartData.rows.length; i++) {
      emailChartData.rows[i].c[1].v = parseInt(emailChartData.rows[i].c[1].v);
  }

  console.log(emailChartData);
  var data = new google.visualization.DataTable(emailChartData);
  console.log(data);

  // Set chart options
  var options = {
    title: 'Email Opens',
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
    fontName: 'Lane'
  };

  console.log(data.getColumnLabel(1));
  data.setColumnLabel(1, 'Opens');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('email-timeline'));
  chart.draw(data, options);
}

function renderGenderChart() {

  console.log(genderChartData);
  var data = new google.visualization.DataTable(genderChartData);
  console.log(data);

  // Set chart options
  var options = {
    title: 'Gender',
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
    fontName: 'Lane'
  };

  console.log(data.getColumnLabel(1));
  data.setColumnLabel(1, 'User');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.ColumnChart(document.getElementById('gender-timeline'));
  chart.draw(data, options);
}

function renderAgeChart() {

  console.log(ageChartData);
  var data = new google.visualization.DataTable(ageChartData);
  console.log(data);

  // Set chart options
  var options = {
    title: 'Age',
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
    fontName: 'Lane'
  };

  console.log(data.getColumnLabel(1));
  data.setColumnLabel(1, 'User');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.ColumnChart(document.getElementById('age-timeline'));
  chart.draw(data, options);
}

function renderGeoChart() {

  console.log(geoChartData);
  var data = new google.visualization.DataTable(geoChartData);
  console.log(data);

  // Set chart options
  var options = {
    title: 'Cities',
    region: 'US',
    displayMode: 'markers',
    colorAxis: {colors: ['green', 'blue']},
    chartArea:{width:'65%',height:'65%'},
    fontName: 'Lane',
    width: 370,
    height: 200,
  };

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.GeoChart(document.getElementById('geo-timeline'));
  chart.draw(data, options);
}

function renderDeviceChart() {

  console.log(deviceChartData);
  var data = new google.visualization.DataTable(deviceChartData);
  console.log(data);

  // Set chart options
    var options = {
    title: 'Devices',
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
    fontName: 'Lane'
  };

  console.log(data.getColumnLabel(1));
  data.setColumnLabel(1, 'Visitors');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.ColumnChart(document.getElementById('device-timeline'));
  chart.draw(data, options);
}

function renderDesktopChart() {

  console.log(desktopChartData);
  var data = new google.visualization.DataTable(desktopChartData);
  console.log(data);

  // Set chart options
    var options = {
    title: 'Desktop Visitors',
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
    fontName: 'Lane'
  };

  console.log(data.getColumnLabel(1));
  data.setColumnLabel(1, 'Visitors');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('desktop-timeline'));
  chart.draw(data, options);
}

function renderTabletChart() {

  console.log(tabletChartData);
  var data = new google.visualization.DataTable(tabletChartData);
  console.log(data);

  // Set chart options
    var options = {
    title: 'Tablet Visitors',
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
    fontName: 'Lane'
  };

  console.log(data.getColumnLabel(1));
  data.setColumnLabel(1, 'Visitors');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('tablet-timeline'));
  chart.draw(data, options);
}

function renderMobileChart() {

  console.log(mobileChartData);
  var data = new google.visualization.DataTable(mobileChartData);
  console.log(data);

  // Set chart options
    var options = {
    title: 'Mobile Visitors',
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
    fontName: 'Lane'
  };

  console.log(data.getColumnLabel(1));
  data.setColumnLabel(1, 'Visitors');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('mobile-timeline'));
  chart.draw(data, options);
}


