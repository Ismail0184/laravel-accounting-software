@extends('app')

@section('htmlheader_title', 'Ydstripe')

@section('contentheader_title', 'Ydstripe')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $ydstripe->id }}</td>
                <td>{{ $ydstripe->name }}</td>
            </tr>
        </table>
    </div>

@endsection
