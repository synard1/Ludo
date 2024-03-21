<?php

namespace Modules\ITSM\Http\DataTables;

use Modules\ITSM\Entities\WorkOrder;
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


class WorkOrderDataTable extends DataTable
{
    // Helper function to get the status badge
    protected function getPriorityBadge($priority) {
        $badgeColor = '';

        switch (strtolower($priority)) {
            case 'normal':
                $badgeColor = 'primary';
                break;
            case 'high':
                $badgeColor = 'danger';
                break;
            case 'critical':
                $badgeColor = 'info';
                break;
            case 'medium':
                $badgeColor = 'warning';
                break;
            case 'low':
                $badgeColor = 'success';
                break;
            default:
                return $priority; // return original data if priority is not recognized
        }

        return '<span class="badge badge-' . $badgeColor . '">' . ucfirst($priority) . '</span>';
    }

    // Helper function to get the status badge
    protected function getStatusBadge($status) {
        $badgeColor = '';

        switch (strtolower($status)) {
            case 'open':
                $badgeColor = 'primary';
                break;
            case 'in progresss':
                $badgeColor = 'warning';
                break;
            case 'pending':
                $badgeColor = 'info';
                break;
            case 'cancelled':
                $badgeColor = 'danger';
                break;
            case 'overdue':
                $badgeColor = 'secondary';
                break;
            case 'completed':
                $badgeColor = 'success';
                break;
            default:
                return $status; // return original data if status is not recognized
        }

        return '<span class="badge badge-' . $badgeColor . '">' . ucfirst($status) . '</span>';
    }

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function (WorkOrder $workorder) {
                return $workorder->created_at->format('d M Y, h:i a');
            })
            // ->editColumn('reported_by', function (WorkOrder $workorder) {
            //     return $workorder->reported->user;
            // })
            ->editColumn('module', function (WorkOrder $workorder) {
                $string = $workorder->module;
                $parts = explode('/', $string);
                $lastPart = end($parts);
                return $lastPart;
            })
            ->editColumn('workorder_number', function (WorkOrder $workorder) {
                // return '<a href="#" class="open-wo" data-number="'. $workorder->workorder_number .'">'.$workorder->workorder_number.'</a>';
                return '<a href="#" class="open-wo" target="_blank">'.$workorder->workorder_number.'</a>';

                // return $workorder->workorder_number;
            })
            ->editColumn('subject', function (WorkOrder $workorder) {
                // $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';
                $data = json_decode($workorder->data_details);
                $category = $data->category_name ?? '';

                return $workorder->subject . ' '. WorkOrderDataTable::getPriorityBadge($workorder->priority) . '<br>[<b>' . $category . '</b>]';
            })
            ->editColumn('status', function (WorkOrder $workorder) {
                return WorkOrderDataTable::getStatusBadge($workorder->status);
            })
            ->editColumn('staff', function (WorkOrder $workorder) {
                return $workorder->staff;
            })
            ->editColumn('user_id', function (WorkOrder $workorder, Company $company, User $user) {
                $isSuperAdmin = auth()->check() && auth()->user()->level_access === 'Super Admin';
                if($isSuperAdmin){
                    $data = $company->where('cid',$workorder->user_cid)->first();
                    return $data->name ?? '';
                }else{
                    $data = $user->where('id',$workorder->user_id)->first();
                    return $data->name ?? '';

                }
                
            })
            ->addColumn('action', function (WorkOrder $workorder) {
                // $isOwner = auth()->check() && auth()->user()->level_access === 'Owner';
                $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';
                return $isSupervisor ? view('itsm::workorder._actions', compact(['workorder','isSupervisor'])) : '';
            })
            ->rawColumns(['workorder_number','action','subject','description','status'])
            ->setRowId('id');
    }

    public function query(WorkOrder $model): QueryBuilder
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
            ->setTableId('workorders-table')
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
            ->drawCallback("function() {" . file_get_contents($modulePath.'Resources/views/workorder/_draw-scripts.js') . "}");
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
            // Column::make('category_name')->title('Classification'),
            Column::make('workorder_number')->title('Number'),
            Column::make('subject')->title('Title'),
            Column::make('description')->title('Description')->visible(false),
            // Column::make('severity')->title('Severity')->visible(true),
            // Column::make('kpi')->title('KPI')->visible(false),
            
            // Column::make('work_order')->title('Work Order')->printable(false),
            Column::make('user')->title('Reported By')->visible(false),
            Column::make('location')->title('Reported Location')->visible(false),
            // Column::make('reported_source')->title('Report Source')->visible(false),
            // Column::make('reported_date')->title('Report Time')->visible(false),
            // Column::make('reported_response')->title('Response Time')->visible(false),
            Column::make('module')->title('Module')->visible(false),
            Column::make('status')->title('Status')->visible(true),
            // Column::make('priority')->title('Priority')->visible(true),
            Column::make('staff')->title('Assign To')->visible(true),
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
        return 'ITSM_WorkOrders_' . date('YmdHis');
    }
}
