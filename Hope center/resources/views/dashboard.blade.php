@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Active Loans</h1>
    
    @if(session('success'))
        <div style="color: green; background: #e6ffe6; padding: 10px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="color: red; background: #ffe6e6; padding: 10px; margin-bottom: 15px;">
            {{ session('error') }}
        </div>
    @endif

    <h2>Currently Loaned Devices</h2>
    <table border="1" cellpadding="10">
        <thead>
            <tr><th>Employee</th><th>Device</th><th>Loaned At</th><th>Action</th></tr>
        </thead>
        <tbody>
            @forelse($activeLoans as $loan)
            <tr>
                <td>{{ $loan->employee->name }}</td>
                <td>{{ $loan->device->name }}</td>
                <td>{{ $loan->loaned_at }}</td>
                <td>
                    <form method="POST" action="{{ route('loans.return', $loan->id) }}">
                        @csrf
                        <button type="submit">Return Device</button>
                    </form>
                </td>
            </tr>
            @empty
                <tr><td colspan="4">No active loans at the moment.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Pending Inspection (Returned but not yet inspected)</h2>
    <table border="1" cellpadding="10">
        <thead>
            <tr><th>Employee</th><th>Device</th><th>Returned At</th><th>Status</th></tr>
        </thead>
        <tbody>
            @forelse($pendingLoans as $loan)
            <tr>
                <td>{{ $loan->employee->name }}</td>
                <td>{{ $loan->device->name }}</td>
                <td>{{ $loan->returned_at ?? 'N/A' }}</td>
                <td>Pending Inspection</td>
            </tr>
            @empty
                <tr><td colspan="4">No devices pending inspection.</td></tr>
            @endforelse
        </tbody>
    </table>

    <br>
    <a href="{{ route('loans.create') }}">New Loan</a>
</div>
@endsection