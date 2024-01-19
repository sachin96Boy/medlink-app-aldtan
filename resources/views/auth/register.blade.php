<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../assets/img/favicon.png">
    <title>Sign up </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../../assets/css/soft-ui-dashboard.css?v=1.0.8" rel="stylesheet" />
    <link href="../../assets/css/custome.css" rel="stylesheet" />

</head>

<body>
    <main class="main-content  mt-0">
        <section>
            <div class="page-header bg-image min-vh-100"
                style="background-image: url(../../assets/img/healthcare2.jpg)">
                <div class="container">

                    <div class="card">

                        <div class="card-header text-left" style= "background-color: lightblue;">
                            <center>
                                <h4 class="font-weight-bolder">Medlink</h4>
                            </center>
                        </div>
                        <div
                            class="d-flex flex-column flex-lg-row pb-3 align-items-center justify-content-center gap-3">
                            <div class="col-md-8 col-lg-5 col-xl-5">
                                <img Src="{{ asset('assets/img/healthcare1.jpg') }}"
                                    class="img-fluid object-fit-cover" alt="...">

                            </div>
                            <div class="card-body col-md-8 col-lg-6 col-xl-4">

                                <form role="form" method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="row mb-3 d-flex flex-row-reverse ">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <input placeholder="Name" id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}" required autocomplete="name" autofocus>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3 d-flex flex-row-reverse ">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <input placeholder="Email" id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3 d-flex flex-row-reverse ">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <input placeholder="Password" id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3 d-flex flex-row-reverse ">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <input placeholder="Confirm Password" id="password-confirm" type="password"
                                                class="form-control" name="password_confirmation" required
                                                autocomplete="new-password">
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="text-center pt-0 px-sm-4 px-1">
                            <p class="mb-4 mx-auto">
                                Already have an account?
                                <a href="{{ route('login') }}" class="text-info text-gradient font-weight-bold">Sign
                                    in</a>
                            </p>
                        </div>
                        <div
                            class="card-footer d-flex flex-column flex-md-row align-items-center text-center justify-content-between">
                            <p>copyright ©️2023 Medlink. All right reserved</p>
                            <p>Developed by ALDTAN</p>
                        </div>

                    </div>

                </div>
            </div>
        </section>
    </main>
    <!--   Core JS Files   -->
    <script src="../../assets/js/core/popper.min.js"></script>
    <script src="../../assets/js/core/bootstrap.min.js"></script>
    <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <!-- Kanban scripts -->
    <script src="../../assets/js/plugins/dragula/dragula.min.js"></script>
    <script src="../../assets/js/plugins/jkanban/jkanban.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="../../assets/js/soft-ui-dashboard.min.js?v=1.0.8"></script>
</body>

</html>
