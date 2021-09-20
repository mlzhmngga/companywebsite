<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('COMPANY_NAME') }}</title>
    <!-- 
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style> -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />

</head>

<body>
    {{ view('nbar',  ['baseUrl' => env('BASE_URL')]) }}

    <div>
        <div>
            <div style="display: flex; flex-direction:column; justify-content: center; align-items:center; height:85vh ; background-image:  url('assets/company.png'); background-size: cover; ">
                <div>
                    <h1><strong>Selamat datang di {{ env('COMPANY_NAME') }}!</strong> </h1>
                </div>

                <div class="m-5">
                    {{ env('COMPANY_DESCRIPTION') }}
                </div>
            </div>

            <!-- <img width="100%" src="assets/company.jpeg" style="opacity:0.5;z-index:0" /> -->
        </div>


        <div class="m-3">
            <div class="d-flex justify-content-center my-5">
                <h5><strong>Paket cicilan</strong></h5>
            </div>

            <div class="d-flex justify-content-around">
                <div>
                    <div>
                        <h5>Paket 1</h5>
                    </div>
                    <div>
                        Harga 164.000.000

                    </div>
                    <div>
                        Dp 5%

                    </div>
                    <div>
                        Bantuan Subsidi Uang Muka 4.000.000
                    </div>
                    <div> Plafon kredit 155.000.000
                    </div>
                </div>

                <!-- <div>
                    <div>
                        <h5>Product 2</h5>
                    </div>
                    <div>Description 2</div>
                </div>

                <div>
                    <div>
                        <h5>Product 3</h5>
                    </div>
                    <div>Description 3</div>
                </div>

                <div>
                    <div>
                        <h5>Product 4</h5>
                    </div>
                    <div>Description 4</div>
                </div> -->


            </div>

            <!-- <div>

                {{ json_encode(\App\Models\Payment::all()) }}
            </div>

            <hr />

            <div>
                {{ strlen (json_encode(\App\Models\Product::all())) }}
            </div>

            <div>
                <pre><small>
                {{ json_encode(\App\Models\Product::all()) }}

                </small></pre>

            </div>



            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Launch demo modal
            </button>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>

    </div>

    <hr />

    <div>
        <div class="d-flex justify-content-center">
            <h5>Contoh Rumah</h5>
        </div>


        <div class="d-flex my-3 justify-content-around align-items-center flex-wrap">
            <div>
                <a href="{{ asset('assets/rumah1.jpeg') }}" target="_blank">
                    <img src="{{ asset('assets/rumah1.jpeg') }}" style="max-width:300px;max-height:300px" />
                </a>
            </div>
            <div>
                <a href="{{ asset('assets/rumah2.jpeg') }}" target="_blank">
                    <img src="{{ asset('assets/rumah2.jpeg') }}" style="max-width:300px;max-height:300px" />
                </a>
            </div>
            <div>
                <a href="{{ asset('assets/rumah3.jpeg') }}" target="_blank">
                    <img src="{{ asset('assets/rumah3.jpeg') }}" style="max-width:300px;max-height:300px" />
                </a>
            </div>
            <div>
                <a href="{{ asset('assets/rumah4.jpeg') }}" target="_blank">
                    <img src="{{ asset('assets/rumah4.jpeg') }}" style="max-width:300px;max-height:300px" />
                </a>

            </div>
            <div>
                <a href="{{ asset('assets/rumah5.jpeg') }}" target="_blank">
                    <img src="{{ asset('assets/rumah5.jpeg') }}" style="max-width:300px;max-height:300px" />
                </a>
            </div>
            <div>
                <a href="{{ asset('assets/rumah6.jpeg') }}" target="_blank">
                    <img src="{{ asset('assets/rumah6.jpeg') }}" style="max-width:300px;max-height:300px" />
                </a>
            </div>


        </div>
    </div>


</body>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>


</html>