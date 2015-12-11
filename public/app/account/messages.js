var AccountMessages = React.createClass({
  render: function() {
    return <div className="tab-pane" id="messages">
      <h2>Messages</h2>

    <div className="contentpanel">
      <div className="row">
          <div className="col-sm-3 col-md-3 col-lg-2">
              <a href="" className="btn btn-success btn-block btn-create-msg">Create Message</a>
              <br>
              <ul className="nav nav-pills nav-stacked nav-msg">
                  <li className="active">
                  <a href="#">
                      <span className="badge pull-right">2</span>
                      <i className="glyphicon glyphicon-inbox"></i> Inbox
                  </a>
                  </li>
                  <li><a href="#"><i className="glyphicon glyphicon-star"></i> Starred</a></li>
                  <li><a href="#"><i className="glyphicon glyphicon-send"></i> Sent Mail</a></li>
                  <li>
                  <a href="#">
                      <span className="badge pull-right">3</span>
                      <i className="glyphicon glyphicon-pencil"></i> Draft
                  </a>
                  </li>
                  <li><a href="#"><i className="glyphicon glyphicon-trash"></i> Trash</a></li>
              </ul>
          </div>

          <div className="col-sm-9 col-md-9 col-lg-10">

              <div className="msg-header">
                  <div className="pull-right">
                      Showing 1 - 10 of 100 messages
                      <button className="btn btn-white btn-navi btn-navi-left ml5" type="button"><i className="fa fa-chevron-left"></i></button>
                      <button className="btn btn-white btn-navi btn-navi-right" type="button"><i className="fa fa-chevron-right"></i></button>

                  </div>
                  <div className="pull-left">
                      <button className="btn btn-white tooltips" type="button" data-toggle="tooltip" title="" data-original-title="Archive"><i className="fa fa-hdd-o"></i></button>
                      <button className="btn btn-white tooltips" type="button" data-toggle="tooltip" title="" data-original-title="Report Spam"><i className="fa fa-exclamation-circle"></i></button>
                      <button className="btn btn-white tooltips" type="button" data-toggle="tooltip" title="" data-original-title="Delete"><i className="fa fa-trash-o"></i></button>

                      <div className="btn-group">
                          <button data-toggle="dropdown" className="btn btn-white dropdown-toggle tooltips" type="button" title="" data-original-title="Move to Folder">
                              <i className="fa fa-folder"></i>
                          </button>
                          <ul className="dropdown-menu pull-right">
                              <li><a href="#"><i className="fa fa-folder mr5"></i> Conference</a></li>
                              <li><a href="#"><i className="fa fa-folder mr5"></i> Newsletter</a></li>
                              <li><a href="#"><i className="fa fa-folder mr5"></i> Invitations</a></li>
                              <li><a href="#"><i className="fa fa-folder mr5"></i> Promotions</a></li>
                          </ul>
                      </div>

                      <div className="btn-group">
                          <button data-toggle="dropdown" className="btn btn-white dropdown-toggle tooltips" type="button" title="" data-original-title="Label">
                              <i className="fa fa-tag"></i>
                          </button>
                          <ul className="dropdown-menu pull-right">
                              <li><a href="#"><i className="fa fa-tag mr5"></i> Web</a></li>
                              <li><a href="#"><i className="fa fa-tag mr5"></i> Photo</a></li>
                              <li><a href="#"><i className="fa fa-tag mr5"></i> Video</a></li>
                          </ul>
                      </div>

                  </div><!-- pull-right -->
              </div><!-- msg-header -->

              <ul className="media-list msg-list">
                  <li className="media unread">
                      <div className="ckbox ckbox-primary pull-left">
                          <input type="checkbox" id="checkbox1">
                          <label for="checkbox1"></label>
                      </div>
                      <a className="pull-left" href="#">
                          <img className="media-object img-circle img-online" src="assets/img/user1.png" alt="...">
                      </a>
                      <div className="media-body">
                          <div className="pull-right media-option">
                              <i className="fa fa-paperclip mr5"></i>
                              <small>Yesterday 5:51am</small>
                              <a href=""><i className="fa fa-star"></i></a>
                              <div className="btn-group">
                                  <a className="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                      <i className="fa fa-cog"></i>
                                  </a>
                                  <ul className="dropdown-menu pull-right" role="menu">
                                      <li><a href="#">Mark as Unread</a></li>
                                      <li><a href="#">Reply</a></li>
                                      <li><a href="#">Forward</a></li>
                                      <li><a href="#">Archive</a></li>
                                      <li><a href="#">Move to Folder</a></li>
                                      <li><a href="#">Delete</a></li>
                                      <li className="divider"></li>
                                      <li><a href="#">Report as Spam</a></li>
                                  </ul>
                              </div>
                          </div>
                          <h4 className="sender">Jimmy Graham</h4>
                          <p><a href="#"><strong className="subject">Hi Hello!</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</a></p>
                      </div>
                  </li>
                  <li className="media unread">
                      <div className="ckbox ckbox-primary pull-left">
                          <input type="checkbox" id="checkbox2">
                          <label for="checkbox2"></label>
                      </div>
                      <a className="pull-left" href="#">
                          <img className="media-object img-circle img-offline" src="assets/img/user2.png" alt="...">
                      </a>
                      <div className="media-body">
                          <div className="pull-right media-option">
                              <small>July 10 1:10pm</small>
                              <a href=""><i className="fa fa-star"></i></a>
                              <div className="btn-group">
                                  <a className="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                      <i className="fa fa-cog"></i>
                                  </a>
                                  <ul className="dropdown-menu pull-right" role="menu">
                                      <li><a href="#">Mark as Unread</a></li>
                                      <li><a href="#">Reply</a></li>
                                      <li><a href="#">Forward</a></li>
                                      <li><a href="#">Archive</a></li>
                                      <li><a href="#">Move to Folder</a></li>
                                      <li><a href="#">Delete</a></li>
                                      <li className="divider"></li>
                                      <li><a href="#">Report as Spam</a></li>
                                  </ul>
                              </div>
                          </div>
                          <h4 className="sender">Tony Romo</h4>
                          <p><a href="#"><strong className="subject">Weekly Recognition Reminder</strong> Consectetur adipisicing elit, sed do eiusmod tempor incididunt...</a></p>
                      </div>
                  </li>
                  <li className="media">
                      <div className="ckbox ckbox-primary pull-left">
                          <input type="checkbox" id="checkbox3">
                          <label for="checkbox3"></label>
                      </div>
                      <a className="pull-left" href="#">
                          <img className="media-object img-circle img-online" src="assets/img/user3.png" alt="...">
                      </a>
                      <div className="media-body">
                          <div className="pull-right media-option">
                              <i className="fa fa-paperclip mr5"></i>
                              <small>July 10 11:00am</small>
                              <a href=""><i className="fa fa-star"></i></a>
                              <div className="btn-group">
                                  <a className="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                      <i className="fa fa-cog"></i>
                                  </a>
                                  <ul className="dropdown-menu pull-right" role="menu">
                                      <li><a href="#">Mark as Unread</a></li>
                                      <li><a href="#">Reply</a></li>
                                      <li><a href="#">Forward</a></li>
                                      <li><a href="#">Archive</a></li>
                                      <li><a href="#">Move to Folder</a></li>
                                      <li><a href="#">Delete</a></li>
                                      <li className="divider"></li>
                                      <li><a href="#">Report as Spam</a></li>
                                  </ul>
                              </div>
                          </div>
                          <h4 className="sender">Jimmy Clausen</h4>
                          <p><a href="#"><strong className="subject">Weno added you as a friend</strong> Consectetur adipisicing elit, sed do eiusmod tempor incididunt...</a></p>
                      </div>
                  </li>
                  <li className="media">
                      <div className="ckbox ckbox-primary pull-left">
                          <input type="checkbox" id="checkbox4">
                          <label for="checkbox4"></label>
                      </div>
                      <a className="pull-left" href="#">
                          <img className="media-object img-circle img-online" src="assets/img/user4.png" alt="...">
                      </a>
                      <div className="media-body">
                          <div className="pull-right media-option">
                              <i className="fa fa-paperclip mr5"></i>
                              <small>July 9 4:10am</small>
                              <a href=""><i className="fa fa-star"></i></a>
                              <div className="btn-group">
                                  <a className="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                      <i className="fa fa-cog"></i>
                                  </a>
                                  <ul className="dropdown-menu pull-right" role="menu">
                                      <li><a href="#">Mark as Unread</a></li>
                                      <li><a href="#">Reply</a></li>
                                      <li><a href="#">Forward</a></li>
                                      <li><a href="#">Archive</a></li>
                                      <li><a href="#">Move to Folder</a></li>
                                      <li><a href="#">Delete</a></li>
                                      <li className="divider"></li>
                                      <li><a href="#">Report as Spam</a></li>
                                  </ul>
                              </div>
                          </div>
                          <h4 className="sender">Steve Smith</h4>
                          <p><a href="#"><strong className="subject">Mobile Banking Transaction</strong> Consectetur adipisicing elit, sed do eiusmod tempor incididunt...</a></p>
                      </div>
                  </li>
                  <li className="media">
                      <div className="ckbox ckbox-primary pull-left">
                          <input type="checkbox" id="checkbox5">
                          <label for="checkbox5"></label>
                      </div>
                      <a className="pull-left" href="#">
                          <img className="media-object img-circle img-offline" src="assets/img/user5.png" alt="...">
                      </a>
                      <div className="media-body">
                          <div className="pull-right media-option">
                              <small>July 8 1:10pm</small>
                              <a href=""><i className="fa fa-star"></i></a>
                              <div className="btn-group">
                                  <a className="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                      <i className="fa fa-cog"></i>
                                  </a>
                                  <ul className="dropdown-menu pull-right" role="menu">
                                      <li><a href="#">Mark as Unread</a></li>
                                      <li><a href="#">Reply</a></li>
                                      <li><a href="#">Forward</a></li>
                                      <li><a href="#">Archive</a></li>
                                      <li><a href="#">Move to Folder</a></li>
                                      <li><a href="#">Delete</a></li>
                                      <li className="divider"></li>
                                      <li><a href="#">Report as Spam</a></li>
                                  </ul>
                              </div>
                          </div>
                          <h4 className="sender">Eli Manning</h4>
                          <p><a href="#"><strong className="subject">Brown Bag Reminder</strong> Sed do eiusmod tempor incididunt consectetur adipisicing elit, sed do...</a></p>
                      </div>
                  </li>
                  <li className="media">
                      <div className="ckbox ckbox-primary pull-left">
                          <input type="checkbox" id="checkbox6">
                          <label for="checkbox6"></label>
                      </div>
                      <a className="pull-left" href="#">
                          <img className="media-object img-circle img-online" src="assets/img/user1.png" alt="...">
                      </a>
                      <div className="media-body">
                          <div className="pull-right media-option">
                              <i className="fa fa-paperclip mr5"></i>
                              <small>July 7 5:51am</small>
                              <a href=""><i className="fa fa-star"></i></a>
                              <div className="btn-group">
                                  <a className="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                      <i className="fa fa-cog"></i>
                                  </a>
                                  <ul className="dropdown-menu pull-right" role="menu">
                                      <li><a href="#">Mark as Unread</a></li>
                                      <li><a href="#">Reply</a></li>
                                      <li><a href="#">Forward</a></li>
                                      <li><a href="#">Archive</a></li>
                                      <li><a href="#">Move to Folder</a></li>
                                      <li><a href="#">Delete</a></li>
                                      <li className="divider"></li>
                                      <li><a href="#">Report as Spam</a></li>
                                  </ul>
                              </div>
                          </div>
                          <h4 className="sender">Jimmy Graham</h4>
                          <p><a href="#"><strong className="subject">Hi Hello!</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</a></p>
                      </div>
                  </li>
                  <li className="media">
                      <div className="ckbox ckbox-primary pull-left">
                          <input type="checkbox" id="checkbox7">
                          <label for="checkbox7"></label>
                      </div>
                      <a className="pull-left" href="#">
                          <img className="media-object img-circle img-offline" src="assets/img/user2.png" alt="...">
                      </a>
                      <div className="media-body">
                          <div className="pull-right media-option">
                              <i className="fa fa-paperclip mr5"></i>
                              <small>July 7 1:10pm</small>
                              <a href=""><i className="fa fa-star"></i></a>
                              <div className="btn-group">
                                  <a className="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                      <i className="fa fa-cog"></i>
                                  </a>
                                  <ul className="dropdown-menu pull-right" role="menu">
                                      <li><a href="#">Mark as Unread</a></li>
                                      <li><a href="#">Reply</a></li>
                                      <li><a href="#">Forward</a></li>
                                      <li><a href="#">Archive</a></li>
                                      <li><a href="#">Move to Folder</a></li>
                                      <li><a href="#">Delete</a></li>
                                      <li className="divider"></li>
                                      <li><a href="#">Report as Spam</a></li>
                                  </ul>
                              </div>
                          </div>
                          <h4 className="sender">Tony Romo</h4>
                          <p><a href="#"><strong className="subject">Weekly Recognition Reminder</strong> Consectetur adipisicing elit, sed do eiusmod tempor incididunt...</a></p>
                      </div>
                  </li>
                  <li className="media">
                      <div className="ckbox ckbox-primary pull-left">
                          <input type="checkbox" id="checkbox8">
                          <label for="checkbox8"></label>
                      </div>
                      <a className="pull-left" href="#">
                          <img className="media-object img-circle img-offline" src="assets/img/user3.png" alt="...">
                      </a>
                      <div className="media-body">
                          <div className="pull-right media-option">
                              <small>July 6 11:00am</small>
                              <a href=""><i className="fa fa-star"></i></a>
                              <div className="btn-group">
                                  <a className="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                      <i className="fa fa-cog"></i>
                                  </a>
                                  <ul className="dropdown-menu pull-right" role="menu">
                                      <li><a href="#">Mark as Unread</a></li>
                                      <li><a href="#">Reply</a></li>
                                      <li><a href="#">Forward</a></li>
                                      <li><a href="#">Archive</a></li>
                                      <li><a href="#">Move to Folder</a></li>
                                      <li><a href="#">Delete</a></li>
                                      <li className="divider"></li>
                                      <li><a href="#">Report as Spam</a></li>
                                  </ul>
                              </div>
                          </div>
                          <h4 className="sender">Jimmy Clausen</h4>
                          <p><a href="#"><strong className="subject">Weno added you as a friend</strong> Consectetur adipisicing elit, sed do eiusmod tempor incididunt...</a></p>
                      </div>
                  </li>
                  <li className="media">
                      <div className="ckbox ckbox-primary pull-left">
                          <input type="checkbox" id="checkbox9">
                          <label for="checkbox9"></label>
                      </div>
                      <a className="pull-left" href="#">
                          <img className="media-object img-circle img-offline" src="assets/img/user4.png" alt="...">
                      </a>
                      <div className="media-body">
                          <div className="pull-right media-option">
                              <small>July 6 4:10am</small>
                              <a href=""><i className="fa fa-star"></i></a>
                              <div className="btn-group">
                                  <a className="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                      <i className="fa fa-cog"></i>
                                  </a>
                                  <ul className="dropdown-menu pull-right" role="menu">
                                      <li><a href="#">Mark as Unread</a></li>
                                      <li><a href="#">Reply</a></li>
                                      <li><a href="#">Forward</a></li>
                                      <li><a href="#">Archive</a></li>
                                      <li><a href="#">Move to Folder</a></li>
                                      <li><a href="#">Delete</a></li>
                                      <li className="divider"></li>
                                      <li><a href="#">Report as Spam</a></li>
                                  </ul>
                              </div>
                          </div>
                          <h4 className="sender">Steve Smith</h4>
                          <p><a href="#"><strong className="subject">Mobile Banking Transaction</strong> Consectetur adipisicing elit, sed do eiusmod tempor incididunt...</a></p>
                      </div>
                  </li>
                  <li className="media">
                      <div className="ckbox ckbox-primary pull-left">
                          <input type="checkbox" id="checkbox10">
                          <label for="checkbox10"></label>
                      </div>
                      <a className="pull-left" href="#">
                          <img className="media-object img-circle img-online" src="assets/img/user5.png" alt="...">
                      </a>
                      <div className="media-body">
                          <div className="pull-right media-option">
                              <small>July 6 1:10pm</small>
                              <a href=""><i className="fa fa-star"></i></a>
                              <div className="btn-group">
                                  <a className="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                      <i className="fa fa-cog"></i>
                                  </a>
                                  <ul className="dropdown-menu pull-right" role="menu">
                                      <li><a href="#">Mark as Unread</a></li>
                                      <li><a href="#">Reply</a></li>
                                      <li><a href="#">Forward</a></li>
                                      <li><a href="#">Archive</a></li>
                                      <li><a href="#">Move to Folder</a></li>
                                      <li><a href="#">Delete</a></li>
                                      <li className="divider"></li>
                                      <li><a href="#">Report as Spam</a></li>
                                  </ul>
                              </div>
                          </div>
                          <h4 className="sender">Eli Manning</h4>
                          <p><a href="#"><strong className="subject">Brown Bag Reminder</strong> Sed do eiusmod tempor incididunt consectetur adipisicing elit, sed do...</a></p>
                      </div>
                  </li>
              </ul>
          </div>
      </div>
  </div>
    </div>;
  }
});
