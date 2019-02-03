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
                    <div class="header__item"><p>5 closest bus stops</p></div>
                    <div class="header__item"><p> Schools in 20 km radius</p></div>
                    <div class="header__item"><p>Addresses</p></div>
                </div>
                <div class="table-content">
                    <div class="table-row">
                        <div class="table-data" id="busstops"></div>
                        <div class="table-data" id="schools"></div>
                        <div class="table-data" id="addresses"></div>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('export')}}" type="button" class="btn btn-default btn-cstm">Download CSV</a>
    </div>
@endsection