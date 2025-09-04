<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fa fa-user"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <a href="#" class="dropdown-item"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa fa-power-off text-danger mr-2"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</li>
