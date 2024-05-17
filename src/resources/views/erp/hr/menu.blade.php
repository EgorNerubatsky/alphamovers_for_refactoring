<nav class="mt-2" style="width: 200px" id="sidebar">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item" style="width: 100px">
            <a href="{{ route('erp.hr.applicants.index') }}" class="nav-link{{ request()->routeIs('erp.hr.applicants.*') ? ' custom-active' : '' }}" style="width: 200px">
                <img src="/img/navico/applicants.svg"  alt="User Image" class="mr-2">
                <p style="color: black;">Претенденти</p>
            </a>
        </li>
        
        <li class="nav-item" style="width: 200px">
            <a href="{{ route('erp.hr.interviewees.index') }}" class="nav-link{{ request()->routeIs('erp.hr.interviewees.*') ? ' custom-active' : '' }}" style="width: 300px; ml-3">
                <img src="/img/navico/interviewees.svg"  alt="User Image" class="mr-2">
                <p style="color: black;">Прособесідовані</p>
            </a>
        </li>

        <li class="nav-item" style="width: 200px">
            <a href="{{ route('erp.manager.clients.index') }}" class="nav-link{{ request()->routeIs('erp.manager.clients.*') ? ' custom-active' : '' }}" style="width: 200px">
                <i class="fas fa-circle nav-icon"></i>
                <p style="color: black;">База клієнтів</p>
            </a>
        </li>

        <li class="nav-item" style="width: 200px">
            <a href="{{ route('erp.manager.finances.index') }}" class="nav-link{{ request()->routeIs('erp.manager.finances.*') ? ' custom-active' : '' }}" style="width: 200px">
                <i class="fas fa-circle nav-icon"></i>
                <p style="color: black;">Фінанси</p>
            </a>
        </li>

        <li class="nav-item" style="width: 200px">
            <a href="{{ route('erp.hr.tasks.index') }}" class="nav-link{{ request()->routeIs('erp.hr.tasks.*') ? ' custom-active' : '' }}" style="width: 200px">
            <img src="/img/navico/tasks.svg"  alt="User Image" class="mr-2">
                <p style="color: black;">Завдання</p>
            </a>
        </li>
    </ul>
</nav>
