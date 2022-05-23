@extends('layout')
@section('title', 'User')
@section('content')


    <div class="products content-wrapper">
        <h1>Hello, {{$name ?? ''}}</h1>
        <p>email : {{$email ?? ''}}</p>
        <p class="btn-holder buttons">
{{--            <a name="logout" onclick="logoutOnClick(this)" class="btn btn-warning btn-block text-center" role="button">--}}
{{--                Logout--}}
{{--            </a>--}}
            <a class="btn btn-warning btn-block text-center" role="button" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="c-sidebar-nav-icon fas fa-sign-out-alt"></i>Logout
            </a>
        </p>
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
