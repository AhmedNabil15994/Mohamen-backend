<div class="tab-pane active"
  id="customer_order">
  <div class="invoice-content-2 bordered">
    <div class="row invoice-head">
      <div class="col-md-2 col-xs-2">
        <div class="invoice-logo">
          <center>
            <span style="background-color: ; color: #000000; border-radius: 25px; padding: 2px 14px; float: none;">
              {{ __('reservation::dashboard.reservations.datatable.paid')[$model->paid]}}
            </span>
          </center>
        </div>
      </div>
      <div class="col-md-8 col-xs-8">
        <div class="bg-light p-4 mb-2">
          <h4>بيانات الحجز</h4>
          <table class="table">
            <tr><td> التاريخ </td><td>{{date('Y-m-d / H:i:s' , strtotime($model->created_at))}}</td></tr>
            <tr><td> رقم الحجز </td><td> #{{ $model['id'] }}</td></tr>
          </table>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <h4> {{__('reservation::dashboard.reservations.datatable.user_details')}} </h4><hr>
            <div class="company-address">
              <span class="bold">
                {{__('reservation::dashboard.reservations.datatable.user')}} :
              </span>
              {{ $model->user->name ?? '---' }}
              <br />
              <span class="bold">
                {{__('reservation::dashboard.reservations.datatable.organizer_mobile')}} :
              </span>
              {{ $model->user->mobile}}
              <br />
              <span class="bold">
                {{__('transaction::dashboard.orders.show.transaction.method')}} :
              </span>
              {{ ucfirst($model->payment_method) }}
    
              <br />
            </div>
          </div>

          <div class="col-md-6">
            <h4> {{__('reservation::dashboard.reservations.datatable.lawyer_details')}} </h4><hr>
            <div class="company-address">
              <span class="bold">
                {{__('reservation::dashboard.reservations.datatable.name')}} :
              </span>
              {{ $model->lawyer->name ?? '---' }}
              <br />
              <span class="bold">
                {{__('reservation::dashboard.reservations.datatable.mobile')}} :
              </span>
              {{ $model->lawyer->mobile}}
              <br />
              
    
              <br />
            </div>
          </div>
        </div>
      </div>

      <div class="row invoice-body">
        <div class="col-xs-12 table-responsive">
          <h1>{{ __('reservation::dashboard.reservations.show.times.title') }}</h1>
          <br>

          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th class="invoice-title uppercase text-center">
                  {{__('reservation::dashboard.reservations.show.times.from')}}
                </th>
                <th class="invoice-title uppercase text-center">
                  {{__('reservation::dashboard.reservations.show.times.to')}}
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach($model->times as $key => $time)
              <tr>
                <td class="text-center sbold"> {{ $time['from']}}</td>
                <td class="text-center sbold"> {{ $time['to']}}</td>
              </tr>
              @endforeach
              <tr>
                <td class="text-center sbold">
                  {{__('total')}}
                </td>
                <td class="text-center sbold">{{ $model->total }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>




    </div>
  </div>
</div>
