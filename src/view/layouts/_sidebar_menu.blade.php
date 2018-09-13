  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('images/logo.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          
          <p>{{ Auth::user()->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i>Online
          </a>
        </div>
        
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
      <li class="{{active('home')}}">
        <a href="{{ route('home') }}" >
          <i class="fa fa-dashboard"></i>
          <span>Dashbord</span>
        </a>
      </li>
      <!-- sidebar menu: add more below -->
      {{--  append more sidebar after this line  --}}
      
             <li>
          <a href="{{ route('logout') }}"
          onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out"></i>
              <span>Logout</span>
          
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
        </form>
      </li>
    </ul>

  </section>
  <!-- /.sidebar -->
</aside>