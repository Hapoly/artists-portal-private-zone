<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Auth;

class Reports extends Controller
{
    /* ========================================================================
                                using a report form
       ======================================================================== */
    public function use(Request $request, $id){
        $report = DB::table('reports')
                    ->where('id', '=', $id)
                    ->first();
        $group_code = Auth::user()->group_code;
        $title = $report->title;

        if($report == Null){
            return view('errors.custom', [
                'group_code'    => $group_code,
                'status'        => 404,
                'message'       => 'فرم گزارشگیری مورد نظر یافت نشد!']);
        }

        $properties = json_decode($report->properties);
        $columns = $properties->columns;
        $fields = $properties->fields;

        for($i=0; $i<sizeof($fields); $i++){
            if($fields[$i]->input == 'select'){
                if($fields[$i]->values->type == 'refrenced'){
                    $fields[$i]->values->vars = 
                        DB::table(
                                $fields[$i]->values->table)
                            ->get();
                }
            }
        }
        
        for($i=0; $i<sizeof($columns); $i++){
            if($columns[$i]->values->type == 'refrenced'){
                $columns[$i]->values->vars = 
                    DB::table(
                            $columns[$i]->values->table)
                        ->get();
            }
        }
        
        if(sizeof($request->all())){
            return $this->usePost(
                $request,
                $id,
                $group_code,
                $report->title,
                $columns,
                $report->chart_type,
                $fields,
                $report->type);
        }else{
            return $this->useGet(
                $request,
                $id,
                $group_code,
                $report->title,
                $columns,
                $report->chart_type,
                $fields,
                $report->type);
        }
    }
    private function usePost($request, $id, $group_code, $title, $columns, $chart_type, $fields, $reportType){
        /* preparing the query to run */
        $results = DB::table('employees');

        $columnsArray = array();
        $lastColumn = '';
        foreach($columns as $column){
            array_push($columnsArray, $column->name);
            $lastColumn = $column->name;
        }

        $whereArray = array();
        foreach($fields as $field){
            $fieldName = $field->name;
            $fieldType = $field->input;
            if($request->has($fieldName)){
                $input = $request->input($fieldName);
                if($fieldType == 'select'){
                    if($input == '0')
                        continue;
                }else if($fieldType == 'autocomplete'){
                    $input = DB::table($field->values->table)
                                ->where('title', '=', $input)
                                ->first()->id;
                }
                array_push($whereArray, [$fieldName, '=', $input]);
            }
        }

        if($reportType == 1){
            $results = DB::table('employees')
                        ->select(DB::raw(implode(', ', $columnsArray) . ", count($lastColumn) as count"));

            foreach($columnsArray as $group){
                $results = $results->groupBy($group);
            }

            $results = $results->where($whereArray);
            
            if($request->has('sort')){
                $results = $results->orderBy($request->input('sort'));
            }
            
            $results = $results->get();

            for($i=0; $i<sizeof($results); $i++){
                foreach($columns as $column){
                    if($column->values->type == 'direct')
                        continue;

                    $columnName = $column->name;
                    $results[$i]->{$columnName} = DB::table($column->values->table)
                            ->where('id', '=', $results[$i]->{$columnName})
                            ->first()
                            ->title;
                }
            }
            
            return view('admin.reports.count-base', [
                    'group_code'    => $group_code,
                    'reportId'      => $id,
                    'title'         => $title,
                    'columns'       => $columns,
                    'chart_type'    => $chart_type,
                    'fields'        => $fields,
                    'oldInputs'     => $request->all(),
                    'results'       => $results,
                    'query'         => $this->generateQuery($request),
                ]);
        }else if($reportType == 2){
            $results = DB::table('employees')
                        ->select($columnsArray);
                        
            if($request->has('sort')){
                $results = $results->orderBy($request->input('sort'));
            }

            $results = $results->where($whereArray);
            $results = $results->get();

            for($i=0; $i<sizeof($results); $i++){
                foreach($columns as $column){
                    if($column->values->type == 'direct')
                        continue;
                    
                    $columnName = $column->name;
                    $results[$i]->{$columnName} = DB::table($column->values->table)
                            ->where('id', '=', $results[$i]->{$columnName})
                            ->first()
                            ->title;
                }
            }
            
            return view('admin.reports.list-base', [
                    'group_code'    => $group_code,
                    'reportId'      => $id,
                    'title'         => $title,
                    'columns'       => $columns,
                    'chart_type'    => $chart_type,
                    'fields'        => $fields,
                    'results'       => $results,
                    'oldInputs'     => $request->all(),
                    'query'         => $this->generateQuery($request),
                ]);
        }
    }
    private function useGet($request, $id, $group_code, $title, $columns, $chart_type, $fields, $reportType){
        if($reportType == 1){
            return view('admin.reports.count-base', [
                    'group_code'    => $group_code,
                    'reportId'      => $id,
                    'title'         => $title,
                    'columns'       => $columns,
                    'chart_type'    => $chart_type,
                    'fields'        => $fields,
                    'query'         => $this->generateQuery($request),
                ]);
        }else if($reportType == 2){
            return view('admin.reports.list-base', [
                    'group_code'    => $group_code,
                    'reportId'      => $id,
                    'title'         => $title,
                    'columns'       => $columns,
                    'chart_type'    => $chart_type,
                    'fields'        => $fields,
                    'query'         => $this->generateQuery($request),
                ]);
        }
    }

    private function generateQuery(Request $request){
        $fields = $request->all();
        unset($fields['sort']);
        $fieldArray = [];
        foreach($fields as $key => $value)
            array_push($fieldArray, "$key=$value");
        $query = $request->url() . '?' . implode('&', $fieldArray); 
        return $query;
    }
    /* ========================================================================
                                      list
       ======================================================================== */
    public function list(Request $request, $page=0, $size=10)
    {
        $group_code = Auth::user()->group_code;
        $reports = DB::table('reports')
            ->limit($size)
            ->offset($page * $size);

        if($request->has('sort')){
            $orders = preg_split('/,/', $request->input('sort'));
            foreach($orders as $order)
            $reports = $reports->orderBy($order, 'asc');
        }
        $reports = $reports->get();

        $employeeCount = DB::table('reports')->count();

        $pageCount = ceil($employeeCount / $size);

        return view('admin.reports.list', [
            'reports'     => $reports, 
            'pageCount'     => $pageCount,
            'currentPage'   => $page,
            'group_code'    => $group_code,
            'pageSize'      => $size,
            'types'         => [
                    1 => 'تعداد',
                    2 => 'لیست',
                ],  
            'pagination'    => $this->generatePages($pageCount, $page),
            'pageCount'     => ceil($employeeCount / $size),
            'sort'          => $request->has('sort')? ('?sort=' . $request->input('sort')) : '',
            ]);
    }
    function generatePages($total, $current){
        if($total > 1){
            $total=intval($total);

            $output=[];
            $current_page= (false == isset($current)) ? 0 : $current;
            $lastPage = -1;
            $lower = $current_page -3;
            $upper = $current_page +3;
            for($page=0;$page<$total;$page++){
                if(($page > $lower && $page < $upper) || $page < 1 || $page > ($total-2)){
                    if($lastPage + 1 != $page)
                        array_push($output, '#');
                    array_push($output, $page+1);
                    $lastPage = $page;
                }
            }
            return $output;
        }else{
            return [];
        }
    }
    /* ========================================================================
                                      remove
       ======================================================================== */
    public function remove(Request $request, $id){
        DB::table('reports')->where('id', '=', $id)->delete();   
        return back();
    }
    /* ========================================================================
                                 create new report
       ======================================================================== */
    public function newGet(Request $request){
        $group_code = Auth::user()->group_code;
        $columns = $this->columnList();
        return view('admin.reports.new', [
            'group_code'                => $group_code,
            'columns'                   => $columns
            ]);
    }
    public function newPost(Request $request){
        //die(json_encode($request->all()));
        $title = $request->input("title");
        $type = $request->input("type");
        $chart_type = $request->input('chart_type');

        $wantedColumns = array();
        $wantedFields = array();

        
        $group_code = Auth::user()->group_code;
        $columns = $this->columnList();

        $oldInputs = $request->all();
        
        foreach($columns as $key=>$value){
            if(array_key_exists('field_' . $key, $oldInputs))
                array_push($wantedFields, $this->generateField($key));
            if(array_key_exists('col_' . $key, $oldInputs))
                array_push($wantedColumns, $this->generateColumn($key));
        }
        
        $id = DB::table('reports')->insertGetId([
            'title'         => $title,
            'type'          => $type,
            'status'        => 1,
            'chart_type'    => $chart_type,
            'properties'    => json_encode([
                    'columns'   => $wantedColumns,
                    'fields'    => $wantedFields,
                ]),
            ]);
        
        return redirect('admin/reports');
    }
    /* ========================================================================
                                 edit a report
       ======================================================================== */
    public function editGet(Request $request, $id){
        $group_code = Auth::user()->group_code;
        $columns = $this->columnList();
        $values = $this->valueList();

        $report = DB::table('reports')
                    ->where('id', '=', $id)
                    ->first();

        if($report == Null){
            return view('errors.custom', [
                'group_code'    => $group_code,
                'status'        => 404,
                'message'       => 'فرم گزارشگیری مورد نظر یافت نشد!']);
        }



        $oldInputs = [
            'title'     => $report->title,
            'type'      => $report->type,
        ];

        $properties = json_decode($report->properties);

        foreach($properties->columns as $column){
            $oldInputs['col-' . $column->name] = 1;
        }
        foreach($properties->fields as $field){
            $oldInputs['fld-' . $field->name] = 1;
        }

        $limits = [];
        foreach($properties->limits as $limit){
            if(array_key_exists($limit->field, $limits)){
                $section = $limits[$limit->field];
                $oldInputs[$limit->field . '_op_' . $section]   = $limit->operator;
                $oldInputs[$limit->field . '_val_' . $section]  = $limit->value;
                $limits[$limit->field]++;
            }else{
                $limits[$limit->field] = 1;
                $oldInputs[$limit->field . '_op_' . 0]  = $limit->operator;
                $oldInputs[$limit->field . '_vl_' . 0] = $limit->value;
            }
        }

        return view('admin.reports.new', [
            'group_code'                => $group_code,
            'columns'                   => $columns,
            'values'                    => $values,
            'oldInputs'                 => $oldInputs,
            ]);
    }
    public function editPost(Request $request, $id){
        //die(json_encode($request->all()));
        $title = $request->input("title");
        $type = $request->input("type");
        $wantedColumns = array();
        $wantedFields = array();

        
        $group_code = Auth::user()->group_code;
        $columns = $this->columnList();
        $values = $this->valueList();

        $oldInputs = $request->all();
        
        foreach($oldInputs as $key=>$value){
            if($oldInputs[$key] == 'on')
                $oldInputs[$key] = 1;
            $parts = preg_split('/-/', $key);
            if(sizeof($parts) == 2){
                if($parts[0] == 'col'){
                    array_push($wantedColumns, $this->generateColumn($parts[1]));
                }else if($parts[0] == 'fld'){
                    array_push($wantedFields, $this->generateField($parts[1]));
                }
            }
        }

        $limits = [];
        foreach($columns as $c_name => $c_title){
            for($i=0; $i<3; $i++){
                $op = $request->input($c_name . '_op_' . $i);
                $val = $request->input($c_name . '_vl_' . $i);
                array_push($limits, [
                        'field'     => $c_name,
                        'operator'  => $op,
                        'value'     => $val,
                    ]);
            }
        }

        $id = DB::table('reports')->insertGetId([
            'title'         => $title,
            'type'          => $type,
            'status'        => 1,
            'properties'    => json_encode([
                    'columns'   => $wantedColumns,
                    'fields'    => $wantedFields,
                    'limits'    => $limits,
                ]),
            ]);
        
        return redirect('admin/report-edit/' . $id);
    }
    /* ========================================================================
                                 other functions
       ======================================================================== */
    public function columnList(){
        $columns = [
            'first_name'    => 'نام',
            'last_name'     => 'نام خانوادگی',
            'father_name'   => 'نام پدر',
            'id_number'     => 'کد ملی',
            
            'degree'        => 'مدرک تحصیلی',
            'field'         => 'رشته تحصیلی',
            'job'           => 'عنوان شغلی',

            'phone'         => 'شماره تلفن ثابت',
            'cell_phone'    => 'شماره تلفن همراه',

            'habitate'      => 'محل سکونت',
            'experience'    => 'سابقه کاری(ماه)',

            'gender'        => 'جنسیت',
            'marrige'       => 'وضعیت تاهل',
            'depentets'     => 'تعداد نفرات تحت تکفل'
        ];
        return $columns;
    }

    public function valueList(){
        return  [
                    'first_name'    => [
                        "type"  => "text",
                    ],

                    'last_name'     => [
                        "type"  => "text",
                    ],

                    'father_name'   => [
                        "type"  => "text",
                    ],

                    'id_number'     => [
                        "type"  => "text",
                    ],
                    
                    'degree'        => [
                        "type"  => "select",
                        "val"   => DB::table('degrees')     ->get(),
                    ],

                    'field'         => [
                        "type"  => "select",
                        "val"   => DB::table('study_fields')->get(),
                    ],

                    'job'           => [
                        "type"  => "select",
                        "val"   => DB::table('job_fields')  ->get(),
                    ],

                    'phone'         => [
                        "type"  => "text",
                    ],

                    'cell_phone'    => [
                        "type"  => "text",
                    ],

                    'habitate'      => [
                        "type"  => "select",
                        "val"   => DB::table('cities')      ->get(),
                    ],

                    'experience'    => [
                        "type"  => "text",
                    ],

                    'gender'        => [
                        "type"  => "select",
                        "val"   => DB::table('genders')     ->get(),
                    ],
                    'marrige'       => [
                        "type"  => "select",
                        "val"   => DB::table('merrige_types')->get(),
                    ],
                    'depentets'     => [
                        "type"  => "text",
                    ],
                ];
    }

    private function generateColumn($name){
        switch($name){
            case 'first_name':
                return [
                    'title'     => 'نام',
                    'name'      => $name,
                    'values'    => [
                        'type' => 'direct'
                    ]
                ];
            case 'last_name':
                return [
                    'title'     => 'نام خانوادگی',
                    'name'      => $name,
                    'values'    => [
                        'type' => 'direct'
                    ]
                ];
            case 'father_name':
                return [
                    'title'     => 'نام پدر',
                    'name'      => $name,
                    'values'    => [
                        'type' => 'direct'
                    ]
                ];
            case 'id_number':
                return [
                    'title'     => 'کد ملی',
                    'name'      => $name,
                    'values'    => [
                        'type' => 'direct'
                    ]
                ];
            case 'degree':
                return [
                    'title'     => 'مدرک تحصیلی',
                    'name'      => $name,
                    'values'    => [
                        'type'      => 'refrenced',
                        'table'     => 'degrees'
                    ]
                ];
            case 'field':
                return [
                    'title'     => 'رشته تحصیلی',
                    'name'      => $name,
                    'values'    => [
                        'type'      => 'refrenced',
                        'table'     => 'study_fields'
                    ]
                ];
            case 'job':
                return [
                    'title'     => 'عنوان شغلی',
                    'name'      => $name,
                    'values'    => [
                        'type'      => 'refrenced',
                        'table'     => 'job_fields'
                    ]
                ];
            case 'phone':
                return [
                    'title'     => 'شماره تماس ثابت',
                    'name'      => $name,
                    'values'    => [
                        'type' => 'direct'
                    ]
                ];
            case 'cell_phone':
                return [
                    'title'     => 'تلفن همراه',
                    'name'      => $name,
                    'values'    => [
                        'type' => 'direct'
                    ]
                ];
            case 'habitate':
                return [
                    'title'     => 'محل سکونت',
                    'name'      => $name,
                    'values'    => [
                        'type'      => 'refrenced',
                        'table'     => 'cities'
                    ]
                ];
            case 'experience':
                return [
                    'title'     => 'سابقه کار(ماه)',
                    'name'      => $name,
                    'values'    => [
                        'type' => 'direct'
                    ]
                ];
            case 'gender':
                return [
                    'title'     => 'جنسیت',
                    'name'      => $name,
                    'values'    => [
                        'type'      => 'refrenced',
                        'table'     => 'genders'
                    ]
                ];
            case 'marrige':
                return [
                    'title'     => 'وضعیت تاهل',
                    'name'      => $name,
                    'values'    => [
                        'type'      => 'refrenced',
                        'table'     => 'merrige_types'
                    ]
                ];
            case 'depentets':
                return [
                    'title'     => 'تعداد نفرات تحت تکفل',
                    'name'      => $name,
                    'values'    => [
                        'type' => 'direct'
                    ]
                ];
        }
    }

    private function generateField($name){
        switch($name){
            case 'first_name':
                return [
                    'title'     => 'نام',
                    'name'      => $name,
                    'input'     => 'text',
                    "dems"      => [
                        "md"        => 6,
                        "lg"        => 6,
                        "sm"        => 12,
                    ]
                ];
            case 'last_name':
                return [
                    'title'     => 'نام خانوادگی',
                    'name'      => $name,
                    'input'     => 'text',
                    "dems"      => [
                        "md"        => 6,
                        "lg"        => 6,
                        "sm"        => 12,
                    ]
                ];
            case 'father_name':
                return [
                    'title'     => 'نام پدر',
                    'name'      => $name,
                    'input'     => 'text',
                    "dems"      => [
                        "md"        => 6,
                        "lg"        => 6,
                        "sm"        => 12,
                    ]
                ];
            case 'id_number':
                return [
                    'title'     => 'کد ملی',
                    'name'      => $name,
                    'input'     => 'text',
                    "dems"      => [
                        "md"        => 6,
                        "lg"        => 6,
                        "sm"        => 12,
                    ]
                ];
            case 'degree':
                return [
                    'title'     => 'مدرک تحصیلی',
                    'name'      => $name,
                    'input'     => 'select',
                    'values'    => [
                        'type'      => 'refrenced',
                        'table'     => 'degrees'
                    ],
                    "dems"      => [
                        "md"        => 6,
                        "lg"        => 6,
                        "sm"        => 12,
                        "title_md"  => 4,
                        "title_lg"  => 4
                    ]
                ];
            case 'field':
                return [
                    'title'     => 'رشته تحصیلی',
                    'name'      => $name,
                    'input'     => 'autocomplete',
                    'values'    => [
                        'query'      => 'study_fields',
                        'table'     => 'study_fields'
                    ],
                    "dems"      => [
                        "md"        => 6,
                        "lg"        => 6,
                        "sm"        => 12,
                        "title_md"  => 4,
                        "title_lg"  => 4
                    ]
                ];
            case 'job':
                return [
                    'title'     => 'عنوان شغلی',
                    'name'      => $name,
                    'input'     => 'autocomplete',
                    'values'    => [
                        'query'      => 'job_fields',
                        'table'     => 'job_fields'
                    ],
                    "dems"      => [
                        "md"        => 6,
                        "lg"        => 6,
                        "sm"        => 12,
                        "title_md"  => 4,
                        "title_lg"  => 4
                    ]
                ];
            case 'phone':
                return [
                    'title'     => 'شماره تماس ثابت',
                    'name'      => $name,
                    'input'     => 'text',
                    'values'    => [
                        'type' => 'direct'
                    ],
                    "dems"      => [
                        "md"        => 6,
                        "lg"        => 6,
                        "sm"        => 12,
                    ]
                ];
            case 'cell_phone':
                return [
                    'title'     => 'تلفن همراه',
                    'name'      => $name,
                    'input'     => 'text',
                    'values'    => [
                        'type' => 'direct'
                    ],
                    "dems"      => [
                        "md"        => 6,
                        "lg"        => 6,
                        "sm"        => 12,
                    ]
                ];
            case 'habitate':
                return [
                    'title'     => 'محل سکونت',
                    'name'      => $name,
                    'input'     => 'select',
                    'values'    => [
                        'type'      => 'refrenced',
                        'table'     => 'cities'
                    ],
                    "dems"      => [
                        "md"        => 6,
                        "lg"        => 6,
                        "sm"        => 12,
                        "title_md"  => 4,
                        "title_lg"  => 4
                    ]
                ];
            case 'experience':
                return [
                    'title'     => 'سابقه کار(ماه)',
                    'name'      => $name,
                    'input'     => 'text',
                    'values'    => [
                        'type' => 'direct'
                    ],
                    "dems"      => [
                        "md"        => 6,
                        "lg"        => 6,
                        "sm"        => 12,
                    ]
                ];
            case 'gender':
                return [
                    'title'     => 'جنسیت',
                    'name'      => $name,
                    'input'     => 'select',
                    'values'    => [
                        'type'      => 'refrenced',
                        'table'     => 'genders'
                    ],
                    "dems"      => [
                        "md"        => 6,
                        "lg"        => 6,
                        "sm"        => 12,
                        "title_md"  => 4,
                        "title_lg"  => 4
                    ]
                ];
            case 'marrige':
                return [
                    'title'     => 'وضعیت تاهل',
                    'name'      => $name,
                    'input'     => 'select',
                    'values'    => [
                        'type'      => 'refrenced',
                        'table'     => 'merrige_types'
                    ],
                    "dems"      => [
                        "md"        => 6,
                        "lg"        => 6,
                        "sm"        => 12,
                        "title_md"  => 4,
                        "title_lg"  => 4
                    ]
                ];
            case 'depentets':
                return [
                    'title'     => 'تعداد نفرات تحت تکفل',
                    'name'      => $name,
                    'input'     => 'text',
                    'values'    => [
                        'type' => 'direct'
                    ],
                    "dems"      => [
                        "md"        => 6,
                        "lg"        => 6,
                        "sm"        => 12,
                    ]
                ];
        }
    }
}