<?php

namespace App\DataTables;

use App\Models\Log;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;
use Carbon\Carbon;


class LogDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        // return $dataTable->addColumn('action', 'logs.datatables_actions');
        // return $dataTable;

        return $dataTable->editColumn('user_id', function ($log) {
            return $log->user->name;
        })
        ->editColumn('created_at', function ($log) {
            return Carbon::parse($log->created_at)->format('d-m-Y H:i');
        })
        ->editColumn('http_status', function ($log) {
            // Set the default color to black
            $color = 'black';

            // Check if the log has the "color" column
            if (isset($log->color)) {
                // Set the color based on the value of the "color" column
                switch ($log->color) {
                    case 'green':
                        $color = 'green';
                        break;
                    case 'yellow':
                        $color = 'yellow';
                        break;
                    case 'red':
                        $color = 'red';
                        break;
                    // Add more cases for other colors if needed
                }
            }

            // Return the formatted http_status column with the set color
            return '<span style="color: '.$color.';">'.$log->http_status.'</span>';
        })
        ->rawColumns(['http_status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Log $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Log $model)
    {
        // return $model->newQuery();
        return $model->newQuery()->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            // ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'responsive' => true,
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
            //     'buttons'   => [
            //         Enable Buttons as per your need
            //        ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
            //        ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
            //        ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
            //        ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
            //        ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
            //     ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['data' => 'http_method', 'name' => 'http_method', 'title' => 'Method'],
            ['data' => 'http_status', 'name' => 'http_status', 'title' => 'Status'],
            ['data' => 'user_id', 'name' => 'user_id', 'title' => 'User'],
            'ip_address',
            'user_agent',
            'page_response_time',
            'db_query_time',
            'created_at',
            'url'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'logs_datatable_' . time();
    }
}
