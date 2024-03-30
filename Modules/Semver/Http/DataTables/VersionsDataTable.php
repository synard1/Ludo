<?php

namespace Modules\Semver\Http\DataTables;

use Modules\Semver\Entities\Version;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use Nwidart\Modules\Facades\Module;


class VersionsDataTable extends DataTable
{

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function (Version $version) {
                return $version->created_at->format('d M Y, h:i a');
            })
            ->addColumn('action', function (Version $Version) {
                $isSuperAdmin = auth()->check() && auth()->user()->level_access === 'Super Admin';
                return $isSuperAdmin ? view('semver::version._actions', compact(['version','isSuperAdmin'])) : '';
            })
            ->rawColumns(['status'])
            ->setRowId('id');
    }

    public function query(Version $model): QueryBuilder
    {
        // Get a new query builder instance
        $query = $model->where('user_cid', auth()->user()->cid)->newQuery();
        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $modulePath = Module::getModulePath('Semver');
        return $this->builder()
            ->setTableId('versions-table')
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
                'buttons'      => ['export', 'print', 'reload','colvis'],
            ])
            ->drawCallback("function() {" . file_get_contents($modulePath.'Resources/views/version/_draw-scripts.js') . "}");
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
            Column::make('description')->title('Description')->visible(false),
            Column::make('status'),
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
        return 'Helpdesk_Versions_' . date('YmdHis');
    }
}
