@extends('layouts.app')

@section('title')
رویداد جدید
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
                    <form action="{{url('user/event-new')}}" method="post" enctype="multipart/form-data">
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
                                <div class="input-field col s12">
                                    <textarea id="description" name="description" class="materialize-textarea">{{isset($oldInputs)?$oldInputs['description']:''}}</textarea>
                                    <label for="description">توضیحات</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col m6 s12 right">
                                    <input  id="phone" name="phone" type="text" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['phone']:''}}"/>
                                    <label for="phone">* شماره تماس</label>
                                </div>
                                <div class="input-field col m6 s12 right">
                                    <input type="text" id="place" name="place" class="autocomplete habitate-autocomplete"
                                    value="{{isset($oldInputs)?$oldInputs['place']:''}}"/>
                                    <label for="place">* شهر برگزاری</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col m6 s12 right">
                                    <input  id="phone" name="phone" type="text" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['phone']:''}}"/>
                                    <label for="phone">* شماره تماس</label>
                                </div>
                                <div class="input-field col m6 s12 right">
                                    <input type="text" id="place" name="place" class="autocomplete habitate-autocomplete"
                                    value="{{isset($oldInputs)?$oldInputs['place']:''}}"/>
                                    <label for="place">* شهر برگزاری</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="chips chips-autocomplete art-fields-autocomplete"></div>
                                <input hidden id="art-fields" name="art-fields" value="[]"></input>
                            </div>
                            <blockquote>
                                لطفا تاریخ شروع و پایان رویداد را ذکر کنید
                            </blockquote>
                            <div class="row"> 
                                <div class="input-field col m4 s6 right">
                                    <input  id="start_day" type="number" name="start_day" min="1" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['start_day']:''}}"/>
                                    <label for="start_day">* روز شروع</label>
                                </div>
                                <div class="input-field col m4 s6 right">
                                    <input id="start_month" type="number" name="start_month" min="1" max="12" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['start_month']:''}}"/>
                                    <label for="start_month">* ماه شروع</label>
                                </div>
                                <div class="input-field col m4 s6 right">
                                    <input id="start_year" type="number" name="start_year" min="1300" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['start_year']:''}}"/>
                                    <label for="start_year">* سال شروع</label>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="input-field col m4 s6 right">
                                    <input  id="end_day" type="number" name="end_day" min="1" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['end_day']:''}}"/>
                                    <label for="end_day">* روز پایانی</label>
                                </div>
                                <div class="input-field col m4 s6 right">
                                    <input id="end_month" type="number" name="end_month" min="1" max="12" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['end_month']:''}}"/>
                                    <label for="end_month">* ماه پایانی</label>
                                </div>
                                <div class="input-field col m4 s6 right">
                                    <input id="end_year" type="number" name="end_year" min="1300" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['end_year']:''}}"/>
                                    <label for="end_year">* سال پایانی</label>
                                </div>
                            </div>
                            <div class="file-field input-field row">
                                <div class="btn">
                                    <span>تصاویر و ضمیمه</span>
                                    <input id="images" name="images[]" type="file" multiple/>
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text"/>
                                </div>
                            </div>
                            <div class="row">
                                <button class="btn waves-effect waves-light" type="submit" >ثبت رویداد
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
function updateChips(){
    var tags = $('.art-fields-autocomplete').material_chip('data');
    $('#art-fields').val(JSON.stringify(tags.map(art_field_chip_to_text)));
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
    $('.art-fields-autocomplete').material_chip({
        placeholder: '+ حرفه های بیشتر',
        secondaryPlaceholder: 'حرفه های هنری',
        autocompleteOptions: {
            data: {
                'خوانندگی': null,
                'نوازندگی': null,
                'تئاتر': null,
                'سینما': null,
                'فیلم نامه نویسی': null,
                'گیتار': null,
                'منبت کاری': null,
                'مجسمه سازی': null,
                'نقاشی آبرنگ': null,
                'نقاشی مداد شمعی': null,
                'نقاشی': null,
                'میکس': null,
                'پیانو': null,
                'بازیگری': null,
                'صدابرداری': null,
                'دی جی': null,
                'عکاسی': null,
                'فیلم برداری': null,
                'موسیقی سنتی': null,
                'تمبک': null,
                'پانتومیم': null,
            },
            limit: 5,
            minLength: 1
        },
        data: [
            @if(isset($oldInputs))
                @foreach($oldInputs['art-fields'] as $art_field)
                    {
                        tag: '{{$art_field->title}}'
                    },
                @endforeach
            @else
                @foreach($art_fields as $art_field)
                    {
                        tag: '{{$art_field->art_field_title}}'
                    },
                @endforeach
            @endif
        ],
    });

    updateChips();
});
</script>
@endsection