<?php

namespace Modules\Helpdesk\Http\DataTables;

use App\Models\Company;
use Modules\Helpdesk\Entities\WorkOrder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use Nwidart\Modules\Facades\Module;

class WorkOrdersDataTable extends DataTable
{
    // Helper function to get the status badge
    protected function getStatusBadge($status) {
        $badgeColor = '';

        switch (strtolower($status)) {
            case 'normal':
                $badgeColor = 'success';
                break;
            case 'high':
                $badgeColor = 'warning';
                break;
            case 'emergency':
                $badgeColor = 'danger';
                break;
            case 'medium':
                $badgeColor = 'primary';
                break;
            case 'low':
                $badgeColor = 'info';
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
            // ->editColumn('work_order', function (WorkOrder $ticket) {
            //     $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';

            //     if ($ticket->work_order_id) {
            //         return '<span class="badge badge-primary"><a href="/apps/helpdesk/print/wo/' .
            //             $ticket->work_order_id .
            //             '" target="_blank" class="text-info view-work-order" data-id="' .
            //             $ticket->id . '">View</a></span>';
            //     } else {
            //         if ($isSupervisor) {
            //             return '<a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_work_order" class="generate-work-order"  data-id="' .
            //                 $ticket->id . '" data-report-time="' . $ticket->report_time . '">Generate Work Order</a>';
            //         }

            //         return '<a href="#">N/A</a>';
            //     }
            // })
            ->editColumn('created_at', function (WorkOrder $workOrder) {
                return $workOrder->created_at->format('d M Y, h:i a');
            })
            ->editColumn('subject', function (WorkOrder $workOrder) {
                // $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';

                return $workOrder->subject . ' '. WorkOrdersDataTable::getStatusBadge($workOrder->priority);
            })
            ->editColumn('user_cid', function (WorkOrder $workOrder, Company $company) {
                $data = $company->where('cid',$workOrder->user_cid)->first();
                return $data->name;
            })
            ->addColumn('action', function (WorkOrder $workOrder) {
                $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';

                // return $isSupervisor ? view('helpdesk::workorder._actions', compact(['workOrder','isSupervisor'])) : '';
                return view('helpdesk::workorder._actions', compact(['workOrder','isSupervisor']));
            })
            ->rawColumns(['subject','status','action'])
            ->setRowId('id');
    }

    public function query(WorkOrder $model): QueryBuilder
    {
        $user = auth()->user();

        if(auth()->user()->level_access == 'Staff'){
            $query = $model->where('user_cid', $user->cid)
            // ->whereIn('staff', [$user->name])
            ->whereJsonContains('staff', $user->name)
            ->newQuery();
        }elseif(auth()->user()->level_access == 'Super Admin'){
            $query = $model->newQuery();
        }else{
            // Get a new query builder instance
            $query = $model->where('user_cid', $user->cid)->newQuery();
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
            ->setTableId('workOrders-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(7)
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
            Column::make('subject')->title('Subject'),
            Column::make('staff')->title('Staff Assign'),
            Column::make('description')->title('Description')->visible(false),
            Column::make('created_by')->title('Operator')->visible(false),
            Column::make('origin_unit')->title('Unit')->visible(false),
            // Column::make('priority')->title('Priority'),
            Column::make('status'),
            Column::make('created_at')->title('Created Date'),
            Column::make('user_cid')->title('Company')->visible(false),
            Column::computed('action')
                ->addClass('text-end')
                ->exportable(false)
                ->printable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Helpdesk_WorkOrders_' . date('YmdHis');
    }
}
