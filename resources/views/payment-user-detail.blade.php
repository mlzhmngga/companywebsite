<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Payment - User | Company Name</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}" />


</head>

<body>
  {{ view('nbar',  ['baseUrl' => env('BASE_URL')]) }}

  <input id="base-url" value="{{ $baseUrl }}" style="display:none"></input>
  <input id="payment-data" value="{{ $payment }}" style="display:none"></input>
  <input id="payment-details-data" value="{{ $paymentDetails }}" style="display:none"></input>

  <div class="m-3">
    <div>
      <h4>Payment Details</h4>
    </div>

    <hr />

    <div id="payment-info">

    </div>

    <hr />

    <div id="payment-details-info">

    </div>


  </div>



  <script>
    const payment = JSON.parse(document.querySelector('#payment-data').value)
    const paymentDetails = JSON.parse(document.querySelector('#payment-details-data').value)

    const paymentAmount = payment?.amount ?? 0;
    const paymentAmountWithCashback = paymentAmount - 10000000;
    const paymentAmountWithCashbackAndInterest = paymentAmountWithCashback + paymentAmountWithCashback * 5 / 100;


    document.querySelector('#payment-info').innerHTML = `
      <div>
        <div>${payment?.note}</div>
        <div>${payment?.amount ? Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(payment.amount) : '0' }</div>
        <div>${payment?.years} yr</div>
        <div>Per year: ${
          paymentAmount && payment?.years 
            ? Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(paymentAmount / 12 / payment.years) 
            : Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(0)
        }</div>
        <div>Per year w/cashback: ${
          paymentAmount && payment?.years 
            ? Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(paymentAmountWithCashback / 12 / payment.years) 
            : Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(0)
        }</div>
        <div>Per year w/cashback and interest 5% ${
          paymentAmount && payment?.years 
            ? Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(paymentAmountWithCashbackAndInterest / 12 / payment.years) 
            : Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(0)
        }</div>
        
        
        <div>Payments done: <strong>${paymentDetails?.length ?? 0}/${(payment?.years ?? 0) * 12}</strong> </div>

      </div>
    `

    document.querySelector('#payment-details-info').innerHTML = `
      <ol>
        ${(paymentDetails?.map(paymentDetail => {
            return `
              <li>
                <div>
                  <div>
                    ${paymentDetail?.paymentDetail?.epoch !== null && paymentDetail?.paymentDetail?.epoch !== undefined 
                        ? Intl.DateTimeFormat(navigator.language ?? 'en-US', { dateStyle: 'full', timeZone: 'utc' }).format(paymentDetail.paymentDetail.epoch) 
                        : 'None'  
                    }
                  </div>
                </div>
                ${paymentDetail?.base64Image && paymentDetail.base64Image !== "" && paymentDetail.base64Image !== "===="
                  ? `
                      <img style="width:400px" src="data:image/png;base64,${paymentDetail.base64Image}"></img>
                    `
                  : `
                      <div>
                        <strong class="text-danger">No image</strong>
                      </div>
                    `
                }
              </li>
            `
          }) ?? []).join('')}
      </ol>
    `
  </script>

</body>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>


</html>