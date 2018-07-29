@extends('layouts.app')

@section('content')


    <style type="text/css">
        .test{
            border: 1px solid black;
            height: 300px;
            margin-bottom: 8px;
            overflow: scroll;
            padding: 5px;
        }


        border: 1px solid black;height: 300px;margin-bottom: 8px;overflow: scroll;padding: 5px;
    </style>

    <div class="container spark-screen">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Chat Message Module</div>

                    <div class="panel-body">

                        <div class="row">
                            <div class="col-lg-8" >
                                <div id="messages" class="test" style="border: 1px solid black;height: 300px;margin-bottom: 8px;overflow: scroll;padding: 5px;"></div>
                            </div>
                            <div class="col-lg-8" >
                                <form id="chat" action="sendmessage" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                    <input type="hidden" name="user" value="{{ Auth::user()->name }}" >
                                    <textarea class="form-control msg"></textarea>
                                    <br/>
                                    <input type="button" value="Send" class="btn btn-success send-msg">
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
    <script>


        $( document ).ready(function() {
            console.log('started');
            var socket = io.connect('http://localhost:8890');

            socket.on('message', function (data) {
                data = jQuery.parseJSON(data);
                console.log(data.user);
                console.log('inside');
                $( "#messages" ).append( "<strong>"+data.user+":</strong><p>"+data.message+"</p>" );
            });

            $('.msg').keypress(function (e) {
                if (e.which == 13) {
                    $('.send-msg').click();
                    return false;    //<---- Add this line
                }
            });


        $(".send-msg").click(function(e){

            e.preventDefault();
            var token = $("input[name='_token']").val();
            var user = $("input[name='user']").val();
            var msg = $(".msg").val();

            if(msg != ''){
                $.ajax({
                    type: "POST",
                    url: '{!! URL::to("sendmessage") !!}',
                    dataType: "json",
                    data: {'_token':token,'message':msg,'user':user},
                    success:function(data){
                        console.log(data);
                        $(".msg").val('');
                    }
                });
            }else{
                alert("Please Add Message.");
            }
        })
        });
    </script>
@endsection
