<?php

namespace Modules\Helpdesk\Http\DataTables;

use Modules\Helpdesk\Entities\ServiceRequest;
use App\Models\Company;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use Nwidart\Modules\Facades\Module;


class ServiceRequestDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function (ServiceRequest $service) {
                return $service->created_at->format('d M Y, h:i a');
            })
            ->editColumn('user_cid', function (ServiceRequest $service, Company $company) {
                $data = $company->where('cid',$service->user_cid)->first();
                return $data->name;
            })
            ->addColumn('action', function (ServiceRequest $service) {
                $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';
                // return $isSupervisor ? view('helpdesk::service._actions', compact(['service','isSupervisor'])) : '';
            })
            ->rawColumns([''])
            ->setRowId('id');
    }

    public function query(ServiceRequest $model): QueryBuilder
    {
        // Get a new query builder instance
        $user = auth()->user();

        if(!auth()->user()->level_access == 'Super Admin'){
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
        $modulePath = Module::getModulePath('Helpdesk');
        return $this->builder()
            ->setTableId('serviceRequest-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy('3')
            // ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'scrollX'      =>  true,
                'dom'          => 'Bfrtip',
                'buttons'      => ['export', 'print', 'reload','colvis'],
            ])
            ->drawCallback("function() {" . file_get_contents($modulePath.'Resources/views/service-management/_draw-scripts.js') . "}");
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
            Column::make('service_name')->title('Service'),
            Column::make('request_description')->title('Request Description')->visible(true),
            Column::make('request_date')->title('Request Date')->visible(true),
            Column::make('requester_name')->title('Requester')->visible(false),
            Column::make('created_by')->title('Operator')->visible(false),
            Column::make('requester_unit')->title('Unit')->visible(true),
            Column::make('status'),
            Column::make('created_at')->title('Created Date')->visible(false),
            Column::make('user_cid')->title('Company')->visible(false),
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
        return 'Helpdesk_ServiceRequests_' . date('YmdHis');
    }
}
