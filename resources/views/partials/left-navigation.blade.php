<div class="side-nav expand-lg">
    <div class="side-nav-inner">
        <ul class="side-nav-menu">
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'dropdown open' : '' }}">
                <a href="{{ route('dashboard') }}" class="dropdown-toggle">
                  <span class="icon-holder">
                    <i class="lni-dashboard"></i>
                  </span>
                    <span class="title">{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li class="nav-item dropdown {{ request()->routeIs('team.settings') || request()->routeIs('user.settings') ? 'open' : '' }}">
                <a href="#" class="dropdown-toggle">
                  <span class="icon-holder">
                    <i class="lni-cog"></i>
                  </span>
                    <span class="title">{{ __('Settings') }}</span>
                    <span class="arrow">
                        <i class="lni-chevron-right"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down">
                    <li class="{{ request()->routeIs('team.settings') ? 'active' : '' }}">
                        <a href="{{ route('team.settings') }}">{{ __('Team settings') }}</a>
                    </li>
                    <li class="{{ request()->routeIs('user.settings') ? 'active' : '' }}">
                        <a href="{{ route('user.settings') }}">{{ __('User settings') }}</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>