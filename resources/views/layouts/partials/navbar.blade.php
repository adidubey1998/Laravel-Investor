<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container-fluid">

        <a class="navbar-brand" href="https://www.lemontreehotels.com/">
            <img src="https://www.lemontreehotels.com/kimages/logo.png">
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav m-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Hotels</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Offers</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Rewards</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
            </ul>

            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                    Login
                </a>
            @endauth
        </div>

    </div>
</nav>
