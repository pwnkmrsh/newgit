@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Student List </div>
                <p class="align-right"></p> 
                <a href="student-create"> New Student + </a>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        
                    @endif
                    
                    <div class="card-body">
                    <form method="POST" action="{{ route('student-create') }}" enctype="multipart/form-data" aria-label="{{ __('student-store') }}">
                        @csrf
 

                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-12">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Roll No</th>
                                        <th>Class</th>
                                        <th>Obt Mark/Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>


                            <table class="table datatable-button-html5-columns">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Roll No</th>
                                <th>Class</th>
                                <th>Obt Mark/Action</th>
                            </tr>
                            </thead>
                            <tbody>
                             
                            @foreach($students as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img class="rounded-square" style="height: 90px; width: 70px;" src="{{ asset('photo/') }}/{{ $student->photo }}" alt="{{ $student->name }}" title="{{ $student->name }} {{ $student->className }}"></td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->roll_no }}</td>
                                    <td>{{ $student->className }}</td>
                                    <td> 
                                    @php $roll_no = Crypt::encrypt( $student->roll_no ); 
                                        $marks =  \App\Mark::where('roll_no', '=', $student->roll_no)->first();
                                    @endphp
                                    @if($marks['roll_no'])
                                        {{$marks['total']}}
                                    @else
                                        <a href="mark-entry/{{$student->roll_no}}/{{$student->class_id}}" target="_blank" title="Click here to marks entry">Mark Entry</a>
                                    @endif
                                     
                                </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5" >    {{ $students->links() }} </td>
                            </tr>
                            </tbody>
                        </table>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
  
<script type="text/javascript">
  $(function () {
      
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'photo', name: 'name',
                
            },
            {data: 'name', name: 'name'},
            {data: 'roll_no', name: 'roll_no'},
            {data: 'class_id', name: 'class_id'},
            {
               data: 'created_at',
               type: 'num',
               render: {
                  _: 'display',
                  sort: 'timestamp'
               }
            }
        ]
    });
      
  });
</script>
