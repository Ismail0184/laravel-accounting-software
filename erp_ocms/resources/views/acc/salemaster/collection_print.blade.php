@extends('print')

@section('htmlheader_title', 'Collection')

@section('contentheader_title', 'Party Collection')

@section('main-content')

            <table  class="table" width="100%">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['client_id'] }}</th>
                        <th class="text-right">{{ $langs['amount'] }}</th>
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                <?php $ttl=''; ?>
                @foreach($collections as $item)
                	<?php 
						$amount=$item->amount < 0 ? substr($item->amount,1) : $item->amount; 
						$amounts=$amount!='' || $amount!=0 ? number_format($amount,2) : '';
					?>
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td >{{ $item->name }}</td>
                        <td class="text-right">{{ $amounts }}</td>

                    </tr>
                     <?php 
						$ttl += $item->amount;  ?>
                @endforeach
                    <?php 
						$ttl=$ttl < 0 ? substr($ttl,1) : $ttl;
						$ttls= $ttl!='' || $ttl!=0 ? number_format($ttl,2) : '';
					?>
                    <tr>
                        <td width="50"></td>
                        <td class="text-right">Total</td>
                        <td class="text-right">{{ $ttls }}</td>

                    </tr>
                </tbody>
            </table>

@endsection
