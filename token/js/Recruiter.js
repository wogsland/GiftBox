Sizzle.Recruiter = {

  /**
   * Handles the data return from /ajax/user/get_recruiter_profile/
   *
   * @param {object} the return
   */
  'handleAjaxUserGetRecruiterProfile': function(data) {
    if (data.data !== undefined) {
      assetHost = Sizzle.Util.getAssetHost();
      if (Sizzle.Util.dataExists(data.data.face_image)) {
        //$('#icon-or-face').html('<img src="'+assetHost+"/"+data.data.face_image+'" width=200>');
        $('#icon-or-face').remove();
        $('#recruiter-face').css('background','url("'+assetHost+"/"+data.data.face_image+'") 50% 50% / cover');
        $('#recruiter-face').css('height','300px');
      }
      if (Sizzle.Util.dataExists(data.data.position)) {
        $('#gt-info-recruiter-position').html(data.data.position);
      } else {
        $('#gt-info-recruiter-position').remove();
      }
      if (Sizzle.Util.dataExists(data.data.about)) {
        $('#gt-info-recruiter-bio').html(data.data.about);
      } else {
        $('#gt-info-recruiter-bio').remove();
      }
      if (Sizzle.Util.dataExists(data.data.linkedin)) {
        $('#linkedin-button').attr('href', data.data.linkedin);
        $('.recruiter-profile-option').removeClass('mdl-cell--3-col');
        $('.recruiter-profile-option').addClass('mdl-cell--12-col');
      } else {
        $('#linkedin-button').remove();
      }
      if (Sizzle.Util.dataExists(data.data.email_address)) {
        $('#email-now-button').attr('href', 'mailto:'+data.data.email_address);
        if ($('#linkedin-button').length) {
          $('.recruiter-profile-option').removeClass('mdl-cell--12-col');
          $('.recruiter-profile-option').addClass('mdl-cell--6-col');
        } else {
          $('.recruiter-profile-option').removeClass('mdl-cell--3-col');
          $('.recruiter-profile-option').addClass('mdl-cell--12-col');
        }
      } else {
        $('#email-now-button').remove();
      }
      if (Sizzle.Util.dataExists(data.data.first_name) || Sizzle.Util.dataExists(data.data.last_name)) {
        $('#gt-info-recruiter-name').html(data.data.first_name+' '+data.data.last_name);
      } else {
        // if there are no names a recruiter profile doesn't make sense
        $('#recruiter-section').remove();
      }
    } else {
      $('#recruiter-section').remove();
    }
    Sizzle.Token.updateSectionPositions();
  },
};
