@extends('layouts.app')

@section('content')
 <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <h5 class="text-dark font-weight-bold my-1 mr-5">
                            {{ Str::title($page->title) }} </h5>
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ url('home') }}" class="text-muted">
                                    Home </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="javascript:" class="text-muted">
                                    {{ Str::title($page->title) }} </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ url($page->link) }}" class="btn btn-success font-weight-bolder btn-sm">
                        <i class="fa fa-list"></i> List {{ Str::title($page->title) }}
                    </a>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ empty($user)?'Create':'Edit' }}
                            {{ Str::singular(Str::title($page->title)) }}
                        </h3>
                    </div>
                    <!--begin::Form-->
                    {!! Form::open(['url' => $page->form_url, 'method' => $page->form_method, 'class'=>'ajax-submit','id'=>'product-form']) !!}
                    <div class="card-body">
                        <div class="form-group row">
                            {!! Form::label('first_name', 'First name*', ['class' => 'col-sm-2 col-form-label text-alert']) !!}
                            <div class="col-sm-4">
                                {!! Form::text('first_name', $user->first_name ?? '', ['class' => 'form-control form-control-lg mb-2','placeholder'=>'First Name']) !!}
                                <div class="error" id="first_name_error"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('last_name', 'Last name*', ['class' => 'col-sm-2 col-form-label text-alert']) !!}
                            <div class="col-sm-8">
                                {!! Form::text('last_name', $user->last_name ?? '', ['class' => 'form-control form-control-lg mb-2','placeholder'=>'Last Name']) !!}
                                <div class="error" id="last_name_error"></div>
                            </div>
                        </div>
                         <div class="form-group row">
                            {!! Form::label('email', 'Email*', ['class' => 'col-sm-2 col-form-label text-alert']) !!}
                            <div class="col-sm-8">
                                {!! Form::text('email', $user->email ?? '', ['class' => 'form-control form-control-lg mb-2','placeholder'=>'Email']) !!}
                                <div class="error" id="email_error"></div>
                            </div>
                        </div> 
                        <div class="form-group row">
                            {!! Form::label('phone', 'Phone*', ['class' => 'col-sm-2 col-form-label text-alert']) !!}
                            <div class="col-sm-8">
                                {!! Form::text('phone', $user->phone ?? '', ['class' => 'form-control form-control-lg mb-2','placeholder'=>'Phone']) !!}
                                <div class="error" id="phone_error"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                         {!! Form::label('gender', 'Gender*', ['class' => 'col-sm-2 col-form-label text-alert']) !!}
                            <div class="col-sm-8">
                                {!! Form::select('gender', array('0' => 'Male', '1' => 'Female') , $user->gender ?? '' , ['class' => 'form-control form-control-lg mb-2','placeholder'=>'Select A Gender']) !!}
                                <div class="error" id="gender_error"></div>
                            </div>
                        </div>
                       
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2">Submit
                        </button>
                    </div>
                {!! Form::close() !!}
                <!--end::Form-->
                </div>
            </div>
        </div>
    </div>


@endsection

@push('page-scripts')
    <script>
      
    </script>
@endpush
@push('page-styles')

   
@endpush
@push('page-js')

 
@endpush