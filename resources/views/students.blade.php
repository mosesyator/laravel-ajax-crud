<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel 8 Ajax</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" 
integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css">
</head>
<body>
<div class="container">
    <h1>students list</h1>
    <a class="btn btn-success" href="javascript:void(0)" style="float: right" id="createNewStudent">Add</a> 
    <table class="table table-bordered data-table">
    
        <thead>
    <tr>
        
        <th>No</th>
        <th>Name</th>
        <th>Email</th>
        <th>Action</th>
        
    
    </tr>    
    
    </thead> 
    <tbody></tbody>   
    
    </table>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class ="modal-title" id="modalHeading"></h4>

</div>
<div class="modal-body">
    <form id="studentForm" class="form-horizontal">
        <input type="hidden" name="student_id" id="student_id">
        <div class="form-group">
            Name:<br>
            <input type="text" class="form-control" id="name" name="name"
            placeholder="enter name"
            value=""required>
        </div>

   <div class="form-group">
        Email:<br>
        <input type="text" class="form-control" id="email" name="email"
        placeholder="enter email"
        value=""required>
    </div>
  <button type="submit" class="btn btn-primary" id="saveBtn"
  value="Create">Save</button>  
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" 
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="crossorigin="anonymous" defer></script>
   
   <!-- JavaScript Bundle with Popper -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" 
crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js " defer></script>
</body>

<script type="text/javascript"> 
//PULL DATA FROM DB/CREATE VIEW BLADE
$(function(){
    $.ajaxSetup({
        headers:{
           'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') 
        }
    });
    var table =$(".data-table").DataTable({
  serverSide:true,
  processing:true,
  ajax:"{{route('students.index')}}",
  columns:[
      {data:'DT_RowIndex',name:'DT_RowIndex'},
      {data:'name',name:'name'},
      {data:'email',name:'email'},
      {data:'action',name:'action'},
  ]  
});
//ADD BUTTON/NEW STUDENT

$("#createNewStudent").click(function(){//calls the creatnew student button using btn id
$("#studentForm").trigger("reset");//stop holding data in the form if no refresh/submitted
$('#ajaxModel').modal('show');//show the add form to the view refering modal id
$('#modalHeading').html('Add Student');//insert heaader section add student to the add btn form
$("#student_id").val('');//hidding the ids-value is empty

});//save btn start//store section
$("#saveBtn").click(function(e){//initiate click in sv btn
    e.preventDefault();
    $(this).html('save');

    $.ajax({        //call ajax store data
        data:$("#studentForm").serialize(),//get all data from student form
        url:"{{route('students.store')}}",//store data url
        type:"POST",
        dataType:'json', //pass tha datatype in json format
        success:function(data){  //save data
            $("#studentForm").trigger("reset");//empty form
            $('#ajaxModel').modal('hide');//hide the create modal form
            table.draw();//refresh the page content and add the inserted content
        },
        error:function(data){
            console.log('error:',data);
            
            $("#saveBtn").html('save');
        }
    });
});//delete function
$("body").on('click','.deleteStudent',function(){           //calls the delete student class in the dlte btn
    var Student_id=$(this).data("id"); //student id is equal to data_id in the delete btn 
    confirm("Are you sure you want to delete!");
    
// var csrf_token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type:"DELETE",
        url:"{{route('students.store')}}"+'/'+student_id,
        success:function(data){
            table.draw();
        },
        error:function(data){
            console.log('error:',data);
            
            
        }
        

    });

});//edit section
 $('body').on('click','.editStudent',function(){ //edit class
     var student_id = $(this).data('id'); //id to store the data
     $.get("{{route('students.index')}}"+"/"+student_id+"/edit",function(data){  //fetching the id and concantination
         $("modelHeading").html("Edit Student");
         $('#ajaxModel').modal('show');     //show the modal form
         $("#student_id").val(data.id);             //passing data/displaying records 
         $("#name").val(data.name);
         $("#email").val(data.email);
     });
 });
});


 </script>
</html>