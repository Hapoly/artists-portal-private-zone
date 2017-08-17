@extends('layouts.app')

@section('title')
{{$name}}
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
                    <p>ویرایش با موفقیت انجام شد</p>
                </div>
            </div>
        </div>
        @endif
    @endif
    <div class="row">
        <div class="col s12 m6 offset-m3">
            <div class="card-panel white">
                <div class="row">
                    <form action="{{url('admin/artist/edit/' . $id)}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col s12">
                            <div class="row"> 
                                <div class="input-field col m6 s12 right">
                                    <input  id="reg_firstname" name="first_name" type="text" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['first_name']:''}}"/>
                                    <label for="reg_firstname">* نام</label>
                                </div>
                                <div class="input-field col m6 s12 right">
                                    <input id="reg_lastname" name="last_name" type="text" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['last_name']:''}}"/>
                                    <label for="reg_lastname">* نام خانوادگی</label>
                                </div>
                            </div>

                            <div class="row"> 
                                <div class="input-field col m6 s12 right">
                                    <input  id="reg_fathername" name="father_name" type="text" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['father_name']:''}}"/>
                                    <label for="reg_fathername">* نام پدر</label>
                                </div>
                                <div class="input-field col m6 s12 right">
                                    <input id="reg_artname" name="nickname" type="text" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['nickname']:''}}"/>
                                    <label for="reg_artname">* نام هنری</label>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="chips chips-autocomplete art-fields-autocomplete"></div>
                                    <input hidden id="art-fields" name="art-fields" value="[]"></input>
                                </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" id="religion" name="religion" class="autocomplete religion-autocomplete"
                                    value="{{isset($oldInputs)?$oldInputs['religion']:''}}"/>
                                    <label for="autocomplete-input">* مذهب</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col m6 s12 right">
                                    <input id="habitate_years" name="habitate_years" type="number" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['habitate_years']:''}}"/>
                                    <label for="habitate_years">* سال های سکونت</label>
                                </div>
                                <div class="input-field col m6 s12 right">
                                    <input type="text" id="habitate_place" name="habitate_place" class="autocomplete habitate-autocomplete"
                                    value="{{isset($oldInputs)?$oldInputs['habitate_place']:''}}"/>
                                    <label for="habitate_place">* محل سکونت</label>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="input-field col m6 s12 right">
                                    <input  id="phone" type="text" name="phone" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['phone']:''}}"/>
                                    <label for="phone">* شماره تماس ثابت</label>
                                </div>
                                <div class="input-field col m6 s12 right">
                                    <input id="cellphone" type="text" name="cellphone" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['cellphone']:''}}"/>
                                    <label for="cellphone">* شماره همراه</label>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="input-field col m12 s12 right">
                                    <input id="address" type="text" name="address" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['address']:''}}"/>
                                    <label for="address">* آدرس</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="chips chips-autocomplete educations-autocomplete"></div>
                                <input hidden id="educations" name="educations" value="[]"></input>
                            </div>
                            <div class="row"> 
                                <div class="input-field col m3 s6 right">
                                    <input  id="birth_day" type="number" name="birth_day" min="1" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['birth_day']:''}}"/>
                                    <label for="birth_day">* روز تولد</label>
                                </div>
                                <div class="input-field col m3 s6 right">
                                    <input id="birth_month" type="number" name="birth_month" min="1" max="12" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['birth_month']:''}}"/>
                                    <label for="birth_month">* ماه تولد</label>
                                </div>
                                <div class="input-field col m3 s6 right">
                                    <input id="birth_year" type="number" name="birth_year" min="1300" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['birth_year']:''}}"/>
                                    <label for="birth_year">* سال تولد</label>
                                </div>
                                <div class="input-field col m3 s6 right">
                                    <input id="birth_place" type="text" name="birth_place" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['birth_place']:''}}"/>
                                    <label for="birth_place">* محل تولد</label>
                                </div>
                            </div>
                            <div class="file-field input-field row">
                                <div class="btn">
                                    <span>عکس پرسنلی</span>
                                    <input id="profile_pic" name="profile_pic" type="file"/>
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text"/>
                                </div>
                            </div>
                            <div class="file-field input-field row">
                                <div class="btn">
                                    <span>اسکن کارت ملی</span>
                                    <input id="id_card_pic" name="id_card_pic" type="file"/>
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col m6 s12">
                                    <img class="responsive-img" src="{{isset($oldInputs['profile_pic'])?url('files/' . $oldInputs['profile_pic']):url('files/' . $artist->profile)}}" />
                                </div>
                                <div class="col m6 s12">
                                    <img class="responsive-img" src="{{isset($oldInputs['id_card_pic'])?url('files/'. $oldInputs['id_card_pic']):url('files/' . $artist->id_card)}}" />
                                </div>
                            </div>
                            <div class="row">
                                <button class="btn waves-effect waves-light" type="submit" >ثبت نام
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

    console.log(tags);
    
    var tags = $('.educations-autocomplete').material_chip('data');
    $('#educations').val(JSON.stringify(tags.map(educations_chip_to_text)));

    console.log(tags);
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
            @foreach($art_fields as $art_field)
                {
                    tag: '{{$art_field->art_field_title}}'
                },
            @endforeach
        ],
    });

    $('.educations-autocomplete').material_chip({
        placeholder: '+ مدرک تحصیلی',
        secondaryPlaceholder: 'تحصیلات',
        autocompleteOptions: {
        data: {
            "دیپلم - ریاضی فیزیک": null,
            "دیپلم - هنر": null,
            "فوق دیپلم - نوازندگی": null,
            "لیسانس - موسیقی": null,
            "لیسانس - سینما": null,
            "لیسانس - تئاتر": null,
            "لیسانس - عکاسی": null,
        },
        limit: 5,
        minLength: 1
        },
        data: [
            @foreach($educations as $education)
                {
                    tag: '{{$education->education_title}}'
                },
            @endforeach
        ],
    });
    updateChips();
});
</script>
@endsection