@extends('app')

@section('htmlheader_title', 'Audits')

@section('contentheader_title', 'Audit Report')

@section('main-content')
	<style>
    	#ttile { width:200px}
		#vn { width:300px}
		#user { width:100px}
		#action { width:100px}
		.col1 { width:100px; text-align:right}
    </style>
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
	?>
    
    <div class="box">
        <div class="box-header">
        <table width="100%" cellspacing="5" class="table">
            <tr><td class="col1"></td><td ><h3 class="text-center" style="margin:0px; padding:0px">{{ $com_name }}</h3></td><td class="col1"></td></tr>
            <tr><td ><td class="col1"></td><div class="box-header"></div></td><td class="col1"></td></tr>
            <tr><td class="col1">To: </td><td>Top Management</td><td class="col1">Dated: {{ date('Y-m-d')}}</td></tr>
            <tr><td class="col1">Subject: </td><td>Internal Audit Report</td><td class="col1"></td></tr>
            <tr><td class="col1">Reported By: </td><td>Audit Department</td><td class="col1"></td></tr>
            <tr><td colspan="3"><p>Dear Sir(S)
            <br><br>
            It is our pleasure to submit Internal Audit Report to you. This is for your kind information that you accounts department is running with a mode of satisfaction. Following transaction(s) is/are needed to take a look for your understanding.  
            
           </p> </td></tr>
    	</table>

        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="audit-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th id="title">Account Information</th>
                        <th id="vn">Aduit Inquiry</th>
                        <th id="note">Reply</th>
                    </tr>
                </thead>
                <tbody>
                <?php $audit_action=array( ''=>'select ...', '1'=>'Audit Claim', '2'=>'Explain'); ?>
                {{-- */$x=0;/* --}}
                @foreach($audits as $item)
                    {{-- */$x++;/* --}}
                         <?php  
							$notes=''; $tmamount=''; $created_id='';
							$note=DB::table('acc_tranmasters')->where('com_id',$com_id)->where('id', $item->vnumber)->first(); 
							if (isset($note) && $note->id > 0 ):
								$notes=$note->note;
								$tmamount=$note->tmamount;
								$created_id=$note->user_id;
							endif;
						
						?>
                   <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ 'Voucher No:'.$item->vnumber }}<br>{{ 'Note: '.$notes}} <br /> {{ 'Amount:' .$tmamount }} <br> Created By : {{ $created_id }}</td>
                        <td>{{ $item->title }}<br>{{ $item->note }} <br> Inquired By : {{ $item->user_id }}</td>
                        <td>{{ $item->reply_note }}<br> Replied By : {{ $item->reply_id }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <table>
            	<tr><td>
                <br><br><br>
                	We, therefore, request you to take a nesseary action for your satisfction. Your extedning cooperation in this regard wil be hihly appreciated.
                    <br><br><br>
                    
                    Thanks and Best Regards
                    <br><br><br>
                    {{ Auth::user()->name }}
                    
                </td></tr>
                
            </table>
        </div>
    </div>

@endsection

@section('custom-scripts')


@endsection
