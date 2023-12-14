<?php

namespace Modules\Helpdesk\Http\DataTables;

use Modules\Helpdesk\Entities\Ticket;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use Nwidart\Modules\Facades\Module;


class TicketsDataTable extends DataTable
{
    // Helper function to get the status badge
    protected function getStatusBadge($status) {
        $badgeColor = '';

        switch (strtolower($status)) {
            case 'open':
                $badgeColor = 'success';
                break;
            case 'pending':
                $badgeColor = 'warning';
                break;
            case 'closed':
                $badgeColor = 'secondary';
                break;
            case 'resolved':
                $badgeColor = 'primary';
                break;
            case 'in progress':
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
            ->editColumn('work_order', function (Ticket $ticket) {
                $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';

                if($ticket->work_order){
                    return '<span class="badge badge-primary"><a href="/apps/helpdesk/print/wo/' .
                                $ticket->work_order .
                                '" target="_blank" class="text-info view-work-order" data-id="' .
                                $ticket->id . '">View</a></span>';

                }else{
                    if($isSupervisor){
                        // If work_order does not exist, show "Generate Work Order" button
                        return '<a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_work_order" class="generate-work-order"  data-id="' .
                        $ticket->id . '" data-report-time="' . $ticket->report_time . '">Generate Work Order</a>';

                    }
                    return '<a href="#">N/A</a>';
                }

                
            })
            ->editColumn('created_at', function (Ticket $ticket) {
                return $ticket->created_at->format('d M Y, h:i a');
            })
            ->editColumn('status', function (Ticket $ticket) {
                $statusLink = '<a href="#" class="status-change" data-bs-toggle="modal" data-bs-target="#kt_modal_change_status" data-id="' . $ticket->id . '" data-status="' . $ticket->status . '"><i class="ki-duotone ki-pencil fs-5"><span class="path1"></span><span class="path2"></span></i></a> <a href="#" class="status-history" data-bs-toggle="modal" data-bs-target="#kt_modal_history_status" data-id="' . $ticket->id . '"><i class="ki-duotone ki-time fs-5"><span class="path1"></span><span class="path2"></span></i></a>';

                $statusBadge = TicketsDataTable::getStatusBadge($ticket->status);
                
                return $statusBadge . ' ' . $statusLink;
                // return $statusLink;
            })
            ->addColumn('action', function (Ticket $ticket) {
                // return '';
                return view('helpdesk::ticket._actions', compact('ticket'));
            })
            ->rawColumns(['status','work_order'])
            ->setRowId('id');
    }

    

    public function query(Ticket $model): QueryBuilder
    {
        // Get a new query builder instance
        $query = $model->newQuery();
        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $modulePath = Module::getModulePath('Helpdesk');
        return $this->builder()
            ->setTableId('tickets-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(3)
            // ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'scrollX'      =>  true,
                'dom'          => 'Bfrtip',
                'buttons'      => ['export', 'print', 'reload'],
            ])
            ->drawCallback("function() {" . file_get_contents($modulePath.'Resources/views/ticket/_draw-scripts.js') . "}");
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
                    ->controls(false)
                    ->orderable(false)
                    ->searchable(false),
            Column::make('subject')->title('Subject'),
            Column::make('created_by')->title('Operator'),
            Column::make('origin_unit')->title('Unit'),
            Column::make('source_report')->title('Sources'),
            Column::make('issue_category')->title('Category'),
            Column::make('priority')->title('Priority'),
            Column::make('status'),
            Column::make('work_order')->title('Work Order'),
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
        return 'Tickets_' . date('YmdHis');
    }
}
