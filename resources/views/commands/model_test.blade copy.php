<?php echo "<?php"; ?>

namespace Tests\Unit;

use Modules\{{ $module }}\Entities\{{ $model }};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class {{ $model }}Test extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_attributes()
    {
        ${{ Str::camel($model) }} = new \{{ $module }}\Entities\{{ $model }};

        $this->assertEquals(
            {!! formatArray($fillable) !!},
            ${{ Str::camel($model) }}->getFillable()
        );
    }
}
