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
                <div class="ct-chart" id="chart"></div>
                <div class="row">
                    <table class="table table-hover text-center">
                        <thead>
                            <th class="rtl text-center">
                                ردیف
                            </th>
                            @foreach($columns as $column)
                                <th class="rtl text-center">
                                    <a href="{{$query . '&sort=' . $column->name}}">{{$column->title}}</a>
                                </th>
                            @endforeach
                            <th class="rtl text-center">
                                <a href="{{$query . '&sort=count'}}">تعداد</a>
                            </th>
                        </thead>
                        <tbody>
                            <?php 
                                $rowNumber = 1; 
                                $chart_cols = array(); 
                                $chart_vals = array();
                            ?>
                            @foreach($results as $row)
                                <tr>
                                    <td>{{$rowNumber}}</td>
                                    @foreach($row as $item)
                                        <td>{{$item}}</td>
                                        <?php $last = $item ?>
                                    @endforeach
                                </tr>    
                                <?php 
                                    $rowNumber++; 
                                    array_push($chart_cols, $rowNumber-1);
                                    array_push($chart_vals, $last);
                                ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <script>
                    @if($chart_type == 1)
                        md.startAnimationForLineChart(
                            new Chartist.Bar('.ct-chart', {
                                labels: {{json_encode($chart_cols)}},
                                series: 
                                    {{json_encode($chart_vals)}}
                                
                            }, {
                                distributeSeries: true
                            }));
                    @elseif($chart_type == 2)
                        var data = {
                            labels: {{json_encode($chart_cols)}},
                                series: 
                                    {{json_encode($chart_vals)}}
                                
                            };

                            var options = {
                            labelInterpolationFnc: function(value) {
                                return value[0]
                            },
                            height: '300px',
                            };

                            var responsiveOptions = [
                            ['screen and (min-width: 640px)', {
                                chartPadding: 30,
                                labelOffset: 100,
                                labelDirection: 'explode',
                                labelInterpolationFnc: function(value) {
                                return value;
                                }
                            }],
                            ['screen and (min-width: 1024px)', {
                                labelOffset: 80,
                                chartPadding: 20
                            }]
                            ];

                            md.startAnimationForLineChart(
                                new Chartist.Pie('.ct-chart', data, options, responsiveOptions)
                            );
                    @endif
                    
                </script>
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