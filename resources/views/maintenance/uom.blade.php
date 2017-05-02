@extends('layouts.admin')

@section('title')
	Unit of Measurement
@endsection

@section('content')
	@if ($alert = Session::get('alert-success'))
    <div class="ui success message">
    	<div class="header">Success!</div>
    	<p>{{ $alert }}</p>
  	</div>
  	@endif
  	@if (count($errors) > 0)
	<div class="ui message">
	    <div class="header">We had some issues</div>
	    <ul class="list">
	      @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
	    </ul>
	</div>
	@endif

	<div class="row">
		<h1>Unit of Measurement</h1>
		<hr>
	</div>

	<div class="row">
		<button type="button" class="ui green button" style="background-color: rgb(0,128,0);"  onclick="$('#create').modal('show');"><i class="add icon"></i>New Unit of Measurement</button>
		<a href="{{ url('/archive/uom') }}" class="ui teal button" style="background-color: rgb(0,128,128);"><i class="archive icon"></i>Archive</a>
	</div>
	<div class="row">
		<table class="ui table" id="tbluom">
		  <thead>
		    <tr>
			    <th>Symbol</th>
			    <th>Description</th>
			    <th class="center aligned">Action</th>
		  	</tr>
		  </thead>
		  <tbody>
		  	@if(count($uoms) < 0)
		  	<tr>
		  		<td colspan="3"><strong>Nothing to show.</strong></td>
		  	</tr>
		  	@else
		  		@foreach($uoms as $uom)
			  	<tr>
			      <td>{{$uom->uomSymbol}}</td>
			      <td>{{$uom->uomDesc}}</td>
			      <td class="center aligned">
					<button class="ui blue button" onclick="$('#update{{$uom->uomCode}}').modal('show');"><i class="edit icon"></i> Update</button>
					@if($uom->deleted_at == null)
			      	<button class="ui red button" onclick="$('#delete{{$uom->uomCode}}').modal('show');"><i class="delete icon"></i> Deactivate</button>
			      	@else
			      	<button class="ui orange button" onclick="$('#restore{{$uom->uomCode}}').modal('show');"><i class="undo icon"></i> Restore</button>
			      	@endif
			      </td>
			    </tr>
		    	@endforeach
		    @endif
		  </tbody>
		</table>
	</div>

@if(count($uoms) > 0)
@foreach($uoms as $uom)
	<div class="ui modal" id="update{{$uom->uomCode}}">
	  <div class="header">Update Unit of Measurement</div>
	  <div class="content">
	   {!! Form::open(['url' => '/uom/uom_update', 'id' => 'createForm', 'class' => 'ui form']) !!}
	    	<div class="ui form">
	    		<div class="ui error message"></div>
	    		{{ Form::hidden('uom_code', $uom->uomCode) }}
	    		<div class="required field">
	    			{{ Form::label('uom_symbol', 'Symbol') }}
         			{{ Form::text('uom_symbol', $uom->uomSymbol, ['maxlength'=>'6', 'placeholder' => 'Type Unit of Measurement Symbol']) }}
	    		</div>
	    		<div class="field">
	    			{{ Form::label('uom_description', 'Description') }}
          			{{ Form::textarea('uom_description', $uom->uomDesc, ['maxlength'=>'200', 'placeholder' => 'Type Unit of Measurement Description', 'rows' => '2']) }}
	    		</div>
	    	</div>
	    	

        </div>
	  <div class="actions">
            {{ Form::button('Submit', ['type' => 'submit', 'class'=> 'ui positive button', 'style' => 'background-color: rgb(0,128,0)']) }}
            {{ Form::button('Cancel', ['type' =>'reset', 'class' => 'ui negative button']) }}
        {!! Form::close() !!}
	  </div>
	</div>

	<div class="ui modal" id="delete{{$uom->uomCode}}">
	  <div class="header">Deactivate</div>
	  <div class="content">
	    <p>Do you want to deactivate this Unit of Measurement?</p>
	  </div>
	  <div class="actions">
	  	{!! Form::open(['url' => '/uom/' . $uom->uomCode, 'method' => 'delete']) !!}
            {{ Form::button('Yes', ['type' => 'submit', 'class'=> 'ui positive button', 'style' => 'background-color: rgb(0,128,0)']) }}
            {{ Form::button('No', ['class' => 'ui negative button']) }}
        {!! Form::close() !!}
	  </div>
	</div>

	<div class="ui modal" id="restore{{$uom->uomCode}}">
	  <div class="header">Restore</div>
	  <div class="content">
	    <p>Do you want to Restore this Unit of Measurement?</p>
	  </div>
	  <div class="actions">
	  	{!! Form::open(['url' => '/uom/uom_restore']) !!}
	  		{{ Form::hidden('uom_code', $uom->uomCode) }}
            {{ Form::button('Yes', ['type' => 'submit', 'class'=> 'ui positive button', 'style' => 'background-color: rgb(0,128,0)']) }}
            {{ Form::button('No', ['class' => 'ui negative button']) }}
        {!! Form::close() !!}
	  </div>
	</div>
@endforeach
@endif

	<div class="ui modal" id="create">
	  <div class="header">New Unit of Measurement</div>
	  <div class="content">
	    {!! Form::open(['url' => '/uom', 'id' => 'createForm', 'class' => 'ui form']) !!}
	    	<div class="ui form">
	    		<div class="ui error message"></div>

	    		<div class="disabled field" >
	    			<!-- {{ Form::label('uom_code', 'Code') }} -->
         			{{ Form::hidden('uom_code', $newID, ['placeholder' => 'Type Unit of Measurement Code']) }}
	    		</div>
	    		<div class="required field">
	    			{{ Form::label('uom_symbol', 'Symbol') }}
         			{{ Form::text('uom_symbol', '', ['maxlength'=>'6', 'placeholder' => 'Type Unit of Measurement Symbol', 'autofocus' => 'true']) }}
	    		</div>
	    		<div class="field">
	    			{{ Form::label('uom_description', 'Description') }}
          			{{ Form::textarea('uom_description', '', ['maxlength'=>'200', 'placeholder' => 'Type Unit of Measurement Description', 'rows' => '2']) }}
	    		</div>
	    	</div>
	    	
        </div>
	  <div class="actions">
            {{ Form::button('Submit', ['type' => 'submit', 'class'=> 'ui positive button', 'style' => 'background-color: rgb(0,128,0)']) }}
            {{ Form::button('Cancel', ['type' =>'reset', 'class' => 'ui negative button']) }}
        {!! Form::close() !!}
	  </div>
	</div>
@endsection

@section('js')
<script>
  $(document).ready( function(){


  	$('.ui.modal').modal({
        onApprove : function() {
          //Submits the semantic ui form
          //And pass the handling responsibilities to the form handlers,
          // e.g. on form validation success
          //$('.ui.form').submit();
          console.log('approve');
          //Return false as to not close modal dialog
          return false;
        }
    });




	var formValidationRules =
	{
		uom_symbol: {
		  identifier : 'uom_symbol',
		  rules: [
			{
			  type   : 'empty',
			  prompt : 'Please enter the Symbol'
			},
			{
        

           	type   : "regExp[^(?![0-9 '-]*$)[a-zA-Z0-9 '-]+$]",

	        	
	           
				prompt: "Symbol can only consist of alphanumeric, spaces, apostrophe and dashes"
        	}
		  ]
		}
	}




	var formSettings =
	{
		onSuccess : function() 
		{
		  $('.modal').modal('hide');
		}
	}

	$('.ui.form').form(formValidationRules, formSettings);






    $('#uom').addClass("active grey");
    $('#content').addClass("active");
    $('#title').addClass("active");

    var table = $('#tbluom').DataTable();
  });
</script>
@endsection