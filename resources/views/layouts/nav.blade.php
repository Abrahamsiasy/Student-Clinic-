<nav class="navbar navbar-expand navbar-light layout-navbar-fixed " style="background-color:#3c8dbc;">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"> </span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="icon ion-md-menu"></i>
                    </a>

                </li>
            </ul>

            <style>
                .notification-badge {
                    animation: blinkAnimation 0.5s infinite; /* Blinking animation */

                }
        

                .notification-badge:hover {
                    animation: none; /* Stop the animation on hover */
                }
                @keyframes blinkAnimation {
                    0% { opacity: 1; }
                    50% { opacity: 0; }
                    100% { opacity: 1; }
                }
                .large-badge {
                 font-size: 1.0em; /* Adjust the size as needed */
                 }
            </style>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">

              


                @php
                $pendingLabsCount = Auth::user()->encounters
                    ->flatMap->labRequests
                    ->where('status', null)
                    ->where('result', null)
                    ->count();
                @endphp

                @php
                $labResultsCount = Auth::user()->encounters
                    ->flatMap->labRequests
                    ->whereNotNull('status')
                    ->whereNotNull('result')
                    ->whereNull('closed_at') 
                    ->count();
                @endphp

    
            
                   @can('result_notification')

                   <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                      <i  style="color:white" class="fa fa-bell large-badge"></i>
                       @if( $labResultsCount > 0)
                        <span class="badge badge-warning navbar-badge large-badge notification-badge" style="color:black;">
                        @else
                        {{-- <span class="badge badge-warning navbar-badge large-badge" style="color:black;"> --}}
                        @endif
                        <b>{{ $labResultsCount ?? '-' }} </b></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right ">
                      <span class="dropdown-item dropdown-header  badge-warning"  style="font-size:16px;" ><b>    <i  style="color:black" class="fa fa-bell"></i> &nbsp;{{ $labResultsCount ?? '0' }} Laboratory Notifications </b></span>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">
                        <i class="fas fa-download mr-2"></i> {{ $labResultsCount ?? '0' }}  New lab results
                        <span class="float-right text-muted text-sm">3 mins ago</span>
                      </a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">
                        <i class="fa fa-flask mr-2"></i> {{  $pendingLabsCount ?? '-' }}  Pending lab
                        <span class="float-right text-muted text-sm">1 hours ago</span>
                      </a>
                      <div class="dropdown-divider"></div>
                      
                  
                      <a href="#" class="dropdown-item">
                        <i class="fa fa-flask mr-2"></i> {{  $pendingLabsCount +  $labResultsCount ?? '-' }}  Total labs
                        <span class="float-right text-muted text-sm"> <i  class="fa fa-flask"></i> </span>
                      </a>
                      <div class="dropdown-divider"></div>
                      
                  

                      <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                

                  </li>
                  @endcan
                @php
               
                  $labRequests = \App\Models\LabTestRequest::whereNull('status')
                      ->whereNull('result')
                      ->get();
              @endphp   
      @can('lab_notification')
     <div class="dropdown-divider"></div>
                <!-- Notifications Dropdown Menu -->
     <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i  style="color:white" title="Laboratory Requests" class="fa fa-envelope large-badge"></i>


          @if( $labRequests->count() > 0)
          <span class="badge badge-warning navbar-badge  large-badge notification-badge" style="color:black;">
          @else
          {{-- <span class="badge badge-warning navbar-badge large-badge " style="color:black;"> --}}
          @endif
            
            <b> {{ $labRequests->count() ?? '0' }}</b></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header" style="font-size:18px; color:red;"> {{ $labRequests->count() ?? '0' }} New Lab requests</span>
          

        @foreach($labRequests as $labRequest)
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-check  mr-2" aria-hidden="true"></i>    {{ $labRequest->labTest->test_name }}
            <span class="float-right text-muted text-sm"> {{ $labRequest->created_at->diffForHumans() }} </span>
          </a>
          <div class="dropdown-divider"></div>
          @endforeach
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>

      @endcan
                <li class="nav-item">

                    <a class="nav-link" data-toggle="dropdown" style="color:white; href="#">
                        <i class="nav-icon icon fa fa-user"></i>
                        {{-- <img src="{{ asset('user_photo/user.png') }}"  width="30px;" class="img-circle elevation-2" alt="">

                <a class="nav-link" data-toggle="dropdown" style="color:white; href="#">
                    <i class="nav-icon icon fa fa-user"></i>
                    {{-- <img src="{{ asset('user_photo/user.png') }}"  width="30px;" class="img-circle elevation-2" alt="">
                     --}}
                        {{ Auth::user()->name }} <span
                            class="badge badge-warning right">{{ Auth::user()->roles?->first()?->name }}</span>



                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"
                            style="background-color:#3c8dbc; color;white;">



                            <a href="#" class="dropdown-item"">
                                <!-- Message Start -->
                                <div class="media">

                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            Profile
                                            <span class="float-right">
                                                Change room</span>
                                        </h3>
                                        <hr>
                                    </div>

                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            Profile
                                            <span class="float-right">
                                                Change room</span>
                                        </h3>
                                        <hr>
                                    </div>
                                </div>

                            </a>

                    </a>

                </li>
                <div class="dropdown-divider"></div>
                <li class="nav-item">

                    <span>
                        <a href="{{ route('logout') }}" class="nav-link" style="color:white;">
                            <i class="nav-icon icon fa fa-sign-out-alt"></i>

                            Logout


                        </a>

                    </span>
                </li>

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @endguest
            </ul>
        </div>
</nav>
