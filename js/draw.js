
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
var totalChartNumber = null;
var uniqueChartData = null;
var uniqueChartNumber = null;
var averageChartData = null;
var averageChartNumber = null;
var bouncesChartData = null;
var bouncesChartNumber = null;
var facebookChartData = null;
var facebookChartNumber = null;
var twitterChartData = null;
var twitterChartNumber = null;
var emailChartData = null;
var emailChartNumber = null;
var genderChartData = null;
var ageChartData = null;
var geoChartData = null;
var deviceChartData = null;
var desktopChartData = null;
var desktopChartNumber = null;
var tabletChartData = null;
var tabletChartNumber = null;
var mobileChartData = null;
var mobileChartNumber = null;

function renderTotalChart() {

  for (var i = 0; i < totalChartData.rows.length; i++) {
      totalChartData.rows[i].c[1].v = parseInt(totalChartData.rows[i].c[1].v);
  }

  var data = new google.visualization.DataTable(totalChartData);

  var title = 'Total Page Views: ' + totalChartNumber;

  // Set chart options
  var options = {
    title: title,
    titleTextStyle: {
      color: '#929292',
      fontName: 'Lane',
      fontSize: 20,
      bold: true
    },
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'}, 
  };

  data.setColumnLabel(1, 'Page Views');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('total-timeline'));
  chart.draw(data, options);
}

function renderUniqueChart() {

  for (var i = 0; i < uniqueChartData.rows.length; i++) {
      uniqueChartData.rows[i].c[1].v = parseInt(uniqueChartData.rows[i].c[1].v);
  }

  var data = new google.visualization.DataTable(uniqueChartData);

  var title = 'Unique Page Views: ' + uniqueChartNumber;

  // Set chart options
  var options = {
    title: title,
    titleTextStyle: {
      color: '#929292',
      fontName: 'Lane',
      fontSize: 20,
      bold: true
    },
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
  };

  data.setColumnLabel(1, 'Unique Views');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('unique-timeline'));
  chart.draw(data, options);
}

function renderAverageChart() {

  for (var i = 0; i < averageChartData.rows.length; i++) {
      averageChartData.rows[i].c[1].v = parseInt(averageChartData.rows[i].c[1].v);
  }

  var data = new google.visualization.DataTable(averageChartData);

  var title = 'Average Time: ' + averageChartNumber;

  // Set chart options
  var options = {
    title: title,
    titleTextStyle: {
      color: '#929292',
      fontName: 'Lane',
      fontSize: 20,
      bold: true
    },
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
  };

  data.setColumnLabel(1, 'Averga Time');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('average-time-timeline'));
  chart.draw(data, options);
}

function renderBouncesChart() {

  for (var i = 0; i < bouncesChartData.rows.length; i++) {
      bouncesChartData.rows[i].c[1].v = parseInt(bouncesChartData.rows[i].c[1].v);
  }

  var data = new google.visualization.DataTable(bouncesChartData);

  var title = 'Bounces: ' + bouncesChartNumber;

  // Set chart options
  var options = {
    title: title,
    titleTextStyle: {
      color: '#929292',
      fontName: 'Lane',
      fontSize: 20,
      bold: true
    },
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
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

  var data = new google.visualization.DataTable(facebookChartData);

  var title = 'Facebook Visitors: ' + facebookChartNumber;

  // Set chart options
  var options = {
    title: title,
    titleTextStyle: {
      color: '#929292',
      fontName: 'Lane',
      fontSize: 20,
      bold: true
    },
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
  };

  data.setColumnLabel(1, 'Visitors');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('facebook-timeline'));
  chart.draw(data, options);
}

function renderTwitterChart() {

  for (var i = 0; i < twitterChartData.rows.length; i++) {
      twitterChartData.rows[i].c[1].v = parseInt(twitterChartData.rows[i].c[1].v);
  }

  var data = new google.visualization.DataTable(twitterChartData);

  var title = 'Twitter Visitors: ' + twitterChartNumber;

  // Set chart options
  var options = {
    title: title,
    titleTextStyle: {
      color: '#929292',
      fontName: 'Lane',
      fontSize: 20,
      bold: true
    },
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
  };

  data.setColumnLabel(1, 'Visitors');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('twitter-timeline'));
  chart.draw(data, options);
}

function renderEmailChart() {

  for (var i = 0; i < emailChartData.rows.length; i++) {
      emailChartData.rows[i].c[1].v = parseInt(emailChartData.rows[i].c[1].v);
  }

  var data = new google.visualization.DataTable(emailChartData);

  var title = 'Email Opens: ' + emailChartNumber;

  // Set chart options
  var options = {
    title: title,
    titleTextStyle: {
      color: '#929292',
      fontName: 'Lane',
      fontSize: 20,
      bold: true
    },
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
  };

  data.setColumnLabel(1, 'Opens');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('email-timeline'));
  chart.draw(data, options);
}

function renderGenderChart() {

  var data = new google.visualization.DataTable(genderChartData);

  // Set chart options
  var options = {
    title: 'Gender',
    titleTextStyle: {
      color: '#929292',
      fontName: 'Lane',
      fontSize: 20,
      bold: true
    },
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
  };

  data.setColumnLabel(1, 'User');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.ColumnChart(document.getElementById('gender-timeline'));
  chart.draw(data, options);
}

function renderAgeChart() {

  var data = new google.visualization.DataTable(ageChartData);

  // Set chart options
  var options = {
    title: 'Age',
    titleTextStyle: {
      color: '#929292',
      fontName: 'Lane',
      fontSize: 20,
      bold: true
    },
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
  };

  data.setColumnLabel(1, 'User');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.ColumnChart(document.getElementById('age-timeline'));
  chart.draw(data, options);
}

function renderGeoChart() {

  var data = new google.visualization.DataTable(geoChartData);

  // Set chart options
  var options = {
    region: 'US',
    displayMode: 'markers',
    colorAxis: {colors: ['green', 'blue']},
    chartArea:{width:'65%',height:'65%'},
    width: 370,
    height: 200,
  };

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.GeoChart(document.getElementById('geo-timeline'));
  chart.draw(data, options);
}

function renderDeviceChart() {

  var data = new google.visualization.DataTable(deviceChartData);

  // Set chart options
    var options = {
    title: 'Devices',
    titleTextStyle: {
      color: '#929292',
      fontName: 'Lane',
      fontSize: 20,
      bold: true
    },
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
  };

  data.setColumnLabel(1, 'Visitors');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.ColumnChart(document.getElementById('device-timeline'));
  chart.draw(data, options);
}

function renderDesktopChart() {

  var data = new google.visualization.DataTable(desktopChartData);

  var title = 'Desktop Visitors: ' + desktopChartNumber;

  // Set chart options
    var options = {
    title: title,
    titleTextStyle: {
      color: '#929292',
      fontName: 'Lane',
      fontSize: 20,
      bold: true
    },
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
  };

  data.setColumnLabel(1, 'Visitors');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('desktop-timeline'));
  chart.draw(data, options);
}

function renderTabletChart() {

  var data = new google.visualization.DataTable(tabletChartData);

  var title = 'Tablet Visitors: ' + tabletChartNumber;

  // Set chart options
    var options = {
    title: title,
    titleTextStyle: {
      color: '#929292',
      fontName: 'Lane',
      fontSize: 20,
      bold: true
    },
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
  };

  data.setColumnLabel(1, 'Visitors');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('tablet-timeline'));
  chart.draw(data, options);
}

function renderMobileChart() {

  var data = new google.visualization.DataTable(mobileChartData);

  var title = 'Mobile Visitors: ' + mobileChartNumber;

  // Set chart options
    var options = {
    title: title,
    titleTextStyle: {
      color: '#929292',
      fontName: 'Lane',
      fontSize: 20,
      bold: true
    },
    width: 370,
    height: 200,
    chartArea:{width:'65%',height:'65%'},
  };

  data.setColumnLabel(1, 'Visitors');

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.LineChart(document.getElementById('mobile-timeline'));
  chart.draw(data, options);
}


