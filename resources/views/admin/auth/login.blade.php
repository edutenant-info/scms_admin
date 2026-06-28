<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,500&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/admin-custom.css', 'resources/js/app.js'])
</head>

<body>
    <div id="login-page">
        <div class="login-bg"></div>

        <div class="login-left">
            <div class="login-brand">
                <div class="login-brand-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                <div class="login-brand-text">{{ config("app.name") }}</div>
            </div>

            <div class="login-hero">
                <h1>Manage every <em>institution</em>, unified.</h1>
                <p>
                    A multitenant platform for schools, colleges, and educational organisations. One admin console to
                    govern onboarding, masters, and platform operations.
                </p>
            </div>

            <div class="login-stats">
                <div>
                    <div class="login-stat-val">2,400+</div>
                    <div class="login-stat-label">Institutions</div>
                </div>
                <div>
                    <div class="login-stat-val">180</div>
                    <div class="login-stat-label">Organisations</div>
                </div>
                <div>
                    <div class="login-stat-val">1.2M</div>
                    <div class="login-stat-label">Students</div>
                </div>
            </div>
        </div>

        <div class="login-right">
            <div class="login-card">
                <h2>Welcome back</h2>
                <p class="subtitle">Sign in to your admin account</p>

                <form method="POST" action="{{ route('admin.login.attempt') }}">
                    @csrf

                    <div class="fg">
                        <label for="email">Email Address</label>
                        <div class="fiw">
                            <i class="fa-regular fa-envelope"></i>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="fi" placeholder="name@company.com">
                        </div>
                        @error('email')
                            <div class="login-field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="fg">
                        <label for="password">Password</label>
                        <div class="fiw">
                            <i class="fa-solid fa-lock"></i>
                            <input id="password" type="password" name="password" required class="fi"
                                placeholder="Enter your password">
                        </div>
                        @error('password')
                            <div class="login-field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="frow">
                        <label class="fchk" for="remember">
                            <input id="remember" type="checkbox" name="remember">
                            <span>Remember me</span>
                        </label>

                        <a href="#" class="flink">Forgot password?</a>
                    </div>

                    <button type="submit" class="bp">
                        <span class="btn-text">Sign in</span>
                    </button>
                </form>

                @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
                    <div class="login-error-banner">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <div class="lfooter">
                    New organisation?
                    <a href="#">Request access</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
