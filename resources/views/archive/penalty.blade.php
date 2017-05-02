@extends('layouts.admin')

@section('title')
Penalty
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
  <h1>Archive - Penalty</h1>
  <hr>
</div>

<div class="row">
    <a href="{{ url('/penalty') }}" class="ui brown button"><i class="arrow circle left icon"></i>Back to Penalty</a>
  </div>
<div class="row">
  <table class="ui brown table" id="tblPenalty">
    <thead>
      <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Amount</th>
        <th class="center aligned">Action</th>
      </tr>
    </thead>
    <tbody>
      @if(count($penalties) < 0)
      <tr>
        <td colspan="3"><strong>Nothing to show.</strong></td>
      </tr>
      @else
      @foreach($penalties as $penalty)
      <tr>
        <td>{{$penalty->penaltyName}}</td>
        <td>{{$penalty->penaltyDesc}}</td>
        <td>Php {{$penalty->amount}}</td>

        <td class="center aligned">
          @if($penalty->deleted_at == null)
          <button class="ui red button" onclick="$('#delete{{$penalty->penaltyCode}}').modal('show');"><i class="delete icon"></i> Deactivate</button>
          @else
          <button class="ui orange button" onclick="$('#restore{{$penalty->penaltyCode}}').modal('show');"><i class="undo icon"></i> Restore</button>
          @endif
        </td>
      </tr>
      @endforeach
      @endif	
    </tbody>
  </table>
</div>

@if(count($penalties) > 0)
@foreach($penalties as $penalty)
<div class="ui modal" id="restore{{$penalty->penaltyCode}}">
  <div class="header">Restore Penalty</div>
  <div class="content">
    <p>Do you want to Restore this penalty?</p>
  </div>
  <div class="actions">
    {!! Form::open(['url' => '/penalty/penalty_restore']) !!}
    {{ Form::hidden('penalty_code', $penalty->penaltyCode) }}
    {{ Form::button('Yes', ['type'=>'submit', 'class'=> 'ui positive button']) }}
    {{ Form::button('No', ['class' => 'ui negative button']) }}
    {!! Form::close() !!}
  </div>
</div>
@endforeach
@endif
	
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
      penalty_name: {
        identifier : 'penalty_name',
        rules: [
        {
          type   : 'empty',
          prompt : 'Please enter a penalty name'
        },
        
      {
          

        type   : "regExp[^(?![0-9 '-]*$)[a-zA-Z0-9 '-]+$]",

            
             
        prompt: "Name can only consist of alphanumeric, spaces, apostrophe and dashes"
      }
        ]
      },
      amount: {
        identifier : 'amount',
        rules: [
        {
          type   : 'empty',
          prompt : 'Please enter the valid amount'
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








    $('#penalty').addClass("active grey");
    $('#fees_content').addClass("active");
    $('#fees').addClass("active");

    var table = $('#tblPenalty').DataTable();

    $('#penaltyTypes').on("change", function(){
      var val = $( "select#penaltyTypes" ).val();

      if(val == '1'){
        document.getElementById('divItems').style.display = "block";
        document.getElementById('divNames').style.display = "none";
        alert('Hey');
        var formValidationRules =
        {


          penalty_type: {
            identifier: 'penalty_type',
            rules: [
            {
              type   : 'empty',
              prompt : 'Please select a penalty type'
            }
            ]
          },

          item_code: {
            identifier: 'item_code',
            rules: [
            {
              type   : 'empty',
              prompt : 'Please select a penalty type'
            }
            ]
          },

          amount: {
            identifier: 'amount',
            rules: [
            {
              type   : 'empty',
              prompt : 'Please enter an amount'
            }
            ]
          }



        }
        $('.ui.form').form(formValidationRules);

      }else if(val == '2'){

        document.getElementById('divItems').style.display = "block";
        document.getElementById('divNames').style.display = "none";
        alert('Hay');
        var formValidationRules =
        {


          penalty_type: {
            identifier: 'penalty_type',
            rules: [
            {
              type   : 'empty',
              prompt : 'Please select a penalty type'
            }
            ]
          },


          item_code: {
            identifier: 'item_code',
            rules: [
            {
              type   : 'empty',
              prompt : 'Please select a penalty type'
            }
            ]
          },


          amount: {
            identifier: 'amount',
            rules: [
            {
              type   : 'empty',
              prompt : 'Please enter an amount'
            }
            ]
          }



        }
        $('.ui.form').form(formValidationRules);

      }else if(val == '3'){
        document.getElementById('divItems').style.display = "none";
        document.getElementById('divNames').style.display = "block";

        alert('Hoy');
        var formValidationRules =
        {


          penalty_type: {
            identifier: 'penalty_type',
            rules: [
            {
              type   : 'empty',
              prompt : 'Please select a penalty type'
            }
            ]
          },


          penalty_name: {
            identifier: 'penalty_name',
            rules: [
            {
              type   : 'empty',
              prompt : 'Please enter a penalty name'
            }
            ]
          },


          amount: {
            identifier: 'amount',
            rules: [
            {
              type   : 'empty',
              prompt : 'Please enter an amount'
            }
            ]
          }



        }
        $('.ui.form').form(formValidationRules);


      }else{
        document.getElementById('divItems').style.display = "none";
        document.getElementById('divNames').style.display = "none";
      }
    });

    $('.money').mask("##0.00", {reverse: true});

  });

function show(val){
  if(val == '1' | val == '2'){
    document.getElementById('divItem').style.display = "block";
    document.getElementById('divName').style.display = "none";
  }else if(val == '3'){
    document.getElementById('divItem').style.display = "none";
    document.getElementById('divName').style.display = "block";
  }else{
    document.getElementById('divItem').style.display = "none";
    document.getElementById('divName').style.display = "none";
  }
}
</script>
@endsection