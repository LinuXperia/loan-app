@extends('admin.layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12 ">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> <strong> NEW LOAN AGENT PROFILE</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <form action="{{ route('new.agent') }}" method="post" class="form-horizontal">

                                {{ csrf_field() }}

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label" for="hf-email">Full Name <span class="required">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="name" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Enter Agent Full Name.." value="{{ old('name') }}" >
                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label" for="email">Email Address <span class="required">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="email" id="name" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Enter Agent Email Address.." value="{{ old('email') }}" >
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label" for="phone">Phone Number <span class="required">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="number" id="name" name="phone" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="Enter Agent Phone Number..." value="{{ old('phone') }}" >
                                            @if ($errors->has('phone'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label" for="address">Agent Address </label>
                                        <div class="col-sm-9">
                                            <input type="text" id="address" name="address" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="Enter Agent Address..." value="{{ old('address') }}" >
                                            @if ($errors->has('address'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('address') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label" for="country">Country</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="country" name="country" class="form-control {{ $errors->has('country') ? ' is-invalid' : '' }}" placeholder="Enter Agent Country..." value="{{ old('country') }}" >
                                            @if ($errors->has('country'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('country') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label" for="comment">Comment</label>
                                        <div class="col-sm-9">
                                            <textarea type="text" id="comment" name="comment" class="form-control {{ $errors->has('comment') ? ' is-invalid' : '' }}" placeholder="Enter Comment..."  >{{ old('comment') ?  old('comment') : ''}}</textarea>
                                            @if ($errors->has('comment'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('comment') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 offset-3 text-center">
                                        <button type="submit" class="btn btn-info btn-block">REGISTER AGENT</button>
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