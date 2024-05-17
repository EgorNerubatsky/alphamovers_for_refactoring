<nav class="mt-2" style="width: 200px" id="sidebar">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    
        @if(Auth::user()->is_admin)
        <li class="nav-item" style="width: 200px">
            <a href="{{ route('admin.users.index') }}" class="nav-link{{ request()->routeIs('admin.users.*') ? ' custom-active' : '' }}" style="width: 200px">
            <img src="/img/navico/leads2.png"  alt="User Image" class="mr-2">
                <p style="color: black;">Користувачі</p>
            </a>
        </li>
        @endif
  
    
        @if((Auth::user()->is_manager) || (Auth::user()->is_director))
        <li class="nav-item" style="width: 100px">
            @if(Auth::user()->is_manager)
            <a href="{{ route('erp.manager.leads.index') }}" class="nav-link{{ request()->routeIs('erp.manager.leads.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_director) 
            <a href="{{ route('erp.director.leads.index') }}" class="nav-link{{ request()->routeIs('erp.director.leads.*') ? ' custom-active' : '' }}" style="width: 200px">
            @endif
            <img src="/img/navico/leads2.png"  alt="User Image" class="mr-2">
                <p style="color: black;">Лiди</p>
            </a>
        </li>
        @endif

        @if((Auth::user()->is_manager) || (Auth::user()->is_director) || (Auth::user()->is_logist))
        <li class="nav-item" style="width: 200px">
            @if(Auth::user()->is_manager)
            <a href="{{ route('erp.manager.orders.index') }}" class="nav-link{{ request()->routeIs('erp.manager.orders.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_logist) 
            <a href="{{ route('erp.logist.orders.index') }}" class="nav-link{{ request()->routeIs('erp.logist.orders.*') ? ' custom-active' : '' }}" style="width: 200px">
            @endif
            <img src="/img/navico/leads2.png"  alt="User Image" class="mr-2">
                <p style="color: black;">Замовлення</p>
            </a>
        </li>
        @endif

        @if(Auth::user()->is_hr)
        <li class="nav-item" style="width: 100px">
            <a href="{{ route('erp.hr.applicants.index') }}" class="nav-link{{ request()->routeIs('erp.hr.applicants.*') ? ' custom-active' : '' }}" style="width: 200px">
                <img src="/img/navico/applicants.svg"  alt="User Image" class="mr-2">
                <p style="color: black;">Претенденти</p>
            </a>
        </li>
        @endif

        @if((Auth::user()->is_hr) || (Auth::user()->is_director))
        <li class="nav-item" style="width: 100px">
            @if(Auth::user()->is_hr)
            <a href="{{ route('erp.hr.interviewees.index') }}" class="nav-link{{ request()->routeIs('erp.hr.interviewees.*') ? ' custom-active' : '' }}" style="width: 300px; ml-3">
            @elseif(Auth::user()->is_director) 
            <a href="{{ route('erp.director.interviewees.index') }}" class="nav-link{{ request()->routeIs('erp.director.interviewees.*') ? ' custom-active' : '' }}" style="width: 200px">
            @endif
                <img src="/img/navico/applicants.svg"  alt="User Image" class="mr-2">
                <p style="color: black;">Прособесідовані</p>
            </a>
        </li>
        @endif
        
        @if((Auth::user()->is_manager) || (Auth::user()->is_director))
        <li class="nav-item" style="width: 200px">
            @if(Auth::user()->is_manager)
            <a href="{{ route('erp.manager.clients.index') }}" class="nav-link{{ request()->routeIs('erp.manager.clients.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_director)
            <a href="{{ route('erp.director.clients.index') }}" class="nav-link{{ request()->routeIs('erp.director.clients.*') ? ' custom-active' : '' }}" style="width: 200px">
            @endif    
                <i class="fas fa-circle nav-icon"></i>
                <p style="color: black;">База клієнтів</p>
            </a>
        </li>
        @endif

        @if((Auth::user()->is_manager) || (Auth::user()->is_director) || (Auth::user()->is_accountant))
        <li class="nav-item" style="width: 200px">
            @if(Auth::user()->is_manager)
            <a href="{{ route('erp.manager.finances.index') }}" class="nav-link{{ request()->routeIs('erp.manager.finances.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_director)
            <a href="{{ route('erp.director.finances.index') }}" class="nav-link{{ request()->routeIs('erp.director.finances.*') ? ' custom-active' : '' }}" style="width: 200px">
            @endif
                <i class="fas fa-circle nav-icon"></i>
                <p style="color: black;">Фінанси</p>
            </a>
        </li>
        @endif

        @if((Auth::user()->is_manager) || (Auth::user()->is_manager) || (Auth::user()->is_director) || (Auth::user()->is_accountant))
        <li class="nav-item" style="width: 200px">
            @if(Auth::user()->is_hr)
            <a href="{{ route('erp.hr.tasks.index') }}" class="nav-link{{ request()->routeIs('erp.hr.tasks.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_manager)
            <a href="{{ route('erp.manager.tasks.index') }}" class="nav-link{{ request()->routeIs('erp.manager.tasks.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_logist)
            <a href="{{ route('erp.logist.tasks.index') }}" class="nav-link{{ request()->routeIs('erp.logist.tasks.*') ? ' custom-active' : '' }}" style="width: 200px">
            @endif
            <img src="/img/navico/tasks.svg"  alt="User Image" class="mr-2">
                <p style="color: black;">Завдання</p>
            </a>
        </li>
        @endif







    </ul>
</nav>
