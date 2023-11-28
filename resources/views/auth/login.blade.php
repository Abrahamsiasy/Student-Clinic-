<!DOCTYPE html>
<html>

<head>
    <title>JU SIS | Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <!-- Change below bootstrap import link to use local bootstrap or official cdn -->
    <link rel="stylesheet" href="{{ asset('desk_css/bootstrap.css') }}" />

    <!-- Below is custom css for login form -->
    <link rel="stylesheet" href="{{ asset('desk_css/custom-login.css') }}" />
</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="login-wrap p-4 p-md-5">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <!-- Change below img tag to use the image from the project folder -->
                            <img src="{{ asset('desk_image/logo.png') }}" alt="JU Logo" width="100"
                                height="120" />
                        </div>
                        <h5 class="text-center mb-4">JU SIS</h5>
                        <form method="POST" action="{{ route('login') }}" class="login-form" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <input id="username" type="text"
                                    class="form-control @error('username') is-invalid @enderror" name="username"
                                    placeholder="Username" value="{{ old('username') }}" required
                                    autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>

                            <div class="form-group d-flex">
                                <input type="password" class="form-control rounded-left" placeholder="Password"
                                    name="password" required="" />
                                @error('password')
                                    <span class="" role="">
                                        <p class="text-danger">{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>

                            @if ($errors->any())
                                {!! implode('', $errors->all('<div class="text-danger">:message</div>')) !!}
                                <br />
                            @endif
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary rounded submit px-3">
                                    Login
                                </button>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50"></div>
                                <div class="w-50 text-md-right">
                                    <a href="#">Forgot Password?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
