<?php

namespace Modules\Helpdesk\Http\DataTables;

use Modules\Helpdesk\Entities\ServiceManagement;
use Modules\Helpdesk\Entities\ServiceRequest;
use Modules\Helpdesk\Entities\Service;
use App\Models\Company;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use Nwidart\Modules\Facades\Module;


class ServiceManagementDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function (Service $service) {
                return $service->created_at->format('d M Y, h:i a');
            })
            ->editColumn('user_cid', function (Service $service, Company $company) {
                // if(auth()->user()->level_access == 'Super Admin'){
                //     // $data = $company->where('cid',$service->user_cid)->first();
                //     return $service->user_cid;
                //     // return $data->name;
                // }else{
                //     // $data = $company->where('cid',$service->user_cid)->first();
                //     // return $data->name;
                //     return $service->user_cid;
                // }
                
                $data = $company->where('cid',$service->user_cid)->first();
                return $data->name;
                
                
            })
            ->addColumn('action', function (Service $service) {
                $isOwner = auth()->check() && auth()->user()->level_access === 'Owner';
                return $isOwner ? view('helpdesk::service-management._actions', compact(['service','isOwner'])) : '';
            })
            ->rawColumns([''])
            ->setRowId('id');
    }

    public function query(Service $model): QueryBuilder
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
        $modulePath = Module::getModulePath('Helpdesk');
        return $this->builder()
            ->setTableId('services-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy('1')
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
            Column::make('name')->title('Name'),
            Column::make('description')->title('Description')->visible(true),
            Column::make('user_cid')->title('Created By'),
            Column::make('created_at')->title('Created Date'),
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
        return 'Helpdesk_ServiceManagements_' . date('YmdHis');
    }
}
