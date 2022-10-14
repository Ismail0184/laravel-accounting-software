<html>
<head>
    <title>Ajax Example</title>
</head>
<body>

    {!! Form::open(['url' => 'ajax', 'id' => 'myform']) !!}
        <div class="form-group">
            {!!  Form::label('id','id:') !!} 
            {!!  Form::text('id', null, ['class' => 'form-control']) !!} 
        </div>

        <div class="form-group">
            {!!  Form::submit('Update',['class' => 'btn btn-primary form-control']); !!} 
        </div>
    {!! Form::close() !!}

    <div id="response"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
    $("document").ready(function(){
        // variable with references to form and a div where we'll display the response
        $form = $('#myform');
        $tdate = $('#id');
        $response = $('#response');

        $form.submit(function(e){
            e.preventDefault();

            $.ajax({
                type: "POST",
                url : 'tdayex/' + tdate, // get the form action
                data : $form.serialize(), // get the form data serialized
                dataType : "json",
                success : function(data){
                    $response.html(data['id']); // on success spit out the data into response div
                }
            }).fail(function(data){
                // on an error show us a warning and write errors to console
                var errors = data.responseJSON;
                alert('an error occured, check the console (f12)');
                console.log(errors);
            });
        });

    });
</script>

</body>
</html>