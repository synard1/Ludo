<?php

namespace Modules\ITSM\Http\DataTables;

use Modules\ITSM\Entities\Service;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use Nwidart\Modules\Facades\Module;


class ServiceDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('work_order', function (Service $service) {
                $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';

                if ($service->work_order_id) {
                    // return '<span class="badge badge-primary"><a href="/apps/itsm/print/wo/' .
                    //     $service->work_order_id .
                    //     '" target="_blank" class="text-info view-work-order" data-id="' .
                    //     $service->id . '">View</a></span>';
                    return '<span class="badge badge-primary"><a href="#" class="text-info view-wo" target="_blank" data-number="' . $service->workorder->workorder_number . '">View</a></span>';
                } else {
                    if ($isSupervisor) {
                        return '<a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_work_order" class="generate-work-order"  data-id="' .
                            $service->id . '" data-report-time="' . $service->report_time . '" data-title="' . $service->title . '">Generate Work Order</a>';
                    }

                    return '<a href="#">N/A</a>';
                }
            })
            // ->editColumn('work_order', function (Service $service) {
            //     $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';

            //     if ($service->work_order_id) {
            //         return '<span class="badge badge-primary"><a href="/apps/itsm/print/wo/' .
            //             $service->work_order_id .
            //             '" target="_blank" class="text-info view-work-order" data-id="' .
            //             $service->id . '">View</a></span>';
            //     } else {
            //         if ($isSupervisor) {
            //             return '<a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_work_order" class="generate-work-order"  data-id="' .
            //                 $service->id . '" data-report-time="' . $service->report_time . '" data-title="' . $service->title . '">Generate Work Order</a>';
            //         }

            //         return '<a href="#">N/A</a>';
            //     }
            // })
            ->editColumn('created_at', function (Service $service) {
                return $service->created_at->format('d M Y, h:i a');
            })
            ->editColumn('reported_by', function (Service $service) {
                return $service->reported->user;
            })
            ->editColumn('reported_location', function (Service $service) {
                return $service->reported->location;
            })
            ->editColumn('reported_source', function (Service $service) {
                return $service->reported->source;
            })
            ->editColumn('reported.report_time', function (Service $service) {
                return $service->reported->report_time->format('Y-m-d H:i');
            })
            ->editColumn('reported_response', function (Service $service) {
                return $service->reported->response_time->format('d M Y, h:i a');
            })
            // ->editColumn('resolved_date', function (Service $service) {
            //     return $service->reported->resolved_time->format('d M Y, h:i a') ?? '';
            // })
            ->editColumn('user_id', function (Service $service, Company $company, User $user) {
                $isSuperAdmin = auth()->check() && auth()->user()->level_access === 'Super Admin';
                if($isSuperAdmin){
                    $data = $company->where('cid',$service->user_cid)->first();
                    return $data->name;
                }else{
                    $data = $user->where('id',$service->user_id)->first();
                    return $data->name;

                }
                
            })
            ->addColumn('action', function (Service $service) {
                $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';
                return $isSupervisor ? view('itsm::service._actions', compact(['service','isSupervisor'])) : '';
            })
            ->rawColumns(['action', 'work_order'])
            ->setRowId('id');
    }

    public function query(Service $model): QueryBuilder
    {
        $user = auth()->user();

        $query = $model->newQuery();

        // Adjust the query based on user's level_access
        if ($user->level_access != 'Super Admin') {
            $query->where('user_cid', $user->cid);
        } elseif ($user->level_access == 'Owner') {
            $query->where('user_cid', $user->cid);
        }

        $query = $model::with('reported')
            ->orderBy('number', 'DESC')
            ->newQuery();

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $modulePath = Module::getModulePath('ITSM');
        return $this->builder()
            ->setTableId('services-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy('6')
            // ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'scrollX'      =>  true,
                'lengthMenu' => [
                        [ 10, 25, 50, -1 ],
                        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                ],
                'dom'          => 'Bfrtlip',
                // 'buttons'      => ['pageLength', 'export', 'print', 'reload','colvis'],
                'buttons'      => ['export', 'print', 'reload','colvis'],
            ])
            ->drawCallback("function() {" . file_get_contents($modulePath.'Resources/views/service/_draw-scripts.js') . "}");
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
            Column::make('service_number')->title('Number'),
            Column::make('title')->title('Title'),
            Column::make('description')->title('Description')->visible(true),
            Column::computed('kpi')->title('KPI')->visible(false),
            Column::computed('status')->title('Status')->visible(true),
            Column::computed('work_order')->title('Work Order')->printable(false),
            Column::computed('reported_by')->title('Reported By')->visible(false),
            Column::computed('reported_location')->title('Reported Location')->visible(false),
            Column::computed('reported_source')->title('Report Source')->visible(false),
            Column::computed('reported.report_time')->searchable()->title('Report Time')->visible(true),
            Column::computed('reported_response')->title('Response Time')->visible(false),
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
        return 'ITSM_Services_' . date('YmdHis');
    }
}
