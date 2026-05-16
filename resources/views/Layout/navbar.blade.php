<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    {{-- Left navbar --}}
    <ul class="navbar-nav">

        <li class="nav-item">

            <a class="nav-link" data-widget="pushmenu" href="#">
                <i class="fas fa-bars"></i>
            </a>

        </li>

    </ul>


    {{-- Right navbar --}}
    <ul class="navbar-nav ml-auto">

        {{-- User Info --}}
        <li class="nav-item d-none d-sm-inline-block">

            <span class="nav-link">
                {{ auth()->user()->email }}
            </span>

        </li>


        {{-- Logout --}}
        <li class="nav-item">

            <form action="{{ route('logout') }}"
                  method="POST"
                  class="form-inline">

                @csrf

                <button type="submit"
                        class="btn btn-danger btn-sm">

                    <i class="fas fa-sign-out-alt"></i>
                    Logout

                </button>

            </form>

        </li>

    </ul>

</nav>
