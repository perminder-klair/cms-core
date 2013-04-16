        <div class="row-fluid">
          <h2 class="heading">
                Dashboard
                <div class="btn-group pull-right">
                  <a class="btn" href="<?=$this->createAbsoluteUrl('/cms/admin/settings')?>"><i class="icon-cog"></i> Settings</a>
                </div>
          </h2>
        </div>


        <!--<div class="nodes">
                <h2><?php echo CHtml::link('Nodes',array('node/index')); ?></h2>
        </div>-->

        <!--<div class="row-fluid">
          <div class="overview_boxes">
            <div class="box_row clearfix">
              <div class="widget-tasks-statistics">
                <div class="userstats clearfix" style="margin-top: 25px;">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#example_modal2">
                    <div class="white">
                      <i style="color:#E28271" class="icon-eye-open"></i>
                      <p style="color:#E28271" >+85%</p>
                    </div>
                    <div>
                      <input class="knob" data-width="120" data-height="120" data-displayInput=false data-readOnly=true data-thickness=".15" value="85">   
                    </div>
                    <p><strong>+530</strong>Visits this month</p>
                  </a>
                </div>
              </div>
              <div class="widget-tasks-statistics">
                <div class="userstats clearfix" style="margin-top: 25px;">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#example_modal2">
                    <div class="white">
                      <i style="color:#98E5EA" class="icon-user"></i>
                      <p style="color:#98E5EA" >+13%</p>
                    </div>
                    <div>
                      <input class="knob" data-width="120" data-height="120" data-displayInput=false data-readOnly=true data-thickness=".15" value="13">   
                    </div>
                    <p><strong>57</strong>New Users</p>
                  </a>
                </div>
              </div>
              <div class="widget-tasks-statistics">
                <div class="userstats clearfix" style="margin-top: 25px;">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#example_modal2">
                    <div class="white">
                      <i style="color:#AEEA98" class="icon-bullhorn"></i>
                      <p style="color:#AEEA98" >+15%</p>
                    </div>
                    <div>
                      <input class="knob" data-width="120" data-height="120" data-displayInput=false data-readOnly=true data-thickness=".15" value="15">   
                    </div>
                    <p><strong>35/235</strong>Finished Tickets</p>
                  </a>
                </div>
              </div>
            </div> 
            <div class="box_row clearfix">
              <div class="widget-tasks-statistics">
                <div class="userstats clearfix" style="margin-top: 25px;">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#example_modal2">
                    <div class="white">
                      <i style="color:#98AEEA" class="icon-thumbs-up"></i>
                      <p style="color:#98AEEA" >+55%</p>
                    </div>
                    <div>
                      <input class="knob" data-width="120" data-height="120" data-displayInput=false data-readOnly=true data-thickness=".15" value="55">   
                    </div>
                    <p><strong>$14,230</strong>Income</p>
                  </a>
                </div>
              </div>
              <div class="widget-tasks-statistics">
                <div class="userstats clearfix" style="margin-top: 25px;">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#example_modal2">
                    <div class="white">
                      <i style="color:#EA98AB" class="icon-credit-card"></i>
                      <p style="color:#EA98AB" >+35%</p>
                    </div>
                    <div>
                      <input class="knob" data-width="120" data-height="120" data-displayInput=false data-readOnly=true data-thickness=".15" value="35">   
                    </div>
                    <p><strong>152</strong>New Likes</p>
                  </a>
                </div>
              </div>
              <div class="widget-tasks-statistics">
                <div class="userstats clearfix" style="margin-top: 25px;">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#example_modal2">
                    <div class="white">
                      <i style="color:#F6BF99" class="icon-phone"></i>
                      <p style="color:#F6BF99" >+97%</p>
                    </div>
                    <div>
                      <input class="knob" data-width="120" data-height="120" data-displayInput=false data-readOnly=true data-thickness=".15" value="97">   
                    </div>
                    <p><strong>592</strong>Leads Generated</p>
                  </a>
                </div>
              </div>
            </div> 
          </div>
        </div>-->

          <!--<div class="row-fluid">
            <div class="widget span12" style="overflow:visible;">
                  <a class="btn btn-box bubble bubble-danger span2 tips" data-title="bubble-danger" href="#" data-bubble="5k"><i class="icon-user"></i><span>Users</span></a>
                  <a class="btn btn-box span2" href="#"><i class="icon-plus-sign"></i><span>Notifications</span></a>
                  <a class="btn btn-box span2" href="#"><i class="icon-calendar"></i><span>Calendar</span></a>
                  <a class="btn btn-box bubble bubble-info span2 tips" data-title="bubble-info" href="#" data-bubble="2"><i class="icon-signal"></i><span>Analytics</span></a>
                  <a class="btn btn-box span2" href="#" data-bubble="2"><i class="icon-lightbulb"></i><span>Tickets</span></a>
                  <a class="btn btn-box bubble bubble-success span2 tips" data-title="bubble-success" href="#" data-bubble="102"><i class="icon-sitemap"></i><span>Categories</span></a>

            </div>
          </div>-->

        <div class="row-fluid">
          <div class="widget span8">
            <div class="widget-header">
              <i class="icon-book"></i>
              <h5>Recent Published Blogs</h5>
              <div class="widget-buttons">
                  <a href="javascript:void(0)" class="collapse" data-collapsed="false"><i data-title="Collapse" class="icon-chevron-up"></i></a>
              </div>
            </div>  
            <div class="widget-body" style="height:310px;overflow:hidden">
              <div class="widget-tickets clearfix slimscroll">
          		<? if(count($blogs)<=0) { ?>
          			<h5>&nbsp;&nbsp;No blogs to display.</h5>
          		<? } else { ?>
                <ul>
                	<? foreach($blogs as $blog): ?>
	                  <li class="priority-low">
	                    <a href="<?=url("/cms/blog/update", array('id'=>$blog->id));?>" style="padding-left:10px;">
	                      <h5><?=$blog->title;?></h5>
	                      <p>By: <?=$blog->author->username;?></p>
	                      <div class="date"><?=$blog->modified;?></div>
	                    </a>
	                  </li>
                  	<? endforeach; ?>
                </ul>
                <? } ?>
              </div>
            </div><!--/widget-body-->
            <div class="widget-footer">
              <a href="javascript:void(0)" class="pull-right btn btn-small"><i class="icon-plus"></i> Load More</a>
            </div>
          </div> <!-- /widget span5 -->

          <div class="widget span4">
            <div class="widget-header">
              <i class="icon-comment-alt"></i>
              <h5>Recent Comments</h5>
              <div class="widget-buttons">
                  <a href="javascript:void(0)" class="collapse" data-collapsed="false"><i data-title="Collapse" class="icon-chevron-up"></i></a>
              </div>
            </div>  
            <div class="widget-body" style="height:310px;overflow:hidden">
              <div class="widget-comments clearfix slimscroll">
          		<? if(count($comments)<=0) { ?>
          			<h5>&nbsp;&nbsp;No comments to display.</h5>
          		<? } else { ?>
                <ul>
                	<? foreach($comments as $comment): ?>
	                  <li>
	                    <div class="comment-bubble" style="margin: 15px 10px 20px;">
	                      <h4><?=$comment->author;?> - <a href="<?=$comment->blog->getUrl();?>" style="display: inline;"><strong><?=$comment->blog->title;?></strong></a></h4>
	                      <?=$comment->content;?>
	                      <div class="date"><?=$comment->created;?></div>
	                      <div class="settings">
	                        <a href="javascript:void(0)" class="tip" data-title="Reply"><i class="icon-reply"></i></a><a href="javascript:void(0)" class="tip" data-title="Delete"><i class="icon-trash"></i></a><a href="javascript:void(0)" class="tip" data-title="Edit"><i class="icon-edit"></i></a>
	                      </div>
	                    </div>
	                  </li>
                  	<? endforeach; ?>
                </ul>
                <? } ?>
              </div>
            </div><!--/widget-body-->
            <div class="widget-footer">
              <a href="javascript:void(0)" class="pull-right btn btn-small"><i class="icon-plus"></i> Load More</a>
            </div>
          </div> <!-- /widget span5 -->
        </div> <!-- /row-fluid -->

          <!--<div class="row-fluid">
            <div class="widget span6">
                <div class="widget-header"><i class="icon-signal"></i><h5>Browsers</h5>
                <div class="widget-buttons">
                    <a href="javascript:void(0)" class="collapse" data-collapsed="false"><i data-title="Collapse" class="icon-chevron-up"></i></a>
                </div>
                </div>
                <div class="widget-header-under">The preferred browsers of your users</div>
                <div class="widget-body clearfix" style="min-height: 319px;">
                  <table class="table table-striped">
                    <thead>
                        <tr>
                          <th>Browser</th>
                          <th>Visits</th>
                        </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Firefox</td>
                        <td><strong>5798</strong></td>
                      </tr>
                      <tr>
                        <td>Chrome</td>
                        <td><strong>4855</strong></td>
                      </tr>
                      <tr>
                        <td>Internet Explorer</td>
                        <td><strong>2877</strong></td>
                      </tr>
                      <tr>
                        <td>Safari</td>
                        <td><strong>2705</strong></td>
                      </tr>
                      <tr>
                        <td>Opera</td>
                        <td><strong>1985</strong></td>
                      </tr>
                      <tr>
                        <td>Android Browser</td>
                        <td><strong>1581</strong></td>
                      </tr>
                      <tr>
                        <td>RockMelt</td>
                        <td><strong>1284</strong></td>
                      </tr>
                    </tbody>      
                  </table>
                </div>
            </div>
            <div class="widget span6">
              <div class="widget-header"><i class="icon-signal"></i><h5>Most active pages</h5>
                <div class="widget-buttons">
                  <a href="javascript:void(0)" class="collapse" data-collapsed="false"><i data-title="Collapse" class="icon-chevron-up"></i></a>
                </div>
              </div>
                <div class="widget-header-under">The most visited pages by your users</div>
                <div class="widget-body clearfix" style="min-height: 319px;">
                  <table class="table table-striped">
                    <thead>
                        <tr>
                          <th>Page</th>
                          <th>Visits</th>
                        </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Categories</td>
                        <td><strong>8790</strong></td>
                      </tr>
                      <tr>
                        <td>Clothing</td>
                        <td><strong>7052</strong></td>
                      </tr>
                      <tr>
                        <td>About</td>
                        <td><strong>6577</strong></td>
                      </tr>
                      <tr>
                        <td>Contact Us</td>
                        <td><strong>5760</strong></td>
                      </tr>
                      <tr>
                        <td>Blog</td>
                        <td><strong>4876</strong></td>
                      </tr>
                      <tr>
                        <td>Prices</td>
                        <td><strong>3866</strong></td>
                      </tr>
                      <tr>
                        <td>Information</td>
                        <td><strong>1876</strong></td>
                      </tr>
                    </tbody>      
                  </table>
                </div>
            </div>-->
          </div>