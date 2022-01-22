@extends('layouts.app')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <h5 class="text-dark font-weight-bold my-1 mr-5">
                            {{ __('Dashboard') }} </h5>
                       
                    </div>
                </div>
                 <div class="d-flex align-items-center">
                    <a href="{{ url('users/create') }}" class="btn btn-success font-weight-bolder btn-sm">
                        <i class="fa fa-list"></i> Add User
                    </a>
                </div>
 
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom gutter-b">
                    <div class="card-body data-table-container">
                        {!! Form::open(['id'=>'page-form']) !!}
                        <div class="form-group row">
                            {!! Form::label('search_name', 'Search', ['class' => 'col-form-label col-sm-1']) !!}
                            {!! Form::text('search_name', '' , ['class' => 'form-control col-sm-3 mr-2','placeholder'=>'Search by name'] ) !!}
                            <button type="button" class="btn btn-dark font-weight-bolder" id="page-button">Filter
                            </button>

                        </div>
                        {!! Form::close() !!}
                        <table class="table table-hover table-striped table-bordered data-tables"
                               data-url="{{URL::to('users/lists')}}" data-form="page" data-length="20">
                            <thead>
                            <tr>
                                <th data-orderable="false">First name</th>
                                <th data-orderable="false">Last name</th>
                                <th data-orderable="false">Email</th>
                                <th data-orderable="false">Phone</th>
                                <th data-orderable="false">Gender</th>
                                <th data-orderable="false">Options</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script>
        var link = '{{ url("users") }}';
    </script>
@endpush
@push('page-styles')

    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@push('page-js')

    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
@endpush
