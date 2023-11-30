
<li class="nav-item">
    <a href="{{ route('logs.index') }}" class="nav-link {{ Request::is('logs*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Logs</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('userInfos.index') }}" class="nav-link {{ Request::is('userInfos*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>User Infos</p>
    </a>
</li>
