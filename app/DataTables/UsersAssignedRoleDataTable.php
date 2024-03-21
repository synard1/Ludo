<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\UsersAssingedRole;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
// use Spatie\Permission\Models\Role;
use App\Models\Role;

class UsersAssignedRoleDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['user'])
            ->editColumn('user', function (User $user) {
                return view('pages.apps.user-management.roles.columns._user', compact('user'));
            })
            ->editColumn('created_at', function (User $user) {
                return $user->created_at->format('d M Y, h:i a');
            })
            ->addColumn('action', function (User $user, Role $role) {
                return view('pages.apps.user-management.roles.columns._actions', compact(['role','user' ]));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->whereHas('roles', function (Builder $query) {
            $query->where('role_id', $this->role->getKey());
        });

        // return $model->newQuery();
        // dd($this->role->getKey());
    }


    // public function query(User $model): Builder
    // {
    //     // Assuming 'role_id' is the column in 'users' table
    //     // that represents the relationship between users and roles

    //     return $model->newQuery()
    //                 ->when($this->role_id, function ($query) {
    //                     $query->whereHas('roles', function ($query) {
    //                         // 'role_id' here is the column name in the pivot table that represents the role id
    //                         $query->where('role_id', $this->role_id);
    //                     });
    //                 });
    // }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('usersassingedrole-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rtp')
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(1)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages//apps/user-management/users/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            // Column::make('id'),
            Column::make('user')->addClass('d-flex align-items-center')->name('name'),
            Column::make('name'),
            Column::make('created_at')->title('Joined Date'),
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
        return 'UsersAssingedRole_' . date('YmdHis');
    }
}
