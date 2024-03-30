<?php echo "<?php"; ?>

namespace Tests\Unit;

use \Modules\{{ $module }}\Entities\{{ $model }};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class {{ $model }}Test extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_attributes()
    {
        ${{ Str::camel($model) }} = new \Modules\{{ $module }}\Entities\{{ $model }};

        $this->assertEquals(
            {!! formatArray($fillable) !!},
            ${{ Str::camel($model) }}->getFillable()
        );
    }

    /** @test */
    public function test_{{ strtolower($model) }}_creation()
    {
        // Arrange
        ${{ strtolower($model) }}Data = [
            @foreach ($fillable as $attribute)
                '{{ $attribute }}' => $this->getTestValue('{{ $attribute }}'),
            @endforeach
        ];

        // Act
        ${{ strtolower($model) }} = {{ $model }}::create(${{ strtolower($model) }}Data);

        // Assert
        $this->assertInstanceOf({{ $model }}::class, ${{ strtolower($model) }});
        $this->assertDatabaseHas('{{ strtolower($module) }}_{{ strtolower($model) }}s', [
            @foreach ($fillable as $attribute)
                '{{ $attribute }}' => $this->getTestValue('{{ $attribute }}'),
            @endforeach
        ]);
    }

    protected function getTestValue($attribute)
    {
        $rules = {{ $model }}::$rules;

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
