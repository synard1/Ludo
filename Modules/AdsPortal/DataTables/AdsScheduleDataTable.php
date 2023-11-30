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

class AdsScheduleDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    // public function dataTable($query)
    // {
    //     $dataTable = new EloquentDataTable($query);

    //     return $dataTable
    //             ->rawColumns(['user'])
    //             ->editColumn('user', function (User $user) {
    //                 return view('adsportal::sites.columns._user', compact('user'));
    //             })
    //             ->addColumn('action', function (AdsSite $adssite) {
    //                 return view('adsportal::sites.columns._actions', compact(['adssite' ]));
    //             });
    // }
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('user_id', function ($data) {
                return $data->user->name;
            })
            ->editColumn('client_id', function ($data) {
                return $data->client->name;
            })
            ->setRowId('id');
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
            ->setTableId('ads-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rtp')
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(1);
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
            Column::make('user_id')->addClass('d-flex align-items-center')->name('user_id'),
            Column::make('client_id'),
            Column::make('duration'),
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
