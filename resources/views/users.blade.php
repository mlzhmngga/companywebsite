<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Users | Company Name</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}">

</head>

<body>
    {{ view('nbar',  ['baseUrl' => env('BASE_URL')]) }}

    <input id="users-data" value="{{ $users }}" style="display:none">
    <input id="base-url" value="{{ env('BASE_URL') }}" style="display:none">

    <div class="m-3">
        <h1>Users</h1>
    </div>

    <hr />

    <div class="m-3">
        <div class="shadow shadow-md">
            <div>
                <button id="add-btn" class="btn btn-primary"><i class="bi bi-plus"></i>Add</button </div>
                <button id="save-btn" class="btn btn-success"><i class="bi bi-save"></i>Save</button </div>

                <div id="users-table" class="">

                </div>
            </div>

        </div>
        <script src="{{ asset('js/bcrypt.min.js') }}"></script>

        <script>
            let users = []

            const render = () => {
                document.querySelector('#users-table').innerHTML = `
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${users.map((user, i) => {
                            return `
                                <tr>
                                    <td>${i + 1}</td>
                                    <td>
                                        <input id="name-form-${i}" class="form-control" placeholder="Name..." value="${user?.name}" oninput="inputName(${i})">
                                    </td>
                                    <td>
                                        <input id="username-form-${i}" class="form-control" placeholder="Username..." value="${user?.username}"  oninput="inputUsername(${i})">
                                    </td>
                                    <td>
                                        <input id="email-form-${i}" class="form-control" placeholder="Email..." value="${user?.email}" oninput="inputEmail(${i})">
                                    </td>
                                    
                                    <td>
                                        <button class="btn btn-outline-success"  onclick="changePassword(${i})">Change Password</button </div>
                                    </td>
                                </tr>
                            `;
                        }).join('')}
                    </tbody>
                </table> 
                `
            }

            const usersStr = document.querySelector('#users-data').value;

            if (usersStr) {
                users = JSON.parse(usersStr)

                console.log(users)
                render()
            }

            document.querySelector('#add-btn').addEventListener('click', () => {
                users = [...users,
                    {
                        id: null,
                        username: '',
                        name: '',
                        email: `email_${new Date().getTime()}@${Math.round (Math.random() * 1000)}`
                    }
                ]

                render()
            })

            document.querySelector('#save-btn').addEventListener('click', async () => {
                try {
                    const baseUrl = document.querySelector('#base-url').value
                    const resp = await fetch(`${baseUrl}/users-save-batch`, {
                        method: 'post',
                        headers: {
                            authorization: localStorage.getItem('apiKey'),
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify(users)
                    })

                    if (resp.status !== 200) throw await resp.text()

                    alert('Save successful!')

                    window.location.reload()
                } catch (e) {
                    console.error(e)
                }

                // window.location.reload()
            })

            const inputName = (i) => {
                const val = document.querySelector(`#name-form-${i}`)?.value

                if (val) {
                    users = users.map((user, ix) => ix === i ? {
                        ...user,
                        name: val
                    } : user)
                }
            }

            const inputUsername = (i) => {
                const val = document.querySelector(`#username-form-${i}`)?.value

                if (val) {
                    users = users.map((user, ix) => ix === i ? {
                        ...user,
                        username: val
                    } : user)
                }
            }

            const inputEmail = (i) => {
                const val = document.querySelector(`#email-form-${i}`)?.value

                if (val) {
                    users = users.map((user, ix) => ix === i ? {
                        ...user,
                        email: val
                    } : user)
                }
            }

            const changePassword = (i) => {
                const pass = prompt('Please enter your new password:')

                if (pass && pass !== "") {
                    var salt = dcodeIO.bcrypt.genSaltSync(10);
                    var hash = dcodeIO.bcrypt.hashSync(pass, salt);

                    // console.log(hash)
                    // console.log(dcodeIO.bcrypt)

                    users = users.map((user, ix) => ix === i ? {
                        ...user,
                        password: hash
                    } : user)



                    alert('Password successfully changed! Don\'t forget to save.')
                } else {
                    alert('Password not changed.')
                }
            }
        </script>

</body>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>



</html>