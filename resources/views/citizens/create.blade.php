@extends('layouts.app')
@section('content')]

<div class="container">

    <h1>Fuqaro qo`shish</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form class="row g-3 mt-5" method="Post"    action="{{route('citizens.store')}}">
        @csrf
        <div class="col-4">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control" name="firstName" placeholder="First name">
        </div>
        <div class="col-4">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control" name="lastName" placeholder="Last name">
        </div>
        <div class="col-4">
            <label class="form-label">Patronomyc</label>
            <input type="text" class="form-control" name="patronomycName" placeholder="Patronomyc name">
        </div>
        <div class="col-4">
            <label class="form-label">Pasport</label>
            <input type="text" class="form-control" name="passport" placeholder="AA0000000">
        </div>
        <div class="col-4">
            <label class="form-label">Pin</label>
            <input type="text" class="form-control" name="pin" placeholder="00000000000000">
        </div>
        <div class="col-4">
            <label  class="form-label">Gender</label>
            <select name="gender" class="form-select">
                <option selected disabled>Choose...</option>
                <option id="1">Male</option>
                <option id="2">Female</option>
            </select>
        </div>
        <div class="col-4">
            <label class="form-label">Birthday date</label>
            <input type="date" class="form-control" name="birthday_date" placeholder="DD.MM.YYYY">
        </div>
        <div class="col-4">
            <label class="form-label">Region</label>
            <input type="text" class="form-control" name="Region" placeholder="Region">
        </div>
        <div class="col-4">
            <label class="form-label">District</label>
            <input type="text" class="form-control" name="District" placeholder="District">
        </div>
        <div class="col-4">
            <label for="inputAddress" class="form-label">Address</label>
            <input type="text" class="form-control" name="Address" placeholder="1234 Main St">
        </div>
        <div class="col-4">
            <label class="form-label">Phone number</label>
            <input type="text" class="form-control" name="Phone" placeholder="+998*########">
        </div>
        <div class="col-4">
            <label class="form-label">Disease type</label>
            <input type="text" class="form-control" name="disease_type" placeholder="Disease type">
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck">
                <label class="form-check-label" for="gridCheck">
                    Check me out
                </label>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Saqlash</button>
        </div>
    </form>
</div>

@endsection
