      <header class="main-header">               
        <nav class="navbar navbar-static-top" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <a href="{{ url('/dashboard') }}" class="navbar-brand"><b>Admin</b><em>OCMS</em></a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#topbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>
            
            <div id="navbar-collapse" class="collapse navbar-collapse pull-left">
            </div>
            
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 4 messages</li>
                            <li>
                                <!-- inner menu: contains the messages -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <!-- User Image -->
                                                <img src="{{asset('/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image"/>
                                            </div>
                                            <!-- Message title and timestamp -->
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <!-- The message -->
                                            <p> You have 4 messages </p>
                                       </a>
                                    </li><!-- end message -->
                                </ul><!-- /.menu -->
                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li><!-- /.messages-menu -->
    
                    <!-- Notifications Menu -->
                    <li class="dropdown notifications-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                             <?php
								Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
								$com=DB::table('acc_companies')->where('id',$com_id)->first();  
								$check_count=DB::table('acc_tranmasters')->where('com_id',$com_id)->where('tmamount','>','0')
								->where('check_id',Auth::id())->where('check_action',0)->count('check_action');
								$ttl='';
								$approve_count=DB::table('acc_tranmasters')->where('com_id',$com_id)
								->where('appr_id',Auth::id())->where('appr_action',0)
								->where('check_action',1)->count('check_action');
								//echo $check_count;
								$check_count> 0 ? $ttl += $check_count: '';
								$approve_count> 0 ? $ttl += $approve_count: '';
								// recquisition count
								$rcheck_count=DB::table('acc_prequisitions')->where('com_id',$com_id)
								->where('check_id',Auth::id())->where('check_action',0)
								->where('check_action',0)->count('check_action');
								$rcheck_count> 0 ? $ttl += $rcheck_count: '';

								// transferred count
								$sis_count1=DB::table('acc_trandetails')
								->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
								->where('sis_id',$com_id)
								->where('acc_trandetails.sis_action','')
								->groupBy('acc_tranmasters.id')
								->count('acc_tranmasters.id'); 
								//$sis_count1> 0 ? $ttl += $sis_count1: ''; 
								$sis_count=0;

								// audit count
								$audit_count=DB::table('acc_audits')
								->where('com_id',$com_id)
								->where('sendto',Auth::id())
								->where('reply_id',0)
								->count('sendto'); 
								$audit_count> 0 ? $ttl += $audit_count: '';

								// Technical count
								$techeck=DB::table('acc_tranmasters')
								->where('tmamount','>','0')
								->where('com_id',$com_id)
								->where('techeck_id',Auth::id())
								->where('check_id',0)
								->count('techeck_id'); 
								$techeck> 0 ? $ttl += $techeck: '';


								// Inventory count
								$icheck=DB::table('acc_invenmasters')
								->where('com_id',$com_id)
								->where('check_id',Auth::id())
								->where('check_action','')
								->count('check_id'); 
								$icheck> 0 ? $ttl += $icheck: '';
								
								// reminder
								$reminder_count='';$amt='';
								$reminder=DB::table('acc_trandetails')
								->where('com_id',$com_id)
								->where('rmndr_id','>','0')
								->where('rmndr_date','<=',date('Y-m-d'))
								->havingRaw('SUM(amount) <> 0')
								->groupBy('rmndr_id')
								->get(); //echo $reminder.'';
								foreach($reminder as $item): 
									$amt=DB::table('acc_trandetails')->where('com_id',$com_id)->where('rmndr_id',$item->rmndr_id)->sum('amount');
									$amt!=0 ? $reminder_count+=1 : '';
								endforeach;
								$reminder_count!='' ? $ttl += 1: '';
							?>

                            <span class="label label-warning">{{ $ttl }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have {{ $ttl }} notifications</li>
                            <li>
                                <!-- Inner Menu: contains the notifications -->
                                <ul class="menu">
                                    <li><!-- start notification -->
                                           	@if($check_count>0)
                                            	<a href="{{ url('/tranmaster/checkby') }}"> 
                                                	<i class="fa fa-users text-aqua"></i>{{ $check_count }} Transaction for checking
                                                </a>
                                        	@endif
											@if($approve_count>0)
                                            	<a href="{{ url('/tranmaster/approveby') }}"> 
                                                	<i class="fa fa-users text-aqua"></i>{{ $approve_count }} Transaction for approval
                                                </a>
                                        	@endif  
											@if($rcheck_count>0)
                                            	<a href="{{ url('/prequisition/check') }}"> 
                                                	<i class="fa fa-users text-aqua"></i>{{ $rcheck_count }} Requisition for checking
                                                </a>
                                        	@endif  
                                            @if($sis_count>0)
                                            	<a href="{{ url('/tranmaster/sister') }}"> 
                                                	<i class="fa fa-users text-aqua"></i>{{ $sis_count }} Transfered for acceptance
                                                </a>
                                        	@endif  
                                            @if($audit_count>0)
                                            	<a href="{{ url('/audit/reply') }}"> 
                                                	<i class="fa fa-users text-aqua"></i>{{ $audit_count }} Audtit Notice
                                                </a>
                                        	@endif  
                                            @if($reminder_count>'0')
                                            	<a href="{{ url('/trandetail/reminder') }}"> 
                                                	<i class="fa fa-users text-aqua"></i>{{ $reminder_count }} Transaction Reminder
                                                </a>
                                        	@endif  
                                            @if($techeck>'0')
                                            	<a href="{{ url('/tranmaster/techeckby') }}"> 
                                                	<i class="fa fa-users text-aqua"></i>{{ $techeck }} Waiting for Technical Check
                                                </a>
                                        	@endif  
                                            @if($icheck>0)
                                            	<a href="{{ url('/invenmaster/checkby') }}"> 
                                                	<i class="fa fa-users text-aqua"></i>{{ $icheck }} Waiting for Inventory Check
                                                </a>
                                        	@endif  

                                    </li><!-- end notification -->
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>
                    <!-- Tasks Menu -->
                    <li class="dropdown tasks-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 9 tasks</li>
                            <li>
                                <!-- Inner menu: contains the tasks -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <!-- Task title and progress text -->
                                            <h3>
                                                Design some buttons
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <!-- The progress bar -->
                                            <div class="progress xs">
                                                <!-- Change the css width attribute to simulate progress -->
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li><!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>
                     @if(Auth::user()->user_img)
                        {{-- */$image = asset('/images/user_img/'.Auth::user()->user_img);/* --}}
                    @else
                        {{-- */$image = asset('/img/user2-160x160.jpg');/* --}}
                    @endif

                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{$image}}" class="user-image" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">@if(isset( Auth::user()->name)){{ Auth::user()->name }}@endif</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{asset('/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image" />
                                <p>
                                    @if(isset( Auth::user()->name)){{ Auth::user()->name }}@endif
                                    <small>@if(isset(Auth::user()->email)){{ Auth::user()->email }}@endif</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ url('/profile/'.Auth::user()->id) }}" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/auth/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    @if(Auth::user()->companies->count() > 1)
                    <!--Company Switcher-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-exchange"></i>                  
                        </a>
                        <ul class="dropdown-menu">
                            @foreach(Auth::user()->companies as $company)
                            <li><!-- Company -->
                                @if($current_company_id != $company->id)
                                <a href="javascript:void(0)" data-company="{{ $company->id }}" data-company-name="{{ $company->name }}" data-company-abbreviation="{{ $company->abbreviation }}">
                                    {{ $company->name }}
                                </a>
                                @else
                                <span class="active">{{ $company->name }}</span>
                                @endif
                            </li><!-- end Company -->
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    
                    
                </ul>
            </div><!-- /.navbar-custom-menu -->
          </div><!-- /.container-fluid -->
        </nav>
      </header>