<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Modules\Helpdesk\Entities\Ticket;
use Modules\Helpdesk\Entities\WorkOrder as WoHelpdesk;

use Modules\ITSM\Entities\Reported;
use Modules\ITSM\Entities\Incident;
use Modules\ITSM\Entities\WorkOrder;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CopyHelpdesk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copy:helpdesk';
    protected $description = 'Copy data from helpdesk_tickets to itsm_reporteds and itsm_incidents';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Copying data from helpdesk_tickets to itsm_reporteds...');
        $cid = 'HCKVQW';

        // Fetch the data from the helpdesk_tickets table
        $helpdeskTickets = Ticket::where('user_cid',$cid)
                            ->where('id','df225a51-2673-48b3-a96a-80fb2c352e3a')
                            ->orderBy('created_at', 'asc')->get();
        $totalRecords = $helpdeskTickets->count();

        $currentYear = date('Y');
        $maxNumber = Incident::where('user_cid', $cid)->whereYear('created_at', $currentYear)->max('number');
        $newNumber = $maxNumber + 1;
        $formattedNumber = 'INC'. $currentYear. str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        $maxNumberWO = WorkOrder::where('user_cid', $cid)->whereYear('created_at', $currentYear)->max('number');
        $prefixWO = config('itsm.workorder.series');
        $newNumberWO = $maxNumberWO+1;
        $formattedNumberWO = $prefixWO. $currentYear. str_pad($newNumberWO, 3, '0', STR_PAD_LEFT);

        $progress = 0;
        $successCount = 0;
        $failureCount = 0;
        $module = 'ITSM\\Incident';

        foreach ($helpdeskTickets as $helpdeskTicket) {
            // Start a database transaction
            DB::beginTransaction();

            try {
                // Insert into itsm_reporteds table
                $reporteds = Reported::create([
                                // Map fields accordingly
                                // 'id' => $helpdeskTicket->id,
                                'user' => $helpdeskTicket->reporter_name ?? null,
                                'location' => $helpdeskTicket->origin_unit,
                                'source' => $helpdeskTicket->source_report,
                                'report_time' => $helpdeskTicket->report_time,
                                'response_time' => $helpdeskTicket->response_time,
                                'resolved_time' => $helpdeskTicket->resolution_time ?? null,
                                'category' => $helpdeskTicket->issue_category,

                                'user_cid' => $helpdeskTicket->user_cid,
                                'user_id' => $helpdeskTicket->user_id,
                                'created_by' => $helpdeskTicket->created_by,
                                'created_by_level' => $helpdeskTicket->created_by_level,

                                'created_at' => $helpdeskTicket->created_at,
                                'updated_at' => $helpdeskTicket->updated_at,
                                'deleted_at' => $helpdeskTicket->deleted_at,

                            ]);
                    
                $incidents = Incident::create([
                                    'category_id' => null,
                                    'category_name' => null,
                                    'incident_number' => $formattedNumber,
                                    'number' => $newNumber,
                                    'title' => $helpdeskTicket->subject,
                                    'description' => $helpdeskTicket->description,
                                    'severity' => 'Medium',
                                    'kpi' => $helpdeskTicket->count_kpi,
                                    'status' => $helpdeskTicket->status,
                                    'reported_id' => $reporteds->id,

                                    'user_cid' => $helpdeskTicket->user_cid,
                                    'user_id' => $helpdeskTicket->user_id,
                                    'created_by' => $helpdeskTicket->created_by,
                                    'created_by_level' => $helpdeskTicket->created_by_level,

                                    'created_at' => $helpdeskTicket->created_at,
                                    'updated_at' => $helpdeskTicket->updated_at,
                                    'deleted_at' => $helpdeskTicket->deleted_at,
                ]);

                Reported::where('id', $incidents->reported_id)
                    ->update([
                        'data_id' => $incidents->id,
                        'data_module' => $module,
                        'data_number' => $incidents->incident_number,
                ]);

                $workorder = WoHelpdesk::where('ticket_id',$helpdeskTicket->id)->first();
                $inc = Incident::where('id',$incidents->id)->first();

                $wo = WorkOrder::create([
                    'number' => $workorder->no,
                    'workorder_number' => $workorder->no_workorder,
                    'supervisor' => $workorder->supervisor,
                    'staff' => $workorder->staff,
                    'user' => $workorder->user,
                    'location' => $workorder->origin_unit,
                    'subject' => $workorder->subject,
                    'description' => $workorder->description,
                    'module' => $module,
                    'status' => $workorder->status,
                    'priority' => $workorder->priority,
                    'due_date' => $workorder->due_date,

                    'report_time' => $workorder->report_time,
                    'response_time' => $workorder->response_time,
                    'resolved_time' => $workorder->end_time,
                    'start_time' => $workorder->start_time,
                    'end_time' => $workorder->end_time,

                    'data_id' => $inc->id,
                    'data_details' => json_encode($inc),

                    'user_cid' => $helpdeskTicket->user_cid,
                    'user_id' => $helpdeskTicket->user_id,
                    'created_by' => $helpdeskTicket->created_by,
                    'created_by_level' => $helpdeskTicket->created_by_level,

                    'created_at' => $helpdeskTicket->created_at,
                    'updated_at' => $helpdeskTicket->updated_at,
                    'deleted_at' => $helpdeskTicket->deleted_at,
                ]);

                Incident::where('id', $inc->id)
                        ->update([
                            'work_order_id' => $wo->id,
                ]);

                // Commit the transaction
                DB::commit();

                $successCount++;
            } catch (\Exception $e) {
                // An error occurred, rollback the transaction
                DB::rollback();

                $this->error("Failed to copy data for helpdesk_ticket ID: {$helpdeskTicket->id}. Error: {$e->getMessage()}");
                $failureCount++;
            }

            $progress++;
            $this->showProgress($progress, $totalRecords);
        }

        $this->info("\nMigration completed. Total: {$totalRecords}, Success: {$successCount}, Failures: {$failureCount}");
    }

    private function showProgress($current, $total)
    {
        $percentage = ($current / $total) * 100;
        $barLength = 50;
        $bar = str_repeat('=', intval($percentage / (100 / $barLength)));
        $bar .= str_repeat(' ', $barLength - strlen($bar));

        $this->output->write("\r[{$bar}] " . number_format($percentage, 2) . '%');
    }
}
