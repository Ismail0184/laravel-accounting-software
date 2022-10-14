@extends('app')

@section('htmlheader_title', 'Image')

@section('contentheader_title', 'Documentation')

@section('main-content')
<style>
.col-centered{
    float: none;
    margin: 0 auto;
}

</style>

<div class="box">
<div class="box-header">
<div class="col-md-8 col-centered">
    <div class="thumbnail pull-center">
        <img id="blah" src="#" alt="your image" />
        <div class="caption">
            <p><a href="" target="_new"></a></p>
        </div>
    </div>
    <?php 

		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		isset($_GET['vn']) && $_GET['vn']>0 ? $vno=$_GET['vn'] : $vno='';
		isset($_GET['module']) && $_GET['module']!='' ? $module=$_GET['module'] : $module='';
		
		$module!='' ? Session::put('m_name',$module) : '';
		Session::has('m_name') ? $m_name=Session::get('m_name') : $m_name='' ; 
  
  		$check=DB::table('acc_tranmasters')->where('com_id',$com_id)->where('vnumber',$vn)->first();
		isset($check) && $check->id > 0 ? $check_action=$check->check_action : $check_action=''; //echo $check->check_action;
		?>

    <form action="{{route('addentry', [])}}" method="post" enctype="multipart/form-data">
        <input type="file" name="filefield" id="imgInp">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="vnumber" value="<?php echo $vnumber ?>">
        <input type="hidden" name="module" value="<?php echo $m_name ?>">
        <input type="submit" value="Upload....">
    </form>
</div>
<div>
	
</div>
</div>
<div class="container">
 
 <h3>Document list</h>
 


 <div class="row">
        <ul class="thumbnails">
        {{ count($entries)}}
 @foreach($entries as $entry)
            <div class="col-md-2">
                <div class="thumbnail">
                    <img src="{{route('getentry', $entry->filename)}}" alt="ALT NAME" class="img-responsive" />
                    <div class="caption">
                        <p><a href="{{ url('/fileentry/get', $entry->filename) }}" target="_new">View</a></p>
                        @if($check_action!=1)<p><a href="{{ url('/fileentry/delete', $entry->id) }}">Delete</a>@endif</p>
                    </div>
                </div>
            </div>
 @endforeach
 </ul>
 </div>
 </div>
 </div>
@endsection
@section('custom-scripts')

<script type="text/javascript">
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function(){
    readURL(this);
});
</script>

@endsection