<?php

namespace Modules\AdsPortal\DataTables;

use Modules\AdsPortal\Entities\AdsSchedule;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Nwidart\Modules\Facades\Module;
use App\Models\User;

class AdsScheduleAdminDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('DT_RowIndex', function ($row) {
                return $row->index + 1;  // Update the row index
            })
            ->editColumn('user_id', function ($model) {
                return $model->user->name; // return the user's name
            })
            ->editColumn('client_id', function ($model) {
                return $model->client->name; // return the client's name
            })
            ->editColumn('ads_id', function ($model) {
                return $model->ads->name; // return the client's name
            })
            ->editColumn('site_id', function ($model) {
                return $model->site->sites; // return the client's name
            })
            ->editColumn('status', function ($model) {
                $status = $model->status; // return the client's name
                return config('onexolution.statusAdsSchedule')[$status]; // return the client's name
            })
            // ->editColumn('status', function($model) {
            //     return view('adsportal::ads.columns._statusAds', compact('model'));
            // })
            ->editColumn('days', function ($model) {
                $days = $model->days; // return the client's name
                return config('onexolution.days')[$days]; // return the client's name
            })
            ->removeColumn(['created_at', 'updated_at'])
            ->rawColumns(['DT_RowIndex', 'status']); // allow HTML in the DT_RowIndex column
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Log $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AdsSchedule $model)
    {
        // return $model->newQuery();
        return $model->newQuery()->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */

    public function html(): HtmlBuilder
    {
        $path = Module::getModulePath('Adsportal');
        return $this->builder()
            ->setTableId('ss_table_adsscheduleadmin')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rtp')
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(1)
            ->searching(true);  // Ensure search is enabled
    }

    /**
     * Get columns.
     *
     * @return array
     */
    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('user_id')->addClass('d-flex align-items-center')->name('user_id')->searchable(),
            Column::make('client_id')->searchable(),
            Column::make('site_id')->searchable(),
            Column::make('type')->searchable(),
            Column::make('source')->searchable(),
            Column::make('ads_id')->searchable(),
            Column::make('days')->searchable(),
            Column::make('duration')->searchable(),
            Column::make('status')->searchable(),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'adsschedule_datatable_' . time();
    }
}
