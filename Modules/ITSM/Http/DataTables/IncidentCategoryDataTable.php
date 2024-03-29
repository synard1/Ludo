<?php

namespace Modules\ITSM\Http\DataTables;

use Modules\ITSM\Entities\IncidentCategory;
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


class IncidentCategoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function (IncidentCategory $incidentCategory) {
                return $incidentCategory->created_at->format('d M Y, h:i a');
            })
            ->editColumn('user_id', function (IncidentCategory $incidentCategory, Company $company, User $user) {
                $isSuperAdmin = auth()->check() && auth()->user()->level_access === 'Super Admin';
                if($isSuperAdmin){
                    $data = $company->where('cid',$incidentCategory->user_cid)->first();
                    return $data->name;
                }else{
                    $data = $user->where('id',$incidentCategory->user_id)->first();
                    return $data->name;

                }
                
            })
            ->addColumn('action', function (IncidentCategory $incidentCategory) {
                // $isOwner = auth()->check() && auth()->user()->level_access === 'Owner';
                $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';
                return $isSupervisor ? view('itsm::incidentCategory._actions', compact(['incidentCategory','isSupervisor'])) : '';
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    public function query(IncidentCategory $model): QueryBuilder
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
            ->setTableId('incidentCategorys-table')
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
            ->drawCallback("function() {" . file_get_contents($modulePath.'Resources/views/incidentCategory/_draw-scripts.js') . "}");
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
            Column::make('name')->title('Nmae'),
            Column::make('description')->title('Description')->visible(true),
            Column::make('user_id')->title('Created By'),
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
        return 'ITSM_IncidentCategorys_' . date('YmdHis');
    }
}
