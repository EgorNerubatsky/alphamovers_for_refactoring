
<nav class="mt-2" style="width: 200px" id="sidebar">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item" style="width: 100px">
            <a href="{{ route('erp.manager.leads.index') }}" class="nav-link{{ request()->routeIs('erp.manager.leads.*') ? ' custom-active' : '' }}" style="width: 200px">
            <img src="/img/navico/leads2.png"  alt="User Image" class="mr-2">
                <p style="color: black;">Лiди</p>
            </a>
        </li>
        <li class="nav-item" style="width: 200px">
            <a href="{{ route('erp.manager.orders.index') }}" class="nav-link{{ request()->routeIs('erp.manager.orders.*') ? ' custom-active' : '' }}" style="width: 200px">
            <img src="/img/navico/leads2.png"  alt="User Image" class="mr-2">
                <p style="color: black;">Замовлення</p>
            </a>
        </li>

        <li class="nav-item" style="width: 200px">
            <a href="{{ route('erp.manager.clients.index') }}" class="nav-link{{ request()->routeIs('erp.manager.clients.*') ? ' custom-active' : '' }}" style="width: 200px">
            <img src="/img/navico/leads2.png"  alt="User Image" class="mr-2">
                <p style="color: black;">База клієнтів</p>
            </a>
        </li>

        <li class="nav-item" style="width: 200px">
            <a href="{{ route('erp.manager.finances.index') }}" class="nav-link{{ request()->routeIs('erp.manager.finances.*') ? ' custom-active' : '' }}" style="width: 200px">
            <img src="/img/navico/leads2.png"  alt="User Image" class="mr-2">
                <p style="color: black;">Фінанси</p>
            </a>
        </li>

        <li class="nav-item" style="width: 200px">
            <a href="{{ route('erp.manager.tasks.index') }}" class="nav-link{{ request()->routeIs('erp.manager.tasks.*') ? ' custom-active' : '' }}" style="width: 200px">
            <img src="/img/navico/leads2.png"  alt="User Image" class="mr-2">
                <p style="color: black;">Завдання</p>
            </a>
        </li>


       


        
    </ul>
</nav>

