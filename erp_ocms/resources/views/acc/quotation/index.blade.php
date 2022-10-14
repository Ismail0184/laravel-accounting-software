@extends('app')

@section('htmlheader_title', 'Quotations')

@section('contentheader_title', 'Quotations')

@section('main-content')
<?php use App\Models\Acc\Conditions;?>
    <div class="box">
        <div class="box-header">
        <h3 class="pull-left com">{{ $company->name }}</h3>
            @if (Entrust::can('create_quotation'))
            <a href="{{ URL::route('quotation.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Quotation</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="quotation-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['cpage_id'] }}</th>
                        <th>{{ $langs['fletter_id'] }}</th>
                        <th>{{ $langs['termcondition'] }}</th>
                        @if (Entrust::can('update_quotation'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_quotation'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($quotations as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/quotation', $item->id) }}">{{ $item->name }}</a></td>
                        <td>{{ $item->cpage->name }}</td>
                        <td>{{ $item->fletter->name }}</td>
                        <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Add Condition</button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Color And Size Breakdown Entry</h4>
                              </div>
                              {!! Form::open(['route' => 'termcondition.store', 'class' => 'form-horizontal quotations']) !!}
                              {!! Form::hidden('flag', 'modal', ['class' => 'form-control']) !!}
                              {!! Form::hidden('quotation_id', $item->id, ['class' => 'form-control', 'required']) !!}
                              <div class="modal-body">
                              <div class="width">
                             <input type="checkbox" id="selecctall"/> Selecct All
                                    @foreach($topics as $item)
                                        <h3>{{ $item->name }}</h3>
                                        <?php $conditions=Conditions::select('acc_conditions.id as id', 'acc_conditions.name as name')->leftjoin('acc_termconditions','acc_conditions.id','=','acc_termconditions.condition_id')
											  ->where('acc_conditions.topic_id',$item->id)->where('acc_termconditions.id',null)->get(); ?>

                                         @foreach($conditions as $data)
                                                <div class="form-group col-sm-12">
                                                    {!! Form::checkbox('condition[]', $data->id, null, ['class' => 'form-field']) !!}
                                                    {!! Form::label('condition', $data->name) !!}
                                                </div>
                                        @endforeach
                                    @endforeach
                              </ul>

                              </div>
                              </div>
                              <div class="modal-footer">
                              <div class="form-group col-sm-12 pul-right">
                                <div class="form-group col-sm-2">
                                    <div class="">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>    
                                </div>
                                <div class="form-group col-sm-3">
                                    <div class="">
                                        {!! Form::submit($langs['create'], ['class' => 'btn btn-primary form-control']) !!}
                                    </div>    
                                </div>
                                </div>
                              </div>
                              {!! Form::close() !!}        
                            </div>
                          </div>
                        </div>
                        <!-- End Modal -->
                        </td>
                        @if (Entrust::can('update_quotation'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('quotation.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_quotation'))
                        <td width="80">{!! Form::open(['route' => ['quotation.destroy', $item->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa', 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
                            {!!  Form::close() !!}</td>
                        @endif
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
        $("#quotation-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_quotation")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_quotation")): ?>, { "bSortable": false }<?php endif ?> ]
    	});

$('#selectall').click(function() {
    var c = this.checked;
    $(':checkbox').prop('checked',c);
});

    } );
</script>

@endsection
