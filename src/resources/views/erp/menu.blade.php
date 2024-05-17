<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">

            @if(Auth::user()->is_manager || Auth::user()->is_executive)
                <li>
                    <a href="{{ Auth::user()->is_manager ? route('erp.manager.leads.index') : route('erp.executive.leads.index') }}"
                       class="nav-link{{ request()->routeIs('erp.manager.leads.*', 'erp.executive.leads.*') ? ' custom-active' : '' }}">
                        <i class="icon-magnifier menu-icon" style="font-size: 25px;"></i><span
                            class="nav-text">Лiди</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->is_manager || Auth::user()->is_executive || Auth::user()->is_logist || Auth::user()->is_accountant)
                <li>
                    <a href="{{ Auth::user()->is_manager ? route('erp.manager.orders.index') : (Auth::user()->is_logist ? route('erp.logist.orders.index') : (Auth::user()->is_accountant ? route('erp.accountant.orders.index') : route('erp.executive.orders.index'))) }}"
                       class="nav-link{{ request()->routeIs('erp.manager.orders.*', 'erp.logist.orders.*', 'erp.accountant.orders.*', 'erp.executive.orders.*') ? ' custom-active' : '' }}">
                        <i class="icon-layers menu-icon" style="font-size: 25px;"></i><span
                            class="nav-text">Замовлення</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->is_executive || Auth::user()->is_admin)
                <li>
                    <a href="{{ Auth::user()->is_executive ? route('erp.executive.employees.index') : route('erp.admin.employees.index') }}"
                       class="nav-link{{ request()->routeIs('erp.executive.employees.*', 'erp.admin.employees.*') ? ' custom-active' : '' }}">
                        <i class="icon-user menu-icon" style="font-size: 25px;"></i><span
                            class="nav-text">Співробітники</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->is_executive || Auth::user()->is_logist)
                <li>
                    <a href="{{ Auth::user()->is_executive ? route('erp.executive.movers.index') : route('erp.logist.movers.index') }}"
                       class="nav-link{{ request()->routeIs('erp.executive.movers.*', 'erp.logist.movers.*') ? ' custom-active' : '' }}">
                        <i class="icon-people menu-icon" style="font-size: 25px;"></i><span
                            class="nav-text">Робочі</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->is_hr || Auth::user()->is_executive)
                <li>
                    <a href="{{ Auth::user()->is_hr ? route('erp.hr.applicants.index') : route('erp.executive.applicants.index') }}"
                       class="nav-link{{ request()->routeIs('erp.hr.applicants.*', 'erp.executive.applicants.*') ? ' custom-active' : '' }}">
                        <i class="icon-user-follow menu-icon" style="font-size: 25px;"></i><span class="nav-text">Претенденти</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->is_hr || Auth::user()->is_executive)
                <li>
                    <a href="{{ Auth::user()->is_hr ? route('erp.hr.interviewees.index') : route('erp.executive.interviewees.index') }}"
                       class="nav-link{{ request()->routeIs('erp.hr.interviewees.*', 'erp.executive.interviewees.*') ? ' custom-active' : '' }}">
                        <i class="icon-check menu-icon" style="font-size: 25px;"></i><span class="nav-text">Прособесідовані</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->is_accountant || Auth::user()->is_executive)
                <li>
                    <a href="{{ Auth::user()->is_accountant ? route('erp.accountant.arrears.index') : route('erp.executive.arrears.index') }}"
                       class="nav-link{{ request()->routeIs('erp.accountant.arrears*', 'erp.executive.arrears*') ? ' custom-active' : '' }}">
                        <i class="icon-calculator menu-icon" style="font-size: 25px;"></i><span class="nav-text">Заборгованість</span>
                    </a>
                </li>
            @endif



            @if(Auth::user()->is_manager || Auth::user()->is_executive || Auth::user()->is_accountant)
                <li>
                    <a href="{{ Auth::user()->is_manager ? route('erp.manager.clients.index') : (Auth::user()->is_accountant ? route('erp.accountant.clients.index') : route('erp.executive.clients.index')) }}"
                       class="nav-link{{ request()->routeIs('erp.manager.clients.*', 'erp.accountant.clients.*', 'erp.executive.clients.*') ? ' custom-active' : '' }}">
                        <i class="icon-list menu-icon" style="font-size: 25px;"></i><span
                            class="nav-text">База клієнтів</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->is_manager || Auth::user()->is_executive || Auth::user()->is_accountant)
                <li>
                    <a href="{{ Auth::user()->is_manager ? route('erp.manager.finances.index') : (Auth::user()->is_accountant ? route('erp.accountant.finances.index') : route('erp.executive.finances.index')) }}"
                       class="nav-link{{ request()->routeIs('erp.manager.finances.*', 'erp.accountant.finances.*', 'erp.executive.finances.*') ? ' custom-active' : '' }}">
                        <i class="icon-wallet menu-icon" style="font-size: 25px;"></i><span
                            class="nav-text">Фінанси</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->is_manager || Auth::user()->is_executive || Auth::user()->is_accountant)
                <li>
                    <a href="{{ Auth::user()->is_manager ? route('erp.manager.report') : (Auth::user()->is_accountant ? route('erp.accountant.report') : route('erp.executive.report')) }}"
                       class="nav-link{{ request()->routeIs('erp.manager.report', 'erp.accountant.report', 'erp.executive.report') ? ' custom-active' : '' }}">
                        <i class="icon-chart menu-icon" style="font-size: 25px;"></i><span class="nav-text">Звіт</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->is_manager || Auth::user()->is_hr || Auth::user()->is_executive || Auth::user()->is_accountant || Auth::user()->is_logist)
                <li>
                    <a href="{{ Auth::user()->is_hr ? route('erp.hr.tasks.index') : (Auth::user()->is_manager ? route('erp.manager.tasks.index') : (Auth::user()->is_logist ? route('erp.logist.tasks.index') : (Auth::user()->is_accountant ? route('erp.accountant.tasks.index') : route('erp.executive.tasks.index')))) }}"
                       class="nav-link{{ request()->routeIs('erp.hr.tasks.*', 'erp.manager.tasks.*', 'erp.logist.tasks.*', 'erp.accountant.tasks.*', 'erp.executive.tasks.*') ? ' custom-active' : '' }}">
                        <i class="icon-calender menu-icon" style="font-size: 25px;"></i><span
                            class="nav-text">Завдання</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->is_manager || Auth::user()->is_hr || Auth::user()->is_executive || Auth::user()->is_accountant || Auth::user()->is_logist)
                <li>
                    <a href="{{ Auth::user()->is_executive ? route('erp.executive.emails.index') : (Auth::user()->is_manager ? route('erp.manager.emails.index') : (Auth::user()->is_logist ? route('erp.logist.emails.index') : (Auth::user()->is_accountant ? route('erp.accountant.emails.index') : route('erp.hr.emails.index')))) }}"
                       class="nav-link{{ request()->routeIs('erp.executive.emails.*', 'erp.manager.emails.*', 'erp.logist.emails.*', 'erp.accountant.emails.*', 'erp.hr.emails.*') ? ' custom-active' : '' }}">
                        <i class="icon-envelope-letter menu-icon" style="font-size: 25px;"></i><span class="nav-text">Пошта</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->is_manager || Auth::user()->is_hr || Auth::user()->is_executive || Auth::user()->is_accountant || Auth::user()->is_logist || Auth::user()->is_admin)
                <li>
                    <a href="{{ Auth::user()->is_executive ? route('erp.executive.messages.index') : (Auth::user()->is_admin ? route('erp.admin.messages.index') : (Auth::user()->is_manager ? route('erp.manager.messages.index') : (Auth::user()->is_logist ? route('erp.logist.messages.index') : (Auth::user()->is_accountant ? route('erp.accountant.messages.index') : route('erp.hr.messages.index'))))) }}"
                       class="nav-link{{ request()->routeIs('erp.executive.messages.*', 'erp.admin.messages.*', 'erp.manager.messages.*', 'erp.logist.messages.*', 'erp.accountant.messages.*', 'erp.hr.messages.*') ? ' custom-active' : '' }}">
                        <i class="icon-speech menu-icon" style="font-size: 25px;"></i><span
                            class="nav-text">Спілкування</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->is_manager || Auth::user()->is_hr || Auth::user()->is_executive || Auth::user()->is_accountant || Auth::user()->is_logist || Auth::user()->is_admin)
                <li>
                    <a href="{{ Auth::user()->is_executive ? route('erp.executive.articles.index') : (Auth::user()->is_manager ? route('erp.manager.articles.index') : (Auth::user()->is_logist ? route('erp.logist.articles.index') : (Auth::user()->is_accountant ? route('erp.accountant.articles.index') : (Auth::user()->is_hr ? route('erp.hr.articles.index') : route('erp.admin.articles.index'))))) }}"
                       class="nav-link{{ request()->routeIs('erp.executive.articles.*', 'erp.manager.articles.*', 'erp.logist.articles.*', 'erp.accountant.articles.*', 'erp.hr.articles.*') ? ' custom-active' : '' }}">
                        <i class="icon-question menu-icon" style="font-size: 25px;"></i><span class="nav-text">База знань</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
