@extends('layouts.app')

@section('title')
{{$title}}
@endsection

@section('back')
<li>
    <a href="{{url('admin/reports')}}">
        <i class="material-icons">keyboard_return</i>
    </a>
</li>
@endsection

@section('content')
<div class="card rtl">
    <div class="card-header" data-background-color="purple">
        <h4 class="title">{{$title}}</h4>
    </div>
    <div class="card-content">
        <form action="{{url('admin/report/' . $reportId)}}" method="get">
            <div class="row">
                <?php $rowFeul = 0; ?>
                @foreach($fields as $field)
                    <div class="col-md-{{$field->dems->md}} col-sm-{{$field->dems->sm}} col-lg-{{$field->dems->lg}} pull-right">
                        @if($field->input == 'select')
                            <div class="col-lg-{{$field->dems->title_lg}} col-md-{{$field->dems->title_md}} col-sm-12 text-center pull-right" style="margin-top: 30px;">
                                <span>{{$field->title}}</span>
                            </div>
                            <div class="col-lg-{{12-$field->dems->title_lg}} col-md-{{12-$field->dems->title_md}} col-sm-12 text-center">
                                <div class="form-group rtl col-lg-12 col-md-12">
                                    <div class="form-group" style="margin-top: 0px">
                                        <select class="form-control" name="{{$field->name}}" style="padding-top: 0px">
                                            <option value = "0">همه</option>
                                            @foreach($field->values->vars as $item)
                                                <option value="{{$item->id}}" {{isset($oldInputs)?($item->id==$oldInputs[$field->name]?'selected':''):''}}>{{$item->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @elseif($field->input == 'text')
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">{{$field->title}}</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs[$field->name]: ''}}" name="{{$field->name}}" class="form-control">
                            </div>
                        @elseif($field->input == 'number')
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">{{$field->title}}</label>
                                <input type="number" value="{{isset($oldInputs)? $oldInputs[$field->name]: ''}}" name="{{$field->name}}" class="form-control">
                            </div>
                        @elseif($field->input == 'autocomplete')
                            <div class="col-lg-{{$field->dems->title_lg}} col-md-{{$field->dems->title_md}} col-sm-12 text-center pull-right" style="margin-top: 30px;">
                                <span>{{$field->title}}</span>
                            </div>
                            <div class="col-lg-{{12-$field->dems->title_lg}} col-md-{{12-$field->dems->title_md}} col-sm-12">
                                <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                    <input type="text" id="{{$field->name}}" name="{{$field->name}}" value="{{isset($oldInputs)? $oldInputs[$field->name]: ''}}" class="form-control">
                                </div
            >                            </div>
                            <script type="text/javascript">
                                $( function() {
                                    var url = "{{url('api/' . $field->values->query)}}";
                                    $.get(url, function(data, status){
                                        var jsonRes = JSON.parse(data);
                                        console.log(jsonRes);
                                        $("#{{$field->name}}").autocomplete({
                                            source: jsonRes
                                        });
                                    });
                                });
                            </script>
                        @endif
                    </div>
                    <?php $rowFeul += $field->dems->md; ?>
                    @if($rowFeul >= 12)
                        <?php $rowFeul = 0; ?>
                        </div>
                        <div class="row">
                    @endif
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-12 col-lg-4 pull-right">
                    <button type="submit" class="btn btn-primary pull-right" style="margin-top: 3rem;">مشاهده لیست</button>
                </div>
            </div>
        </form>
        @if(isset($results))
            @if(sizeof($results) > 0)
                <div class="row">
                    <table class="table table-hover text-center">
                        <thead>
                            @foreach($columns as $column)
                                <th class="rtl text-center">
                                    <a href="{{$query . '&sort=' . $column->name}}">{{$column->title}}</a>
                                </th>
                            @endforeach
                        </thead>
                        <tbody>
                            @foreach($results as $row)
                                <tr>
                                    @foreach($row as $item)
                                        <td>{{$item}}</td>
                                    @endforeach
                                </tr>    
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="row text-center">
                    هیچ رکوردی برای گزارش دهی یافت نشد
                </div>
            @endif
        @endif
    </div>
</div>
@endsection

@section('scripts')

@endsection