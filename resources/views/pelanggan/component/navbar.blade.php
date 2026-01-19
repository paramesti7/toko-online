{{-- Header --}}
<nav class="navbar navbar-dark navbar-expand-lg" style="background-color: #213555">
    <div class="container">
        <a class="navbar-brand" href="#">TOKO AMALIA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"      data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end gap-4" id="navbarSupportedContent">
            <ul class="navbar-nav gap-4">

                <li class="nav-item">
                    <a class="nav-link {{ Request::path() == '/' ? 'active' : '' }}" aria-current="page" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::path() == 'shop' ? 'active' : '' }}" href="/shop">Shop</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::path() == 'contact' ? 'active' : '' }}" href="/contact">Contact Us</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::path() == 'about' ? 'active' : '' }}" href="/about">About</a>
                </li>

                @php
                    $user = Auth::guard('web')->user();
                    // Debug: Check user status
                    // dd(['user' => $user, 'is_admin' => $user?->is_admin]);
                @endphp
                
                <!-- DEBUG: Show login status -->
                <!-- User: {{ $user ? $user->name . ' (Admin: ' . $user->is_admin . ')' : 'Not logged in' }} -->
                
                @if($user && $user->is_admin == 0)
                    <li class="nav-item">
                        <div class="select" tabindex="0" role="button">
                            <div class="text-links">
                                <div class="d-flex gap-2 align-items-center">
                                    @if($user->foto && $user->foto != 'default.png')
                                        <img src="{{ asset('storage/user/' . $user->foto) }}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;" alt="Foto {{ $user->name }}">
                                    @else
                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fa fa-user text-white"></i>
                                        </div>
                                    @endif
                                    <div class="d-flex flex-column text-white">
                                        <p class="m-0" style="font-weight: 700; font-size:14px;">{{ $user->name ?? 'User' }}</p>
                                        <p class="m-0" style="font-size:12px">{{ $user->email ?? 'email@example.com' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="links-login text-white" id="links-login">
                                <form action="{{ route('logout.pelanggan') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-white p-0">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Login | Register</button>
                    </li>
                @endif

                <li class="nav-item">
                    <div class="notif">
                        {{-- JIKA BELUM LOGIN --}}
                        @guest
                            <a href="/?login=true" class="fs-5 nav-link">
                                <i class="fa fa-bag-shopping"></i>
                            </a>
                        @endguest

                        {{-- JIKA SUDAH LOGIN --}}
                        @auth
                            <a href="/transaksi" class="fs-5 nav-link {{ Request::path() == 'transaksi' ? 'active' : '' }}">
                                <i class="fa fa-bag-shopping"></i>
                            </a>
                        
                            @if ($count > 0)
                                <div class="circle">{{$count}}</div>
                            @endif
                        @endauth
                    </div>
                </li>
                <li class="nav-item">
                    <div class="notif">
                        <a href="/checkOut" class="fs-5 nav-link {{ Request::path() == 'checkOut' ? 'active' : '' }}">
                            <i class="fa-solid fa-money-check"></i>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    $(".text-links").click(function(e) {
        e.preventDefault();
        var $linksLogin = $("#links-login");
        if ($linksLogin.hasClass("activeLogin")) {
            $linksLogin.removeClass("activeLogin");
        } else {
            $linksLogin.addClass("activeLogin");
        }
    });
</script>