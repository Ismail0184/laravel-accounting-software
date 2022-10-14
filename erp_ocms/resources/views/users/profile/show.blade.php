@extends('app')

@section('htmlheader_title', $profile->name)

@section('contentheader_title', $profile->name)

@section('main-content')
<div class="col-md-4">
<div class="box box-primary">
    <div class="box-body box-profile">
        <h3 class="profile-username">{{ $profile->name }}</h3>
        <p class="text-muted">{{ $langs['department'] }} : {{ $profile->department->name }}</p>
        <p class="text-muted">{{ $langs['email'] }} : {{ $profile->email }}</p>
        
        <a href="{{ url('/profile/'.$profile->id.'/edit') }}" class="btn btn-primary btn-sm">{{ $langs['edit'] }}</a>
    </div><!-- /.box-body -->
</div>
</div>
<div class="col-md-4">
    <div class="box box-primary">
        <div class="box-body box-image">
            @if($profile->user_img)
                <img class="user-img" src="{{ asset('/images/user_img/'.$profile->user_img) }}" alt="{{ $profile->name }}" />
            @endif
            @if($profile->user_sign)
                <img class="user-sign" src="{{ asset('/images/user_sign/'.$profile->user_sign) }}" alt="{{ $profile->name }}" />
            @endif
        </div>
    </div>
</div>

@endsection
