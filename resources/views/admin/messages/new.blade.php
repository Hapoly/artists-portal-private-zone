@extends('layouts.app')

@section('title')
پیام جدید
@endsection

@section('content')
<div class="top-buffer row">
    @if (isset($error_type))
        @if (count($errors) > 0 && $error_type == 'fail')
        <div class="row">
            <div class="col s12 m6 offset-m3 top-buffer">
                <div class="card-panel  red darken-1 white-text">
                    <ul>
                        @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
        @if($error_type == 'done')
        <div class="row">
            <div class="col s12 m6 offset-m3 top-buffer">
                <div class="card-panel green darken-3 white-text">
                    <p>رویداد جدید ساخته شد</p>
                </div>
            </div>
        </div>
        @endif
    @endif
    <div class="row">
        <div class="col s12 m6 offset-m3">
            <div class="card-panel white">
                <div class="row">
                    <form action="{{url('admin/message-new')}}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col s12">
                            <div class="row"> 
                                <div class="input-field col m12 s12 right">
                                    <input  id="title" name="title" type="text" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['title']:''}}"/>
                                    <label for="title">* عنوان</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="chips chips-autocomplete users-autocomplete"></div>
                                <input hidden id="recievers" name="recievers" value="[]"></input>
                            </div>
                            <div class="row">
                                <form class="col s12">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea id="body" name="body" class="materialize-textarea">{{isset($oldInputs)?$oldInputs['body']:''}}</textarea>
                                            <label for="body">متن پیام</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="row">
                                <button class="btn waves-effect waves-light" type="submit" >ارسال پیام
                                </button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var t_users = {};

function user_chip_to_text(chip){
    return {
        title : chip.tag,
        id : t_users[chip.tag].id
    };
}
function updateChips(){
    var tags = $('.users-autocomplete').material_chip('data');
    $('#recievers').val(JSON.stringify(tags.map(user_chip_to_text)));
}

function userToChip(user){
    return user.first_name + ' ' + user.last_name;
}
$('.chips').on('chip.add', function(e, chip){
    updateChips();
});

$('.chips').on('chip.delete', function(e, chip){
    updateChips();
});

$('.chips').on('chip.select', function(e, chip){
    updateChips();
});

$(document).ready(function(){
    var settings = {
        "async": true,
        "crossDomain": true,
        "url": "{{url('/api/users')}}",
        "method": "GET",
        "headers": {
            "cache-control": "no-cache",
            "postman-token": "753212fa-a7c6-3d5b-b41a-2d1c23a66f4b"
        }
    }

    $.ajax(settings).done(function (response) {
        var users = JSON.parse(response);
        var dataList = {};
        for(var i=0; i<users.length; i++){
            dataList[userToChip(users[i])] = null;
            t_users[userToChip(users[i])] = users[i];
        }
        $('.users-autocomplete').material_chip({
            placeholder: '+ کاربر جدید',
            secondaryPlaceholder: 'گریندگان',
            autocompleteOptions: {
                data: dataList,
                limit: 5,
                minLength: 1
            },
            data: [
                @if(isset($oldInputs['recievers']))
                    @foreach($oldInputs['recievers'] as $reciever)
                        {
                            tag: '{{$reciever->title}}'
                        },
                    @endforeach
                @endif
                @if(isset($reciever_name))
                    {
                        tag : '{{$reciever_name}}'
                    },
                @endif
            ],
        });
    });
    updateChips();
});
</script>
@endsection