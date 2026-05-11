@extends('layouts.app')
@section('content')
<h1>Create New Loan</h1>
@if($errors->any())
    <div style="color:red">{{ $errors->first() }}</div>
@endif
<form method="POST" action="{{ route('loans.store') }}">
    @csrf
    <select name="employee_id" required>
        <option value="">Select Employee</option>
        @foreach($employees as $emp)
            <option value="{{ $emp->id }}">{{ $emp->name }} ({{ $emp->branch->name ?? '' }})</option>
        @endforeach
    </select>
    <select name="device_id" required>
        <option value="">Select Device</option>
        @foreach($devices as $device)
            <option value="{{ $device->id }}">{{ $device->name }} ({{ $device->type }})</option>
        @endforeach
    </select>
    <button type="submit">Loan Device</button>
</form>
@endsection