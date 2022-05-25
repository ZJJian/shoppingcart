@extends('layout')
@section('title', 'User')
@section('content')


    <div class="products content-wrapper">
        <h1>Hello, {{$name ?? ''}}</h1>
        <p>email : {{$email ?? ''}}</p>
        <p class="btn-holder buttons">
            <a class="btn btn-warning btn-block text-center" role="button" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="c-sidebar-nav-icon fas fa-sign-out-alt"></i>Logout
            </a>
        </p>
        <div class="cart content-wrapper">
            @if(!empty($order))
            <table>
                <thead>
                <tr>
                    <td style="width:25%;">Order</td>
                    <td style="width:25%;">Price</td>
                    <td style="width:25%;">Status</td>
                    <td style="width:25%;">Create Date</td>
                </tr>
                </thead>
                <tbody>
                    @foreach ($order as $ord)
                        <tr>
                            <td class="price">{{$ord['order_id']}}</td>
                            <td class="price">&dollar;{{$ord['total_price']}}</td>
                            <td class="status">{{$ord['status']}}</td>
                            <td class="create_date">{{$ord['created_at']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

@endsection


<script>
    function logoutOnClick(selectObject) {
        var sku = selectObject.name;
        console.log(selectObject.name);

        $.ajaxSetup({
            headers:
                {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

        $.ajax({
            type: 'post',
            url: '{{ route('logout', false) }}/',
            data: {},
            dataType: 'json',
            success: function (response) {
                if(response.results.status !== 200){
                    alert(response.results.msg);
                }
                location.reload(true);
            },

            error: function (XMLHttpRequest) {
                alert(JSON.stringify(XMLHttpRequest));
            }
        });
    }

</script>
