<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/soft-ui-dashboard-main/assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/soft-ui-dashboard-main/assets/img/favicon-fdr.png') }}">
  <title>
    Waste Application
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/soft-ui-dashboard-main/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/soft-ui-dashboard-main/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="{{ asset('assets/soft-ui-dashboard-main/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/soft-ui-dashboard-main/assets/css/soft-ui-dashboard.css') }}" rel="stylesheet" />
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body class="" style="background-image: url('{{ asset('assets/soft-ui-dashboard-main/assets/img/tp244-bg1-02.jpg') }}');background-size: cover;
background-repeat: no-repeat;height: 100vh;">
  {{-- <div class="container position-sticky z-index-sticky top-0">
    <div class="row justify-content-center">
      <div class="col-12">
      </div>
    </div>
  </div> --}}
  <main class="main-content mt-0" >
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h4 class="mb-3 text-center text-gradient text-dark">Waste Application</h4>
                  <img src="{{ asset('assets/soft-ui-dashboard-main/assets/img/logo-fdr.jpg') }}" class="img-fluid rounded mb-3" alt="">
                  @if($errors->any())
                      <div class="alert alert-danger p-1">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li class="text-white">{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                  @endif
                </div>
                <div class="card-body">
                  <form role="form" action="{{ route('authenticate') }}" method="POST">
                    @csrf
                    <label>Email</label>
                    <div class="mb-3">
                      <input type="email" class="form-control" placeholder="Email" name="email" aria-label="Email" aria-describedby="email-addon">
                    </div>
                    <label>Password</label>
                    <div class="mb-3">
                      <input type="password" class="form-control" placeholder="Password" name="password" aria-label="Password" aria-describedby="password-addon">
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                      <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-danger w-100 mt-4 mb-0">Sign in</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!--   Core JS Files   -->
  <script src="{{ asset('assets/soft-ui-dashboard-main/assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/soft-ui-dashboard-main/assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/soft-ui-dashboard-main/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/soft-ui-dashboard-main/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
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
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('assets/soft-ui-dashboard-main/assets/js/soft-ui-dashboard.min.js') }}"></script>
</body>

</html>