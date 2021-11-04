@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Marks Entry</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        
                    @endif
                    
                    <div class="card-body">
                    <form method="POST" action="{{ route('mark-entry') }}" enctype="multipart/form-data" aria-label="{{ __('student-store') }}">
                        @csrf 
                        <b>Student Roll No.</b> <input type="text" readonly name="roll_no" value="{{$roll_no}}">

                        <div class="form-group row">
                            <table>
                            @foreach($subjects as $key=>$subject)
                            <tr>
                                <td>{{$subject->subjectName}} 
                                <input type="hidden" name="row[{{$key}}][s2]" class="form-control s2" id="s2" value="{{ $subject['id'] }}">

                                
                                </td>
                                <td><div class="col-md-12"> 
                                 <input type="number" name="row[{{$key}}][s1]" class="form-control obtMark" id="obtMark" value="{{ $subject['s1'] }}" onkeyup="sum()" min="0" max="{{$subject->maxMark}}"  required>

                            </div></td>
                            <td></td>
                            </tr>
                            @endforeach
                            <tr>
                                <td>
                                Total Obtained Marks: <input type="text" readonly name="total" value="" id="result">
                                <input type="hidden" name="class_id" value="{{$subject->my_class_id}}">
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                    <br>
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Save Marks') }}
                                        </button>
                                    </div>
                                </div>
                                </td>
                            </tr>
                        </div>

                       
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    window.sum= () =>  document.getElementById('result').value=    
    Array.from(document.querySelectorAll('#obtMark')).map(e=>parseInt(e.value)||0)
   .reduce((a,b)=>a+b,0);
    </script>
