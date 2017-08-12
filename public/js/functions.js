$(document).ready(function(){
    $('ul.tabs').tabs();
    $('select').material_select();
    console.log('testing...');
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
        }
    });

    $('.religion-autocomplete').autocomplete({
        data: {
            "اسلام شیعه": null,
            "اسلام سنی": null,
            "مسیحیت": null,
            "کلیمی": null,
            "زرتشتی": null,
            "رضا": null,
        },
        limit: 2,
        onAutocomplete: function(val) {
        },
        minLength: 1,
    });

    $('.habitate-autocomplete').autocomplete({
        data: {
            "رشت": null,
            "آستانه": null,
            "انزلی": null,
            "صومعه سرا": null,
            "رودسر": null,
            "لاهیجان": null,
            "جیرده": null,
        },
        limit: 2,
        onAutocomplete: function(val) {
        },
        minLength: 1,
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
        }
    });
});

function art_field_chip_to_text(chip){
    var data = {
        'خوانندگی': 1,
        'نوازندگی': 2,
        'تئاتر': 3,
        'سینما': 4,
        'فیلم نامه نویسی': 5,
        'گیتار': 6,
        'منبت کاری': 7,
        'مجسمه سازی': 8,
        'نقاشی آبرنگ': 9,
        'نقاشی مداد شمعی': 10,
        'نقاشی': 11,
        'میکس': 12,
        'پیانو': 13,
        'بازیگری': 14,
        'صدابرداری': 15,
        'دی جی': 16,
        'عکاسی': 17,
        'فیلم برداری': 18,
        'موسیقی سنتی': 19,
        'تمبک': 20,
        'پانتومیم': 21,
    };
    return {
        title : chip.tag,
        id : data[chip.tag]
    };
}

function educations_chip_to_text(chip){
    var data = {
        "دیپلم - ریاضی فیزیک": 1,
        "دیپلم - هنر": 2,
        "فوق دیپلم - نوازندگی": 3,
        "لیسانس - موسیقی": 4,
        "لیسانس - سینما": 5,
        "لیسانس - تئاتر": 6,
        "لیسانس - عکاسی": 7,
    };
    return {
        title : chip.tag,
        id : data[chip.tag]
    };
}