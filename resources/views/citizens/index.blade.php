@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Fuqorolar</h1>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="{{route('citizens.create')}}">
                <button class="btn btn-success" type="button">Fuqoro qo`shish</button>
            </a>
        </div>
    </div>
@endsection
