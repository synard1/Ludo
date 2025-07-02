<?php

namespace Modules\ITSM\Http\DataTables;

use Modules\ITSM\Entities\Incident;
use Modules\Helpdesk\Entities\Service;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use Nwidart\Modules\Facades\Module;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\ColumnDefinition;


class IncidentDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('work_order', function (Incident $incident) {
                $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';

                if ($incident->work_order_id) {
                    // return '<span class="badge badge-primary"><a href="/apps/itsm/print/wo/' .
                    //     $incident->work_order_id .
                    //     '" target="_blank" class="text-info view-work-order" data-id="' .
                    //     $incident->id . '">View</a></span>';
                    return '<span class="badge badge-primary"><a href="#" class="text-info view-wo" target="_blank" data-number="' . $incident->workorder->workorder_number . '">View</a></span>';
                } else {
                    if ($isSupervisor) {
                        return '<a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_work_order" class="generate-work-order"  data-id="' .
                            $incident->id . '" data-report-time="' . $incident->report_time . '" data-title="' . $incident->title . '">Generate Work Order</a>';
                    }

                    return '<a href="#">N/A</a>';
                }
            })
            ->editColumn('created_at', function (Incident $incident) {
                return $incident->created_at->format('d M Y, h:i a');
            })
            ->editColumn('reported_by', function (Incident $incident) {
                return $incident->reported->user;
            })
            ->editColumn('reported_location', function (Incident $incident) {
                return $incident->reported->location;
            })
            ->editColumn('reported_source', function (Incident $incident) {
                return $incident->reported->source;
            })
            ->editColumn('reported.report_time', function (Incident $incident) {
                return $incident->reported->report_time->format('Y-m-d H:i');
            })
            ->editColumn('response_time', function (Incident $incident) {
                return $incident->reported->response_time;
            })
            ->editColumn('duration', function (Incident $incident) {
                // Calculate avg_time from report_time and response_time
                $diff = Carbon::parse($incident->reported->report_time)->diffInMinutes(Carbon::parse($incident->reported->response_time));

                return $diff . ' Minutes';
            })
            // ->editColumn('under', function (Incident $incident) {
            //     // Calculate avg_time from report_time and response_time
            //     $diff = Carbon::parse($incident->reported->report_time)->diffInMinutes(Carbon::parse($incident->reported->response_time));
                
            //     if($diff < 30){
            //         return 'Y';
            //     }else{
            //         return 'N';
            //     }
            // })
            // ->editColumn('under2', function (Incident $incident) {
                

            //     $allowedCategories = ['Hardware', 'Network'];

            //     // if (in_array($incident->reported->category, $allowedCategories)) {
            //         // $category = $incident->reported->category;

            //         // if (collect(["Hardware", "Software"])->contains($category)) {
            //             // Your code here if the category contains "Hardware" or "Network"

            //         // Calculate avg_time from report_time and response_time
            //         // $diff = Carbon::parse($incident->reported->report_time)->diffInMinutes(Carbon::parse($incident->reported->response_time));

            //         // if($diff < 120){
            //         //     return 'Y';
            //         // }else{
            //         //     return 'N';
            //         // }

            //         $allowedCategories = ['Hardware', 'Software'];

            //         if (!empty(array_intersect($incident->reported->category, $allowedCategories))) {
            //             // return 'Y';
            //             // Calculate avg_time from report_time and response_time
            //             $diff = Carbon::parse($incident->reported->report_time)->diffInMinutes(Carbon::parse($incident->reported->response_time));

            //             if($diff < 120){
            //                 return 'Y';
            //             }else{
            //                 return 'N';
            //             }
            //         }
            //     // } else {
            //     //     // Your code here if the category does not contain "Hardware" or "Network"
            //     //     // return '-';
            //     //     return $incident->reported->category;
            //     // }

                
                
            // })
            // ->editColumn('itsm_reported_response', function (Incident $incident) {
            //     return $incident->itsm_reported_response->format('d M Y, h:i a');
            // })
            // ->editColumn('itsm_resolved_date', function (Incident $incident) {
            //     return $incident->itsm_resolved_date->format('d M Y, h:i a');
            // })
            ->editColumn('user_id', function (Incident $incident, Company $company, User $user) {
                $isSuperAdmin = auth()->check() && auth()->user()->level_access === 'Super Admin';
                if($isSuperAdmin){
                    $data = $company->where('cid',$incident->user_cid)->first();
                    return $data->name;
                }else{
                    $data = $user->where('id',$incident->user_id)->first();
                    return $data->name;

                }
                
            })
            ->addColumn('action', function (Incident $incident) {
                // $isOwner = auth()->check() && auth()->user()->level_access === 'Owner';
                $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';
                return $isSupervisor ? view('itsm::incident._actions', compact(['incident','isSupervisor'])) : '';
            })
            // ->filterColumn('status', function($query, $keyword) {
            //     $sql = "itsm_incidents.status  like ?";
            //     $query->where($sql, ["%{$keyword}%"]);
            // })
            ->rawColumns(['action', 'work_order'])
            ->setRowId('id');
    }

    public function query(Incident $model): QueryBuilder
    {
        $user = auth()->user();

        $query = $model->newQuery();

        // Adjust the query based on user's level_access
        if ($user->level_access != 'Super Admin') {
            $query->where('user_cid', $user->cid);
        } elseif ($user->level_access == 'Owner') {
            $query->where('user_cid', $user->cid);
        }

        // Include sorting by report_time from the reported relation
        // $query->with(['reported' => function ($query) {
        //     $query->orderBy('number', 'DESC');
        // }]);
        $query = $model::with('reported')
            ->orderBy('number', 'DESC')
            ->newQuery();

        return $query;
    }

    // public function query(Incident $model): QueryBuilder
    // {
    //     // Get a new query builder instance
    //     $user = auth()->user();

    //     if(!auth()->user()->level_access == 'Super Admin'){
    //         $query = $model->where('user_cid', $user->cid)
    //                         ->newQuery();
    //     }elseif(auth()->user()->level_access == 'Owner'){
    //         $query = $model->where('user_cid', $user->cid)
    //                         ->newQuery();
    //     }else{
    //         // Get a new query builder instance
    //         $query = $model->newQuery();
    //     }
    
    //     return $query;
    // }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $modulePath = Module::getModulePath('ITSM');

        return $this->builder()
            ->setTableId('incidents-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtlip')
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->parameters([
                'scrollX'      =>  true,
                'lengthMenu' => [
                        [ 10, 25, 50, -1 ],
                        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                ],
                'buttons'      => ['export', 'print', 'reload','colvis'],
            ])
            ->drawCallback("function() {" . file_get_contents($modulePath.'Resources/views/incident/_draw-scripts.js') . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('row_number')
                    ->title('#')
                    ->render('meta.row + meta.settings._iDisplayStart + 1;')
                    ->width(50)
                    // ->controls(false)
                    ->orderable(false)
                    ->searchable(false)
                    ->printable(true),
            Column::make('category_name')
                ->title('Classification'),
            Column::make('incident_number')
                ->searchable(true)
                ->title('Number'),
            Column::make('title')
                ->title('Title'),
            Column::make('description')
                ->title('Description')->visible(true),
            Column::make('severity')->title('Severity')->visible(true),
            Column::make('kpi')
                ->title('KPI')->visible(false),
            Column::make('status')->title('Status')->visible(true),
            Column::computed('work_order')
                ->title('Work Order')
                ->searchable(false)
                ->printable(false),
            Column::make('reported_by')->searchable(false)->title('Reported By')->visible(false),
            Column::computed('reported_location')->searchable(false)->title('Reported Location')->visible(false),
            Column::computed('reported_source')->searchable(false)->title('Report Source')->visible(false),
            Column::computed('reported.report_time')->searchable()->title('Report Time')->visible(true),
            Column::computed('response_time')->searchable(false)->title('Response Time')->visible(false),
            Column::make('duration')
                ->title('Duration')
                ->searchable(false)
                ->visible(false),
            // Column::make('under')
            //     ->title('Status < 30')
            //     ->searchable(false)
            //     ->visible(false),
            // Column::make('under2')
            //     ->title('Status < 120')
            //     ->searchable(false)
            //     ->visible(false),
            // Column::make('reported_response')->title('Response Time')->visible(false),
            // Column::make('resolved_date')->title('Resolved Time')->visible(false),
            Column::make('user_id')->searchable(false)->title('Created By')->visible(false),
            Column::make('created_at')->searchable(false)->title('Created Date')->visible(false),
            Column::computed('action')
                ->addClass('text-end')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ITSM_Incidents_' . date('YmdHis');
    }
}
