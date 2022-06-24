<div class="header navbar">
    <div class="header-container">
        <div class="nav-logo">
            <a href="{{ route('dashboard') }}" class="d-flex">
                <strong style="width: 50px; margin: 5px;"><x-application-logo style="width: 50px" /></strong>
                <span class="logo text-dark d-flex align-items-center pl-2">
                    {{ config('app.name') }}
                </span>
            </a>
        </div>
        <ul class="nav-left">
            <li>
                <a class="sidenav-fold-toggler" href="javascript:void(0);">
                    <i class="lni-menu"></i>
                </a>
                <a class="sidenav-expand-toggler" href="javascript:void(0);">
                    <i class="lni-menu"></i>
                </a>
            </li>
        </ul>
        <ul class="nav-right">
{{--            <li class="notifications dropdown dropdown-animated scale-left">--}}
{{--                <span class="counter">2</span>--}}
{{--                <a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
{{--                    <i class="lni-alarm"></i>--}}
{{--                </a>--}}
{{--                <ul class="dropdown-menu dropdown-lg">--}}
{{--                    <li>--}}
{{--                        <h5 class="n-title text-center">--}}
{{--                            <span>Notifications</span>--}}
{{--                        </h5>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <ul class="list-media">--}}
{{--                            <li class="list-item">--}}
{{--                                <a href="#" class="media-hover">--}}
{{--                                    <div class="media-img">--}}
{{--                                        <div class="icon-avatar bg-primary">--}}
{{--                                            <i class="lni-envelope"></i>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="info">--}}
{{--                            <span class="title">--}}
{{--                              5 new messages--}}
{{--                            </span>--}}
{{--                                        <span class="sub-title">4 min ago</span>--}}
{{--                                    </div>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="list-item">--}}
{{--                                <a href="#" class="media-hover">--}}
{{--                                    <div class="media-img">--}}
{{--                                        <div class="icon-avatar bg-success">--}}
{{--                                            <i class="lni-comments-alt"></i>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="info">--}}
{{--                            <span class="title">--}}
{{--                                4 new comments--}}
{{--                            </span>--}}
{{--                                        <span class="sub-title">12 min ago</span>--}}
{{--                                    </div>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="list-item">--}}
{{--                                <a href="#" class="media-hover">--}}
{{--                                    <div class="media-img">--}}
{{--                                        <div class="icon-avatar bg-info">--}}
{{--                                            <i class="lni-users"></i>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="info">--}}
{{--                            <span class="title">--}}
{{--                              3 Friend Requests--}}
{{--                            </span>--}}
{{--                                        <span class="sub-title">a day ago</span>--}}
{{--                                    </div>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="list-item">--}}
{{--                                <a href="#" class="media-hover">--}}
{{--                                    <div class="media-img">--}}
{{--                                        <div class="icon-avatar bg-purple">--}}
{{--                                            <i class="lni-comments-alt"></i>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="info">--}}
{{--                            <span class="title">--}}
{{--                              2 new messages--}}
{{--                            </span>--}}
{{--                                        <span class="sub-title">12 min ago</span>--}}
{{--                                    </div>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                    <li class="check-all text-center">--}}
{{--                    <span>--}}
{{--                      <a href="#" class="text-gray">Check all notifications</a>--}}
{{--                    </span>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
            <li class="user-profile dropdown dropdown-animated scale-left">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img class="profile-img img-fluid" src="{{ auth()->user()->profilePhotoUrl }}" alt="{{ auth()->user()->name }}">
                </a>
                <ul class="dropdown-menu dropdown-md">
                    <li>
                        <ul class="list-media">
                            <li class="list-item avatar-info">
                                <div class="media-img">
                                    <img src="{{ auth()->user()->profilePhotoUrl }}" alt="{{ auth()->user()->name }}">
                                </div>
                                <div class="info">
                                    <span class="title text-semibold">{{ Auth::user()->name }}</span>
                                    <span class="sub-title">{{ __('Admin') }}</span>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li>
                        <a href="{{ route('user.settings') }}">
                            <span>{{ __('Settings') }}</span>
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                <span>{{ __('Sign out') }}</span>
                            </a>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>