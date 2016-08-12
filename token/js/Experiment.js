Sizzle.Experiment = {
  'checkAndRun': function(longId, experimentId, dataToCheck, callback) {
    url = '/ajax/experiment' + longId;
    $.post(url, {'id':experimentId}, function(data){
      if (data[dataToCheck]) {
        window[callback]();
      }
    },'json');
  },
};
