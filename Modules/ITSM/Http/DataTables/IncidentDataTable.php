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
                    return '<span class="badge badge-primary"<a href="#" class="view-wo" target="_blank" data-number="' . $incident->workorder()->workorder_number . '">View</a></span>';
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
            ->editColumn('reported_date', function (Incident $incident) {
                return $incident->reported->report_time;
            })
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
            ->rawColumns(['action', 'work_order'])
            ->setRowId('id');
    }

    public function query(Incident $model): QueryBuilder
    {
        // Get a new query builder instance
        $user = auth()->user();

        if(!auth()->user()->level_access == 'Super Admin'){
            $query = $model->where('user_cid', $user->cid)
                            ->newQuery();
        }elseif(auth()->user()->level_access == 'Owner'){
            $query = $model->where('user_cid', $user->cid)
                            ->newQuery();
        }else{
            // Get a new query builder instance
            $query = $model->newQuery();
        }
    
        return $query;
    }

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
            ->dom('Bfrtip')
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy('7')
            // ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'scrollX'      =>  true,
                'dom'          => 'Bfrtip',
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
            Column::make('category_name')->title('Classification'),
            Column::make('incident_number')->title('Number'),
            Column::make('title')->title('Title'),
            Column::make('description')->title('Description')->visible(true),
            Column::make('severity')->title('Severity')->visible(true),
            Column::make('kpi')->title('KPI')->visible(false),
            Column::make('status')->title('Status')->visible(true),
            Column::make('work_order')->title('Work Order')->printable(false),
            Column::make('reported_by')->title('Reported By')->visible(false),
            Column::make('reported_location')->title('Reported Location')->visible(false),
            Column::make('reported_source')->title('Report Source')->visible(false),
            Column::make('reported_date')->title('Report Time')->visible(true),
            // Column::make('reported_response')->title('Response Time')->visible(false),
            // Column::make('resolved_date')->title('Resolved Time')->visible(false),
            Column::make('user_id')->title('Created By')->visible(false),
            Column::make('created_at')->title('Created Date')->visible(false),
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
