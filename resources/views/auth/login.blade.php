<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{ Helper::title() }} - Login </title>
    <link rel="stylesheet" href="{{ asset('ui/css/boostrap-min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('ui/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('ui/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('ui/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('ui/fonts') }}">
	<style>
		.message-container {
			font-weight: 600;
			text-align: center;
			transition: cubic-bezier(0.165, 0.84, 0.44, 1);
		}

		.message-container-error {
			background-color: red;
			color: white;
            transition: opacity 0.4s ease;
		}
	</style>
</head>

<body>
    <!-- header content Start-------------------------------------------->
   
    <!-- header content End---------------------------------------------->
   <section class="login-contain">
        <div class="login-block">
			<div class="message-container
            @if ($errors->has('password') || session()->has('error') || $errors->has('phone_number'))
                message-container-error
            @endif
            ">
											@if ($errors->has('phone_number'))
                                                {{ $errors->first('phone_number') }}
                                            @elseif ($errors->has('password'))
                                                {{ $errors->first('password') }}
											@elseif(session()->has('error'))
												{{ session()->get('error') }}
											@endif
			</div>
            <div class="container-fluid p-0">
                <div class="row g-0 split-row">
                    <div class="col-lg-6 left-panel  d-lg-flex">
                        <div class="brand-wrap">
                            <div class="brand-box">
                                <img src="{{ asset('ui/images/stoutes_logo.png') }}" alt="Logo" class="brand-logo">

                                <div class="brand-headline txt-18 mt-3 mb-5">OTA Rates & Availability Management</div>

                                <ul class="log-ul">
                                    <li>
                                        <h3>Multi-OTA Integration</h3>
                                        <p>Manage rates across Car trawler, Auto Europe, Booking Group & more</p>
                                    </li>
                                    <li>
                                        <h3>Real Time Sync</h3>
                                        <p>Instant updates & synchronization across all platforms</p>
                                    </li>
                                    <li>
                                        <h3>Analytics & Reporting</h3>
                                        <p>Comprehensive insights to optimize performance</p>
                                    </li>
                                </ul>
                           </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-12 right-panel">
                        <div class="login-card">

                            <h1 class="welcome">Welcome back!</h1>
                            <p class="lead">Sign in to continue</p>
                            <form action="{{ route('login') }}" method="POST"> @csrf
                                <div class="mb-4">
                                    <input type="email" class="form-control" placeholder="Email Address" name="email" aria-label="Email Address" required>
                                </div>

                               <div class="mb-4 eys-pass">
                                    <input type="password" class="form-control password-field" name="password" placeholder="Password" required>

                                    <div class="pas-img">
                                        <img src="{{ asset('ui/images/View-Password.svg') }}" class="show-pass" alt="Show Password">
                                        <img src="{{ asset('ui/images/Vector(2).svg') }}" class="hide-pass" alt="Hide Password">
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="rememberCheck" value="remember-me" name="remember" style="border-radius:4px;" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label text-white-50" for="rememberCheck"> Remember me </label>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="small-link">Forgot Password?</a>
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn login-btn">Login</button>
                                </div>

                                <div class="text-center" style="font-size:0.95rem; color: rgba(255,255,255,0.9);">
                                    <small>Secured by ECC 256 bit ssl encryption.</small>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
   </section>

    <script src="{{ asset('ui/js/Jquery-min.js') }}"></script>
    <script src="{{ asset('ui/js/boostrap-min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
          const passField = document.querySelector('.password-field');
            const showIcon = document.querySelector('.show-pass');
            const hideIcon = document.querySelector('.hide-pass');

            showIcon.addEventListener('click', function () {
                passField.type = "text";
                showIcon.style.display = "none";
                hideIcon.style.display = "block";
            });

            hideIcon.addEventListener('click', function () {
                passField.type = "password";
                hideIcon.style.display = "none";
                showIcon.style.display = "block";
            });
        });
</script>
</head>

</body>

</html>