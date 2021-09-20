<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login </title>
    <!-- 
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style> -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

</head>

<body>
    <input id="base-url" value="{{ $baseUrl }}" style="display:none"></input>

    <div class="vh-100 bg-light d-flex justify-content-center align-items-center">
        <div class="p-3 shadow shadow-md rounded-3">
            <div class="mb-3">
                <a href="{{  url('/') }}">
                    <button class="btn btn-outline-primary"><i class="bi bi-chevron-left"></i> Back</button>

                </a>
            </div>

            <div class="d-flex justify-content-center">
                <h5>{{ env('COMPANY_SHORT_NAME') }} Login</h5>

            </div>


            <form id="login-form">
                <div class="my-2">
                    <input id="username-input" class="form-control" placeholder="Username.." />
                </div>
                <div class="my-2">
                    <input id="password-input" type="password" class="form-control" placeholder="Password.." />
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>

            </form>
        </div>
    </div>



    <script>
        document.querySelector('#login-form').addEventListener('submit', async (e) => {
            try {
                e.preventDefault()

                const baseUrl = document.querySelector('#base-url').value

                const resp = await fetch(`${baseUrl}/auth-login`, {
                    method: 'post',
                    headers: {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify({
                        username: document.querySelector('#username-input').value,
                        password: document.querySelector('#password-input').value
                    })
                })

                if (resp.status !== 200) throw await resp.text()

                localStorage.setItem('apiKey', (await resp.json())?.token)
                window.location = baseUrl
            } catch (e) {
                alert(e)
                console.log(e)
            }
        })
    </script>
</body>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>


</html>