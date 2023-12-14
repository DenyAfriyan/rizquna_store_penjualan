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
  <!-- Date Range picker -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/soft-ui-dashboard-main/assets/css/soft-ui-dashboard.css') }}" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="{{ asset('assets/soft-ui-dashboard-main/assets/js/plugins/jquery-3.7.0.js') }}"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body class="g-sidenav-show  bg-gray-100">
  @include('layouts.sidebar')
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    @include('layouts.header')
    <!-- End Navbar -->
    <div class="container-fluid py-4" style="min-height: 75vh">
      {{-- main --}}
      @yield('content')
      @include('layouts.footer')
    </div>
  </main>
  <!--   Core JS Files   -->
  <script src="{{ asset('assets/soft-ui-dashboard-main/assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/soft-ui-dashboard-main/assets/js/plugins/bootstrap-datepicker.js') }}"></script>
  <script src="{{ asset('assets/soft-ui-dashboard-main/assets/js/core/bootstrap.min.js') }}"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script src="{{ asset('assets/soft-ui-dashboard-main/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/soft-ui-dashboard-main/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/soft-ui-dashboard-main/assets/js/plugins/chartjs.min.js') }}"></script>
  <script src="{{ asset('assets/soft-ui-dashboard-main/assets/js/plugins/dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/soft-ui-dashboard-main/assets/js/plugins/dataTables.bootstrap5.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
  @yield('custom_script')
</body>

</html>