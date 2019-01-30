@extends('layouts.app')
@section('content')

    <div class="sidenav">
        @foreach($postCodes as $code)
            <button class="dropdown-btn" id="{{$code->dist}}">{{$code->dist}}
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container" id="dropdown-container-{{$code->dist}}" style="color:white">
            </div>
        @endforeach

    </div>

    <div class="main">
        <div class="container">
            <div class="table">
                <div class="table-header">
                    <div class="header__item"><a id="name" class="filter__link" href="#">5 closest bus stop</a></div>
                    <div class="header__item"><a id="wins" class="filter__link filter__link--number" href="#">Schools in 20 km radius</a></div>
                    <div class="header__item"><a id="draws" class="filter__link filter__link--number" href="#">Addresses</a></div>
                </div>
                <div class="table-content">
                    <div class="table-row">
                        <div class="table-data">Tom</div>
                        <div class="table-data">2</div>
                        <div class="table-data">0</div>
                    </div>
                    <div class="table-row">
                        <div class="table-data">Dick</div>
                        <div class="table-data">1</div>
                        <div class="table-data">1</div>
                    </div>
                    <div class="table-row">
                        <div class="table-data">Harry</div>
                        <div class="table-data">0</div>
                        <div class="table-data">2</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection