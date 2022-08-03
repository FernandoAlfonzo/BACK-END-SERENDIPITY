<!DOCTYPE html>
<html lang="es">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/circular-std/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/charts/chartist-bundle/chartist.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/charts/morris-bundle/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/charts/c3charts/c3.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icon-css/flag-icon.min.css') }}">
    
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

<style>
    .input-file-container {
	width: 300px;
}

.input-file {
	width: 265px;
	height: 38px;
	border: 1px solid #16858F;
	display: flex;
	flex-wrap: wrap;
	position: relative;
	border-radius: 8px;
	overflow: hidden;
}

#avatarInput {
	position: absolute;
	width: 100%;
	height: 100%;
	left: 0;
	top: 0;
	opacity: 0;
}

.input-file__name {
	width: 83%;
	display: flex;
	align-items: center;
	font-size: 12px;
	padding: 0 15px ;
	margin: 0;
	color: #16858F;
}

.input-file__button {
	width: 17%;
	font-size: 2em;
	padding: 0;
	border: none;
	background-color: #10BAB9;
	color: #ffffff;
}

.image-preview { 
	width: 70%;
	display: block;
	margin: 20px auto 0;
	border-radius: 8px;
}
</style>
    <title>SERENDIPITY</title>
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-select/css/bootstrap-select.css') }}">
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
            @include('layouts.navbar')
        <!-- ============================================================== -->
        <!-- fin del navbar -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- sidebar -->
        <!-- ============================================================== -->
            @include('layouts.sidebar')
        <!-- ============================================================== -->
        <!-- fin del sidebar -->
        <!-- ============================================================== -->
        
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content">
                    <!-- ============================================================== -->
                        <!-- view content -->
                    <!-- ============================================================== -->
                        @yield('viewContent')
                    <!-- ============================================================== -->
                        <!-- fin del content view  -->
                    <!-- ============================================================== -->
                </div>
            </div>
            <!-- ============================================================== -->
                <!-- footer -->
            <!-- ============================================================== -->
                @include('layouts.footer')
            <!-- ============================================================== -->
                <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->

    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->
    <script src="{{ asset('assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    <!-- bootstap bundle js -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <!-- slimscroll js -->
    <script src="{{ asset('assets/vendor/slimscroll/jquery.slimscroll.js')}} "></script>
    <!-- main js -->
    <script src="{{ asset('assets/libs/js/main-js.js') }}"></script>
    <!-- chart chartist js -->
    <script src="{{ asset('assets/vendor/charts/chartist-bundle/chartist.min.js') }}"></script>
    <!-- sparkline js -->
    <script src="{{ asset('assets/vendor/charts/sparkline/jquery.sparkline.js') }}"></script>
    <!-- morris js -->
    <script src="{{ asset('assets/vendor/charts/morris-bundle/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/morris-bundle/morris.js') }}"></script>
    <!-- chart c3 js -->
    <script src="{{ asset('assets/vendor/charts/c3charts/c3.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/c3charts/d3-5.4.0.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/c3charts/C3chartjs.js') }}"></script>
    <script src="{{ asset('assets/libs/js/dashboard-ecommerce.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-select/js/bootstrap-select.js') }}"></script>

    <script src="{{ asset('assets/libs/js/previewImage.js') }}"></script>
    <script src="{{ asset('assets/libs/js/dynamic-input.js') }}"></script>

    <script src="{{ asset('assets/vendor/inputmask/js/jquery.inputmask.bundle.js') }}"></script>

    <script src="{{ asset('assets/libs/js/Vue/vue.js') }}"></script>
    <script src="{{ asset('assets/libs/js/axios.js') }}"></script>

    <script src="https://kit.fontawesome.com/9c2f58db59.js" crossorigin="anonymous"></script>
    
    <script>
    $(function(e) {
        "use strict";
        $(".date-inputmask").inputmask("dd/mm/yyyy"),
        $(".phone-inputmask").inputmask("(999) 999-9999"),
        $(".international-inputmask").inputmask("+9(999)999-9999"),
        $(".xphone-inputmask").inputmask("(999) 999-9999 / x999999"),
        $(".purchase-inputmask").inputmask("aaaa 9999-****"),
        $(".cc-inputmask").inputmask("9999 9999 9999 9999"),
        $(".ssn-inputmask").inputmask("999-99-9999"),
        $(".isbn-inputmask").inputmask("999-99-999-9999-9"),
        $(".currency-inputmask").inputmask("$9999"),
        $(".percentage-inputmask").inputmask("99%"),
        $(".decimal-inputmask").inputmask({
            alias: "decimal",
            radixPoint: "."
        }),

        $(".email-inputmask").inputmask({
            mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[*{2,6}][*{1,2}].*{1,}[.*{2,6}][.*{1,2}]",
            greedy: !1,
            onBeforePaste: function(n, a) {
                return (e = e.toLowerCase()).replace("mailto:", "")
            },
            definitions: {
                "*": {
                    validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~/-]",
                    cardinality: 1,
                    casing: "lower"
                }
            }
        })
    });

    ///scrip para la imagen
    const avatarInput = document.querySelector('#avatarInput');
    const avatarName = document.querySelector('.input-file__name');
    const imagePreview = document.querySelector('.image-preview');

    avatarInput.addEventListener('change', e => {
        let input = e.currentTarget;
        let fileName = input.files[0].name;
        avatarName.innerText = `File: ${fileName}`;

        const fileReader = new FileReader();
        fileReader.addEventListener('load', e => {
            let imageData = e.target.result;
            imagePreview.setAttribute('src', imageData);
        })

        fileReader.readAsDataURL(input.files[0]);
    });
    </script>
</body>
</html>