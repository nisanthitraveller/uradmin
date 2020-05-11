@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Send mail
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Mail sent successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
       @endif
       @if(session('failure'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Mail sending failed.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
       @endif
        <form action="{{ route("admin.users.sendmail", [$user->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.user.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}">
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.user.fields.name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">{{ trans('global.user.fields.email') }}*</label>
                <input type="email" id="email" name="email" required="" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}">
                @if($errors->has('email'))
                    <em class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.user.fields.email_helper') }}
                </p>
            </div>
            <div class="form-group">
                <label for="subject">Subject*</label>
                <input type="text" id="subject" required="" name="subject" class="form-control">
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea id="content" name="content" class="form-control ckeditor"></textarea>
            </div>
            <div>
                 <input type="hidden" id="user_id" name="user_id" value="{{$user->id}}">
                <input class="btn btn-success" type="submit" value="Send">
            </div>
        </form>
    </div>
</div>

@endsection