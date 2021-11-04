@extends('layouts.app')
<script src="{{ asset('js/app.js') }}" defer></script>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <ul>
                        <li>
                            <a href="users" target="_blank" title="Click here to marks entry">Student List</a>
                        </li>
                        <li>
                            <a href="student-create" target="_blank" title="Click here to marks entry">New Student</a>
                        </li>
                        <li>
                            <a href="api/getstudents" target="_blank" title="Click here to marks entry">Api</a>
                        </li>
                    </ul> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
