<?php
namespace Tests\Unit;

use \Modules\Helpdesk\Entities\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_attributes()
    {
        $ticket = new \Modules\Helpdesk\Entities\Ticket;

        $this->assertEquals(
            ["user_id","subject","cid","description","response_time","resolution_time","reporter_name","origin_unit","source_report","issue_category","priority","status","work_order_id"],
            $ticket->getFillable()
        );
    }

    /** @test */
    public function test_ticket_creation()
    {
        // Arrange
        $ticketData = [
                            'user_id' => $this->getTestValue('user_id'),
                            'subject' => $this->getTestValue('subject'),
                            'cid' => $this->getTestValue('cid'),
                            'description' => $this->getTestValue('description'),
                            'response_time' => $this->getTestValue('response_time'),
                            'resolution_time' => $this->getTestValue('resolution_time'),
                            'reporter_name' => $this->getTestValue('reporter_name'),
                            'origin_unit' => $this->getTestValue('origin_unit'),
                            'source_report' => $this->getTestValue('source_report'),
                            'issue_category' => $this->getTestValue('issue_category'),
                            'priority' => $this->getTestValue('priority'),
                            'status' => $this->getTestValue('status'),
                            'work_order_id' => $this->getTestValue('work_order_id'),
                    ];

        // Act
        $ticket = Ticket::create($ticketData);

        // Assert
        $this->assertInstanceOf(Ticket::class, $ticket);
        $this->assertDatabaseHas('helpdesk_tickets', [
                            'user_id' => $this->getTestValue('user_id'),
                            'subject' => $this->getTestValue('subject'),
                            'cid' => $this->getTestValue('cid'),
                            'description' => $this->getTestValue('description'),
                            'response_time' => $this->getTestValue('response_time'),
                            'resolution_time' => $this->getTestValue('resolution_time'),
                            'reporter_name' => $this->getTestValue('reporter_name'),
                            'origin_unit' => $this->getTestValue('origin_unit'),
                            'source_report' => $this->getTestValue('source_report'),
                            'issue_category' => $this->getTestValue('issue_category'),
                            'priority' => $this->getTestValue('priority'),
                            'status' => $this->getTestValue('status'),
                            'work_order_id' => $this->getTestValue('work_order_id'),
                    ]);
    }

    protected function getTestValue($attribute)
    {
        $rules = Ticket::$rules;

        if (isset($rules[$attribute])) {
            $rule = explode('|', $rules[$attribute]);
            $type = $this->getValidationType($rule);

            switch ($type) {
                case 'date':
                case 'datetime':
                    return Carbon::now()->format($this->getDateFormat($type));
                default:
                    return $rules[$attribute];
            }
        }

        return 'default_value';
    }

    protected function getValidationType($rules)
    {
        foreach ($rules as $rule) {
            if (str_starts_with($rule, 'date') || str_starts_with($rule, 'date_format')) {
                return 'date';
            } elseif (str_starts_with($rule, 'datetime')) {
                return 'datetime';
            }
        }

        return 'other';
    }

    protected function getDateFormat($type)
    {
        return $type === 'datetime' ? 'Y-m-d H:i:s' : 'Y-m-d';
    }
}
