<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{ config('app.name', '') }}</title>
    <!-- Styles -->
    <link href="{{ asset('bootstrap/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/design.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('datatable/datatables.min.css') }}" />
    <!-- Scripts -->
    <script src="{{ asset('bootstrap/js/jquery-latest.js') }}"></script>
    <script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('datatable/datatables.min.js') }}"></script>
    @yield('style')
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container main">
        @yield('content')
        <button onclick="scrollFunction()" id="myBtn" class="btn stdbutton rounded-circle shadow" title="Go to top">
            <span class="fa fa-angle-up "></span>
        </button>
        <!-- start showing timeout modal -->
        <div class="modal fade" id="signoutWarningModal" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <span class="fa fa-exclamation-triangle"></span>
                            Session Timeout Warning
                        </h5>
                    </div>
                    <div class="modal-body">
                       You are about to auto signout in next minute.
                       <input type="hidden" id="signoutUrl" value="" />
                       <br/><br/>
                       <div class="progress" style="height:25px;">
                            <div class="progress-bar progress-bar-animated progress-bar-striped" id="signoutPrgroessBar">
                            </div>
                       </div>
                    </div>
                    <div class="modal-footer">
                        <div class="text-right">
                            <button class="btn stdbutton" onclick="resetTimer(true);" data-dismiss="modal">
                                Stay Sign In
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end showing timeout modal -->
    </div>
    <script src="{{ asset('bootstrap/js/script.js') }}"></script>
    @yield('script')
</body>
</html>