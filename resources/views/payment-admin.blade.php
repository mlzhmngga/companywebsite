<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Payment - Admin | Company Name</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}" />


</head>

<body>
    {{ view('nbar',  ['baseUrl' => env('BASE_URL')]) }}

    <input id="users-data" value="{{ $users }}" style="display:none">
    <input id="roles-data" value="{{ $roles }}" style="display:none">

    <input id="base-url" value="{{ env('BASE_URL') }}" style="display:none">

    <div class="d-flex align-items-center m-3">
        <h1>Payment - Admin</h1>
        <div class="mx-3">
            <button class="btn btn-primary" onclick="handleSave()">
                <i class="bi bi-save"></i>Save
            </button>

        </div>

    </div>
    </div>

    <hr />

    <div>
        <div class="m-3 shadow shadow-md" id="table-users"></div>
    </div>

    <script>
        let users = []

        const baseUrl = document.querySelector('#base-url').value

        const makeDateStringUTC = (date) => {
            if (date) {
                const y = `${date.getUTCFullYear()}`
                const m = date.getUTCMonth() + 1 < 10 ? `0${date.getUTCMonth() + 1}` : `${date.getUTCMonth() + 1}`
                const d = date.getUTCDate() < 10 ? `0${date.getUTCDate()}` : `${date.getUTCDate()}`

                return `${y}-${m}-${d}`
            } else {
                return null
            }
        }

        const makeDateString = (date) => {
            if (date) {
                const y = `${date.getFullYear()}`
                const m = date.getMonth() + 1 < 10 ? `0${date.getMonth() + 1}` : `${date.getMonth() + 1}`
                const d = date.getDate() < 10 ? `0${date.getDate()}` : `${date.getDate()}`

                return `${y}-${m}-${d}`
            } else {
                return null
            }
        }



        const render = async () => {
            try {
                document.querySelector('#table-users').innerHTML =
                    `
                        <table class="table table-bordered table-striped table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Payments</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${users.map((user, i) => {
                                    return `
                                        <tr>
                                            <td>${i + 1}</td>
                                            <td>${user?.user?.name}</td>
                                            <td>${user?.user?.username}</td>
                                            <td>${user?.user?.email}</td>
                                            <td>
                                                <div>
                                                    <button onclick="addPayment(${i})" class="btn btn-primary border rounded-circle">
                                                        <i class="bi bi-plus-lg"></i>
                                                    </button>
                                                    ${user?.payments?.map((payment, j) => {
                                                        const date = payment.date ? makeDateString(new Date(payment.date)) : null;

                                                        const amountInt = isNaN(parseInt(payment.amount ?? 0)) ? 0 : parseInt(payment.amount ?? 0);
                                                        const amountWithCashback = amountInt - 10000000
                                                        const amountWithCashbackAndInterest = amountWithCashback + (amountWithCashback * 5 / 100)

                                                        return `
                                                            <div class="my-1 d-flex align-items-center">
                                                                <button class="btn btn-sm btn-danger">
                                                                    <i class="bi bi-trash"></i>
                                                                </button> 
                                                                <!-- div class="mx-1" >Payment ${j}</div -->
                                                                <div class="dropdown border  shadow mx-1">
                                                                   
                                                                    <select oninput="handleChangePayment(${i}, ${j}, event)">
                                                                        <option selected>${payment?.years ?? '0'} yr</option>
                                                                        <option value="10">10 yr</option>
                                                                        <option value="15">15 yr</option>
                                                                        <option value="20">20 yr</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mx-1 shadow px-2 py-1">
                                                                    <input value="${date}" class="form-control" type="date" oninput="handleChangePaymentDate(${i}, ${j}, event)"></input>
                                                                    <div>
                                                                        Due ${payment.date 
                                                                                    ? payment.years
                                                                                        ? (() => {
                                                                                            const paymentDate = new Date(new Date(payment.date).getTime());

                                                                                            const newDate = new Date((paymentDate.getFullYear() + payment.years ?? 0) , paymentDate.getMonth(), paymentDate.getDate());
                                                                                            

                                                                                            return Intl.DateTimeFormat(navigator?.language ?? 'en-US', {dateStyle: 'medium'}).format(newDate)
                                                                                        })()
                                                                                        : '<div class="text-danger">Select years first</div>'
                                                                                    : '<div class="text-danger">None</div>'
                                                                            }
                                                                    </div>
                                                                    <div>
                                                                        <strong  id="amount-display-years-${i}-${j}"> ${`${Intl.NumberFormat(navigator?.language ?? 'en-US', {
                                                                            style: 'currency',
                                                                            currency: 'IDR'
                                                                        }).format(isNaN(parseInt(payment?.amount ?? '')) ? 0 : parseInt((amountWithCashbackAndInterest) / (payment?.years ?? 1) / 12))} each month`
                                                                    }</strong>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="">
                                                                    note
                                                                    <textarea 
                                                                        oninput="handleChangePaymentnote(${i},${j})"  
                                                                        class="form-control" 
                                                                        placeholder="note here..." 
                                                                        id="note-${i}-${j}" 
                                                                        class="form-control"
                                                                        value="${payment?.note ?? ''}"
                                                                    >${payment?.note ?? ''}</textarea>
                                                                </div>
                                                                <div class="shadow px-2 py-1">
                                                                    <div class="form-floating">
                                                                        <input value="${payment?.amount ?? 0}" oninput="handleChangePaymentAmount(${i},${j})" type="number" id="amount-${i}-${j}" class="form-control"></input>
                                                                        <label for="amount-${i}-${j}">Amount</label>
                                                                    </div>                                                            
                                                                               
                                                                    <div id="amount-display-${i}-${j}">${Intl.NumberFormat(navigator?.language ?? 'en-US', { style: 'currency', currency: 'IDR' }).format(payment?.amount ?? 0)}</div>
                                                                    <div id="amount-display-${i}-${j}-cashback">W/cashback 10m IDR: ${Intl.NumberFormat(navigator?.language ?? 'en-US', { style: 'currency', currency: 'IDR' }).format((payment?.amount ?? 0) - 10000000)}</div>
                                                                    <div id="amount-display-${i}-${j}-interest">W/interest 5%: ${Intl.NumberFormat(navigator?.language ?? 'en-US', { style: 'currency', currency: 'IDR' }).format((payment?.amount ?? 0) - 10000000)}</div>
                                                                </div>
                                                                
                                                                <div>
                                                                    <a href="${baseUrl}/payment-admin/${payment.id}">
                                                                        <button class="btn btn-sm btn-primary">Details</button>
                                                                    </a>
                                                                    
                                                                </div>
                                                                
                                                            </div>
                                                        `;
                                                    })?.join('')}
                                                </div>
                                                
                                            </td>
                                            
                                        </tr>
                                    `
                                    }).join('')}
                            </tbody>
                        </table>
                    `

            } catch (e) {
                console.error(e)
            }
        }

        const usersStr = document.querySelector('#users-data').value;

        if (usersStr) {
            users = JSON.parse(usersStr)

            console.log(users)
            render()
        }

        const addPayment = (i) => {
            users = users.map((user, ix) => i === ix ? {

                ...user,
                payments: user?.payments ? [
                    ...user.payments,
                    {
                        amount: 0
                    }
                ] : user?.payments
            } : user)

            render()
        }

        const handleChangePaymentAmount = (i, j, e) => {
            console.log(i, j, e)
            const amount = document.querySelector(`#amount-${i}-${j}`).value

            const amountInt = isNaN(parseInt(amount)) ? 0 : parseInt(amount);
            const amountWithCashback = amountInt - 10000000
            const amountWithCashbackAndInterest = amountWithCashback + (amountWithCashback * 5 / 100)

            console.log('amountVal', amount, isNaN(parseInt(amount)))

            users = users.map((user, ix) => i === ix ? {
                ...user,
                payments: user?.payments ?
                    user.payments.map((payment, jx) => j === jx ? {
                        ...payment,
                        amount: isNaN(parseInt(amount)) ? payment?.amount : parseInt(amount)
                    } : payment) : user?.payments
            } : user)

            document.querySelector(`#amount-display-${i}-${j}`).innerHTML = Intl.NumberFormat(navigator?.language ?? 'en-US', {
                style: 'currency',
                currency: 'IDR'
            }).format(amountInt)

            document.querySelector(`#amount-display-${i}-${j}-cashback`).innerHTML = 'W/cashback 10m IDR: ' + Intl.NumberFormat(navigator?.language ?? 'en-US', {
                style: 'currency',
                currency: 'IDR'
            }).format(amountWithCashback)

            document.querySelector(`#amount-display-${i}-${j}-interest`).innerHTML = 'W/interest 5%: ' + Intl.NumberFormat(navigator?.language ?? 'en-US', {
                style: 'currency',
                currency: 'IDR'
            }).format(amountWithCashbackAndInterest)

            const foundUserPayment = users[i]?.payments[j];

            if (foundUserPayment) {
                document.querySelector(`#amount-display-years-${i}-${j}`).innerHTML = `${Intl.NumberFormat(navigator?.language ?? 'en-US', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(amountWithCashbackAndInterest / (foundUserPayment?.years ?? 0) / 12)} each month`
            }



        }

        const handleChangePaymentnote = (i, j, e) => {
            console.log(i, j, e)
            const desc = document.querySelector(`#note-${i}-${j}`).value

            console.log('desc', desc)

            users = users.map((user, ix) => i === ix ? {
                ...user,
                payments: user?.payments ?
                    user.payments.map((payment, jx) => j === jx ? {
                        ...payment,
                        note: desc
                    } : payment) : user?.payments
            } : user)

            console.log(document.querySelector(`#note-${i}-${j}`))

            document.querySelector(`#note-${i}-${j}`).value = desc
        }

        const handleChangePaymentDate = (i, j, e) => {
            console.log(i, j, e)
            const date = e.target.value

            console.log('date', e.target.value)

            users = users.map((user, ix) => i === ix ? {
                ...user,
                payments: user?.payments ?
                    user.payments.map((payment, jx) => j === jx ? {
                        ...payment,
                        date: `${date}T00:00:00`
                    } : payment) : user?.payments
            } : user)

            render()
        }



        const handleSave = async () => {
            try {
                // alert('Saving...')
                const baseUrl = document.querySelector('#base-url').value

                const resp = await fetch(`${baseUrl}/payments-save`, {
                    method: 'post',
                    headers: {
                        'content-type': 'application/json',
                        authorization: localStorage.getItem('apiKey')
                    },
                    body: JSON.stringify(users)
                })
            } catch (e) {
                console.error(e)
            }
        }

        const handleChangePayment = (i, j, e) => {
            console.log(i, j, e)
            const months = e.target.value

            users = users.map((user, ix) => i === ix ? {
                ...user,
                payments: user?.payments ?
                    user.payments.map((payment, jx) => j === jx ? {
                        ...payment,
                        years: isNaN(parseInt(months)) ? 0 : parseInt(months)
                    } : payment) : user?.payments
            } : user)

            render()
        }
    </script>
</body>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>


</html>