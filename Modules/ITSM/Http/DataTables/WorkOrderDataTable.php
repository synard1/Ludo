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
use Yajra\DataTables\Html\SearchPane;
use Nwidart\Modules\Facades\Module;
use Illuminate\Http\Request;

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

    public function getStatusFilterOptions()
    {
        $statuses = [
            'Open' => 'Open',
            'In Progress' => 'In Progress',
            'Pending' => 'Pending',
            'Cancelled' => 'Cancelled',
            'Overdue' => 'Overdue',
            'Completed' => 'Completed',
        ];

        $options = [];
                foreach ($statuses as $status) {
        $options[$status->id] = $status->name;
    }
    return $options;

    }

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query, Request $request): EloquentDataTable
    {
        return (new EloquentDataTable($query))
                // ->filter(function ($query) {
                //     if (request()->has('status') && request()->get('status') != '') {
                //         $query->where('status', request('status'));
                //     }
                // })
            // ->editColumn('created_at', function (WorkOrder $workorder) {
            //     return $workorder->created_at->format('d M Y, h:i a') ?? '';
            // })
            // ->editColumn('start_time', function (WorkOrder $workorder) {
            //     if($workorder->status == 'Completed'){
            //         if($workorder->start_time == null){
            //             return '';
            //         }else{
            //             return $workorder->start_time;
            //         }

            //     }

            // })
            // ->editColumn('end_time', function (WorkOrder $workorder) {
            //     if($workorder->status == 'Completed'){
            //         if($workorder->end_time == null){
            //             return '';
            //         }else{
            //             return $workorder->end_time;
            //         }

            //     }
            // })
            // ->editColumn('reported_by', function (WorkOrder $workorder) {
            //     return $workorder->reported->user;
            // })
            // ->editColumn('module', function (WorkOrder $workorder) {
            //     $string = $workorder->module;
            //     $parts = explode('/', $string);
            //     $lastPart = end($parts);
            //     return $lastPart;
            // })
            ->editColumn('workorder_number', function (WorkOrder $workorder) {
                // return '<a href="#" class="open-wo" data-number="'. $workorder->workorder_number .'">'.$workorder->workorder_number.'</a>';
                // $staff = $workorder->staff;
                // for ($i=0; $i < count($workorder->staff); $i++) {
                //     $staff = $workorder->staff;
                // }
                $staffList = implode(", ", $workorder->staff);

                // return $staffList;

                return '<a href="#" class="open-wo" target="_blank" data-wo="'.$workorder->workorder_number.'">'.$workorder->workorder_number.'</a><br>['.$staffList.']';

                // return $workorder->workorder_number;
            })
            ->editColumn('subject', function (WorkOrder $workorder) {
                // $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';
                $data = json_decode($workorder->data_details);
                $category = $data->category_name ?? '';
                $number = $data->incident_number ?? $data->service_number ?? '';

                return $workorder->subject . ' '. WorkOrderDataTable::getPriorityBadge($workorder->priority) . '<br>[<b>' . $number . '</b>] [<b>' . $category . '</b>]';
            })
            ->editColumn('status', function (WorkOrder $workorder) {
                return WorkOrderDataTable::getStatusBadge($workorder->status);
            })
            ->editColumn('category_name', function (WorkOrder $workorder) {
                $data = json_decode($workorder->data_details);
                $category = $data->category_name ?? '';

                // Ensure the category name is searchable
                return $category;
            })
            // ->addColumn('staff')
            // ->editColumn('staff', function (WorkOrder $workorder) {

            //     return json_decode($workorder->staff);
            // })
            // ->editColumn('user_id', function (WorkOrder $workorder, Company $company, User $user) {
            //     $isSuperAdmin = auth()->check() && auth()->user()->level_access === 'Super Admin';
            //     if($isSuperAdmin){
            //         $data = $company->where('cid',$workorder->user_cid)->first();
            //         return $data->name;
            //     }else{
            //         $data = $user->where('id',$workorder->user_id)->first();
            //         return $data->name;

            //     }

            // })
            // ->filter(function ($query) use ($request) {
            //     if ($request->has('search') && $request->get('search')['value'] != '') {
            //         $searchTerm = $request->get('search')['value'];
            //         $query->whereRaw("json_unquote(json_extract(data_details, '$.\"category_name\"')) COLLATE utf8mb3_general_ci LIKE ?", ["%{$searchTerm}%"]);
            //     }
            // })
            ->filterColumn('category_name', function($query, $keyword) {
                    // $searchTerm = $request->get('search')['value'];
                    $query->whereRaw("json_unquote(json_extract(data_details, '$.\"category_name\"')) COLLATE utf8mb3_general_ci LIKE ?", ["%{$keyword}%"]);
            })
            // ->filterColumn('status', function($query, $keyword) {
            //     // dd(request()->get('status'));
            //     $status = request('status');
            //         $query->where('status', 'like', "%{$status}%");

            // })
            // ->filter(function ($query) {
                //     if (request()->has('status') && request()->get('status') != '') {
                //         $query->where('status', request('status'));
                //     }
                // })
            ->addColumn('action', function (WorkOrder $workorder) {
                // $isOwner = auth()->check() && auth()->user()->level_access === 'Owner';
                $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';
                return $isSupervisor ? view('itsm::workorder._actions', compact(['workorder','isSupervisor'])) : view('itsm::workorder._actions', compact(['workorder','isSupervisor']));
            })
            ->rawColumns(['workorder_number','action','subject','description','status'])
            ->setRowId('id');
            // ->make(true);
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
        ->initComplete("function () {
            this.api()
                .columns([ `10` ])
                .every(function () {
                    let column = this;

                    // Create select element
                    let select = document.createElement('select');
                    select.add(new Option(''));
                    column.footer().replaceChildren(select);

                    // Apply listener for user change in value
                    select.addEventListener('change', function () {
                        column
                            .search(select.value, {exact: true})
                            .draw();
                    });

                    // Add list of options
                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function (d, j) {
                            // Remove HTML format from column data
                            let text = d.replace(/<[^>]*>/g, '');

                            select.add(new Option(text));
                        });
                });

                this.api()
                .columns([ `7` ])
                .every(function () {
                    let column = this;
                    let title = column.footer().textContent;
        
                    // Create input element
                    let input = document.createElement('input');
                    input.placeholder = title;
                    column.footer().replaceChildren(input);
        
                    // Event listener for user input
                    input.addEventListener('keyup', () => {
                        if (column.search() !== input.value) {
                            column.search(input.value).draw();
                        }
                    });
                });
        }")
            // ->initComplete('function() {
            //     this.api().columns().every(function () {
            //         var column = this;
            //         var input = document.createElement("input");
            //         $(input).appendTo($(column.footer()).empty())
            //             .on("change", function () {
            //                 column.search($(this).val(), false, false, true).draw();
            //             }
            //         );
            //     });
            // }')
            ->setTableId('workorders-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            // ->dom('Bfrtlip')
            ->dom('Bfrtip')
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->parameters([
                'scrollX'      =>  true,
                'lengthMenu' => [
                        [ 10, 25, 50, -1 ],
                        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                ],
                'buttons'      => ['export', 'print', 'reload','colvis'],
            ])
            ->drawCallback("function() {" . file_get_contents($modulePath.'Resources/views/workorder/_draw-scripts.js') . "}");
    }
    // public function html(): \Yajra\DataTables\Html\Builder
    // {
    //     $modulePath = Module::getModulePath('ITSM');
    //     return $this->builder()
    //         // ->initComplete('function() {
    //         //     this.api().columns().every(function () {
    //         //         var column = this;
    //         //         var input = document.createElement("input");
    //         //         $(input).appendTo($(column.footer()).empty())
    //         //             .on("change", function () {
    //         //                 column.search($(this).val(), false, false, true).draw();
    //         //             }
    //         //         );
    //         //     });
    //         // }')
    //         ->setTableId('workorders-table')
    //         ->columns($this->getColumns())
    //         ->minifiedAjax()
    //         ->dom('Bfrtip')
    //         // ->searchPanes(SearchPane::make()->columns([1, 2]))
    //         // ->addColumnDef([
    //         //     'targets' => '_all',
    //         //     'searchPanes' => [
    //         //         'show' => true,
    //         //         'vieTotal' => false,
    //         //         'viewCount' => false,
    //         //     ],
    //         // ])
    //         // ->dom('PBfrtip')
    //         ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable')
    //         ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
    //         ->orderBy('1')
    //         // ->addAction(['width' => '120px', 'printable' => false])
    //         ->parameters([
    //             'searching'     => true,
    //             // 'responsive' => true,
    //             'scrollX'      =>  true,
    //             // 'scrollY'      =>  true,
    //             // 'searchPanes' => true,
    //             // 'lengthMenu' => [
    //             //         [ 10, 25, 50, -1 ],
    //             //         [ '10 rows', '25 rows', '50 rows', 'Show all' ]
    //             // ],
    //             // 'dom' => 'Bfrtip',
    //             'buttons'      => ['pageLength', 'export', 'print', 'reload','colvis'],
    //             // 'buttons'      => ['export', 'print', 'reload','colvis'],
    //         ])
    //         ->drawCallback("function() {" . file_get_contents($modulePath.'Resources/views/workorder/_draw-scripts.js') . "}");
    // }

    // Function to fetch filter options
    // public function getFilterOptions($filterColumnName)
    // {
    //     // Query your model to get distinct values for the filter column
    //     return WorkOrder::query()
    //         ->select($filterColumnName)
    //         ->distinct()
    //         ->pluck($filterColumnName)
    //         ->toArray();
    // }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
        //     Column::make('row_number')
        //             ->title('#')
        //             ->render('meta.row + meta.settings._iDisplayStart + 1;')
        //             ->width(50)
        //             // ->controls(false)
        //             ->orderable(false)
        //             ->searchable(false)
        //             ->searchPanes(true)
        //             ->printable(true),
            Column::make('module')->title('Module')->searchPanes(true)->visible(false),
            Column::make('workorder_number')->searchPanes(true)->title('Number'),
            Column::computed('category_name')->title('Category')->searchable(true)->visible(false),
            Column::make('subject')->title('Title'),
            Column::make('description')->title('Description')->visible(false),
            // Column::make('severity')->title('Severity')->visible(true),
            // Column::make('kpi')->title('KPI')->visible(false),

            // Column::make('work_order')->title('Work Order')->printable(false),
            Column::make('user')->title('Reported By')->visible(false),
            Column::make('location')->title('Reported Location')->visible(false),
            // Column::make('reported_source')->title('Report Source')->visible(false),
            Column::computed('report_time')
                ->searchable(true)
                ->orderable(true)
                ->title('Report Time')
                ->visible(true),
            Column::computed('start_time')->title('Start Time')->visible(false)->searchable(false),
            Column::computed('end_time')->title('Resolved Time')->visible(false)->searchable(false),
            // Column::make('status') // Add your column name
            //     ->filter(function() {
            //         return $this->getFilterOptions('status'); // Get filter options
            //     }),
            // Column::make('reported_response')->title('Response Time')->visible(false),
            // Column::computed('status')
            //     ->searchable(true)
            //     ->orderable(true)
            //     ->title('Status')
            //     ->visible(true),
            Column::make('status')
            ->title('Status'),
            // Column::make('filter_column') // The column you want to filter on
            //     ->title('Filter Column')
            //     ->filter(function() {
            //         // Fetch unique values for the filter dropdown (server-side)
            //         $filterValues = WorkOrder::distinct()->pluck('status');

            //         return view('datatables.filter-dropdown', [
            //             'values' => $filterValues,
            //             'columnName' => 'status', // Important!
            //         ])->render();
            //     }),
            // Column::make('priority')->title('Priority')->visible(true),
            // Column::computed('staff')->title('Assign'),
            // Column::make('user_id')->title('Created By')->visible(false),
            // Column::make('created_at')->title('Created Date')->visible(false),
            Column::make('staff')->visible(false),
            //     ->render(function ($row) {
            //         return implode(", ", $row->staff);
            //     }),
            Column::computed('action')
                // ->addClass('text-end')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                // ->width(60)
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

    //Add this function for server side filter
    // protected function getFilteredQuery($query, $request)
    // {
    //     foreach ($request->filter as $columnName => $filterValue) {
    //         // $filterValue = explode(',', $filterValue);
    //         if (!empty($filterValue)) {
    //             // $query->whereIn($columnName, $filterValue);
    //             $query->where($columnName, $filterValue);

    //         }
    //     }
    //     return $query;
    // }



    // protected function getFilteredQuery($query, $request)
    // {
    //     foreach ($request->filter as $columnName => $filterValue) {
    //         if (!empty($filterValue)) {
    //             if ($columnName == 'status') {
    //                 $query->where('status', $filterValue);
    //             } else {
    //                 $query->where($columnName, $filterValue);
    //             }
    //         }
    //     }
    //     return $query;
    // }
}
