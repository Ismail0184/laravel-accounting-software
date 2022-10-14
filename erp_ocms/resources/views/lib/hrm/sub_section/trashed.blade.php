@extends('app')

@section('htmlheader_title', 'Trashed Sub Sections')

@section('contentheader_title', 'Trashed Sub Sections')

@section('main-content')

    <div class="box">
        <div class="box-header">
            <a href="{{ URL::route('sub-section.index') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['back_to'] }} Sub Sections</a>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="sub_section-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($sub_sections as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->name }}</td>
                        <td width="80">{!! Form::open(array('action' => array('Lib\Hrm\SubSectionController@restore', $item->id))) !!}
                            {!! Form::submit($langs['restore'], ['class' => 'btn btn-warning btn-block', 'onclick' => 'return confirm("Are you sure?");']) !!}
                            {!!  Form::close() !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('custom-scripts')

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#sub_section-table").dataTable({
    		"aoColumns": [ null, null, { "bSortable": false } ]
    	});
    } );
</script>

@endsection
