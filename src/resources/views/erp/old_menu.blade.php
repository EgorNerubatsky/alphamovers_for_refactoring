<nav class="mt-2" style="width: 200px" id="sidebar">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    
        @if(Auth::user()->is_admin)
        <li class="nav-item" style="width: 200px">
            <a href="{{ route('erp.admin.users.index') }}" class="nav-link" style="width: 200px">
            <img src="/img/navico/leads2.png"  alt="User Image" class="mr-2">
                <p style="color: black;">Користувачі</p>
            </a>
        </li>
        @endif
  
    
        @if((Auth::user()->is_manager) || (Auth::user()->is_executive))
        <li class="nav-item" style="width: 100px">
            @if(Auth::user()->is_manager)
            <a href="{{ route('erp.manager.leads.index') }}" class="nav-link{{ request()->routeIs('erp.manager.leads.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_executive) 
            <a href="{{ route('erp.executive.leads.index') }}" class="nav-link{{ request()->routeIs('erp.executive.leads.*') ? ' custom-active' : '' }}" style="width: 200px">
            @endif
            <img src="/img/navico/leads2.png"  alt="User Image" class="mr-2">
                <p style="color: black;">Лiди</p>
            </a>
        </li>
        @endif

        @if((Auth::user()->is_manager) || (Auth::user()->is_executive) || (Auth::user()->is_logist) || (Auth::user()->is_accountant))
        <li class="nav-item" style="width: 200px">
            @if(Auth::user()->is_manager)
            <a href="{{ route('erp.manager.orders.index') }}" class="nav-link{{ request()->routeIs('erp.manager.orders.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_logist) 
            <a href="{{ route('erp.logist.orders.index') }}" class="nav-link{{ request()->routeIs('erp.logist.orders.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_accountant)
            <a href="{{ route('erp.accountant.orders.index') }}" class="nav-link{{ request()->routeIs('erp.accountant.orders.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_executive)
            <a href="{{ route('erp.executive.orders.index') }}" class="nav-link{{ request()->routeIs('erp.executive.orders.*') ? ' custom-active' : '' }}" style="width: 200px">
            @endif
            <img src="/img/navico/orders.png"  alt="User Image" class="mr-2">
                <p style="color: black;">Замовлення</p>
            </a>
        </li>
        @endif


        @if(Auth::user()->is_executive)
        <li class="nav-item" style="width: 200px">
            <a href="{{ route('erp.executive.employees.index') }}" class="nav-link{{ request()->routeIs('erp.executive.employees.*') ? ' custom-active' : '' }}" style="width: 200px">
            <img src="/img/navico/employees.png"  alt="User Image" class="mr-2">
                <p style="color: black;">Співробітники</p>
            </a>
        </li>
        @endif


        @if((Auth::user()->is_executive) || (Auth::user()->is_logist))
        <li class="nav-item" style="width: 200px">
            @if(Auth::user()->is_executive)
            <a href="{{ route('erp.executive.movers.index') }}" class="nav-link{{ request()->routeIs('erp.executive.movers.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_logist) 
            <a href="{{ route('erp.logist.movers.index') }}" class="nav-link{{ request()->routeIs('erp.logist.movers.*') ? ' custom-active' : '' }}" style="width: 200px">
            @endif
            <img src="/img/navico/movers.png"  alt="User Image" class="mr-2">
                <p style="color: black;">Робочі</p>
            </a>
        </li>
        @endif

        @if((Auth::user()->is_hr) || (Auth::user()->is_executive))
        <li class="nav-item" style="width: 100px">
            @if(Auth::user()->is_hr)
            <a href="{{ route('erp.hr.applicants.index') }}" class="nav-link{{ request()->routeIs('erp.hr.applicants.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_executive)
            <a href="{{ route('erp.executive.applicants.index') }}" class="nav-link{{ request()->routeIs('erp.executive.applicants.*') ? ' custom-active' : '' }}" style="width: 200px">

            @endif
            <img src="/img/navico/applicants.png"  alt="User Image" class="mr-2">
                <p style="color: black;">Претенденти</p>
            </a>
        </li>
        @endif

        @if((Auth::user()->is_accountant) || (Auth::user()->is_executive))
        <li class="nav-item" style="width: 100px">
        @if(Auth::user()->is_accountant)
            <a href="{{ route('erp.accountant.arrears.index') }}" class="nav-link{{ request()->routeIs('erp.accountant.arrears*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_executive)
            <a href="{{ route('erp.executive.arrears.index') }}" class="nav-link{{ request()->routeIs('erp.executive.arrears*') ? ' custom-active' : '' }}" style="width: 200px">
            @endif
            <img src="/img/navico/arrears.png"  alt="User Image" class="mr-2">
                <p style="color: black;">Заборгованість</p>
            </a>
        </li>
        @endif


        @if((Auth::user()->is_hr) || (Auth::user()->is_executive))
        <li class="nav-item" style="width: 100px">
            @if(Auth::user()->is_hr)
            <a href="{{ route('erp.hr.interviewees.index') }}" class="nav-link{{ request()->routeIs('erp.hr.interviewees.*') ? ' custom-active' : '' }}" style="width: 300px; ml-3">
            @elseif(Auth::user()->is_executive) 
            <a href="{{ route('erp.executive.interviewees.index') }}" class="nav-link{{ request()->routeIs('erp.executive.interviewees.*') ? ' custom-active' : '' }}" style="width: 200px">
            @endif
                <img src="/img/navico/interviewee.png"  alt="User Image" class="mr-2">
                <p style="color: black;">Прособесідовані</p>
            </a>
        </li>
        @endif
        
        @if((Auth::user()->is_manager) || (Auth::user()->is_executive) || (Auth::user()->is_accountant))
        <li class="nav-item" style="width: 200px">
            @if(Auth::user()->is_manager)
            <a href="{{ route('erp.manager.clients.index') }}" class="nav-link{{ request()->routeIs('erp.manager.clients.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_accountant)
            <a href="{{ route('erp.accountant.clients.index') }}" class="nav-link{{ request()->routeIs('erp.accountant.clients.*') ? ' custom-active' : '' }}" style="width: 200px">

            @elseif(Auth::user()->is_executive)
            <a href="{{ route('erp.executive.clients.index') }}" class="nav-link{{ request()->routeIs('erp.executive.clients.*') ? ' custom-active' : '' }}" style="width: 200px">
            @endif    
                <img src="/img/navico/clients.png"  alt="User Image" class="mr-2">
                <p style="color: black;">База клієнтів</p>
            </a>
        </li>
        @endif

        @if((Auth::user()->is_manager) || (Auth::user()->is_executive) || (Auth::user()->is_accountant))
        <li class="nav-item" style="width: 200px">
            @if(Auth::user()->is_manager)
            <a href="{{ route('erp.manager.finances.index') }}" class="nav-link{{ request()->routeIs('erp.manager.finances.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_accountant)
            <a href="{{ route('erp.accountant.finances.index') }}" class="nav-link{{ request()->routeIs('erp.accountant.finances.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_executive)
            <a href="{{ route('erp.executive.finances.index') }}" class="nav-link{{ request()->routeIs('erp.executive.finances.*') ? ' custom-active' : '' }}" style="width: 200px">
            @endif
                <img src="/img/navico/finances.png"  alt="User Image" class="mr-2">
                <p style="color: black;">Фінанси</p>
            </a>
        </li>
        @endif

        @if(Auth::user()->is_executive)
        <li class="nav-item" style="width: 200px">
            <a href="{{ route('erp.executive.report') }}" class="nav-link{{ request()->routeIs('erp.executive.report') ? ' custom-active' : '' }}" style="width: 200px">
                <img src="/img/navico/report.png"  alt="User Image" class="mr-2">
                <p style="color: black;">Звіт</p>
            </a>
        </li>
        @endif

        @if((Auth::user()->is_manager) || (Auth::user()->is_hr) || (Auth::user()->is_executive) || (Auth::user()->is_accountant) || (Auth::user()->is_logist))
        <li class="nav-item" style="width: 200px">
            @if(Auth::user()->is_hr)
            <a href="{{ route('erp.hr.tasks.index') }}" class="nav-link{{ request()->routeIs('erp.hr.tasks.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_manager)
            <a href="{{ route('erp.manager.tasks.index') }}" class="nav-link{{ request()->routeIs('erp.manager.tasks.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_logist)
            <a href="{{ route('erp.logist.tasks.index') }}" class="nav-link{{ request()->routeIs('erp.logist.tasks.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_accountant)
            <a href="{{ route('erp.accountant.tasks.index') }}" class="nav-link{{ request()->routeIs('erp.accountant.tasks.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_executive)
            <a href="{{ route('erp.executive.tasks.index') }}" class="nav-link{{ request()->routeIs('erp.executive.tasks.*') ? ' custom-active' : '' }}" style="width: 200px">
            @endif
            <img src="/img/navico/tasks.png"  alt="User Image" class="mr-2">
                <p style="color: black;">Завдання</p>
            </a>
        </li>
        @endif

        @if((Auth::user()->is_manager) || (Auth::user()->is_hr) || (Auth::user()->is_executive) || (Auth::user()->is_accountant) || (Auth::user()->is_logist))
        <li class="nav-item" style="width: 200px">
            @if(Auth::user()->is_executive)
            <a href="{{ route('erp.executive.emails.index') }}" class="nav-link{{ request()->routeIs('erp.executive.emails.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_manager)
            <a href="{{ route('erp.manager.emails.index') }}" class="nav-link{{ request()->routeIs('erp.manager.emails.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_logist)
            <a href="{{ route('erp.logist.emails.index') }}" class="nav-link{{ request()->routeIs('erp.logist.emails.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_accountant)
            <a href="{{ route('erp.accountant.emails.index') }}" class="nav-link{{ request()->routeIs('erp.accountant.emails.*') ? ' custom-active' : '' }}" style="width: 200px">
            @elseif(Auth::user()->is_hr)
            <a href="{{ route('erp.hr.emails.index') }}" class="nav-link{{ request()->routeIs('erp.hr.emails.*') ? ' custom-active' : '' }}" style="width: 200px">
            @endif
            <img src="/img/navico/emails.png"  alt="User Image" class="mr-2">
                <p style="color: black;">Пошта</p>
            </a>
        </li>
        @endif


    </ul>
</nav>
