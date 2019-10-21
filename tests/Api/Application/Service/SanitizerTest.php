<?php
declare(strict_types=1);

use App\Api\Application\Service\Sanitizer\Sanitizer;
use App\Api\Domain\Request\TypeParamNotAllowed;
use PHPUnit\Framework\TestCase;

class SanitizerTest extends TestCase
{
    /** @test */
    public function test_should_instantiate_a_sanitizer(): void
    {
        $sanitizer = new Sanitizer();

        $this->assertInstanceOf(Sanitizer::class, $sanitizer);
    }

    /** @test */
    public function test_should_sanitize_an_integer_type_param(): void
    {
        $data = [
            'param_1' => [
                'name' => 'param_1',
                'type' => 'integer',
                'value' => '5a23p'
            ]
        ];

        $sanitizer = new Sanitizer();
        $sanitizedData = $sanitizer($data);

        $this->assertEquals('523', $sanitizedData['param_1']);
    }

    /** @test */
    public function test_should_fail_sanitizing_a_non_valid_integer_type_param(): void
    {
        $data = [
            'param_1' => [
                'name' => 'param_1',
                'type' => 'integer',
                'value' => '5a-7+3p'
            ]
        ];

        $this->expectException(InvalidArgumentException::class);

        $sanitizer = new Sanitizer();
        $sanitizer($data);
    }

    /** @test */
    public function test_should_sanitize_a_float_type_param(): void
    {
        $data = [
            'param_1' => [
                'name' => 'param_1',
                'type' => 'float',
                'value' => '42T3.3pp'
            ]
        ];

        $sanitizer = new Sanitizer();
        $sanitizedData = $sanitizer($data);

        $this->assertEquals('423.3', $sanitizedData['param_1']);
    }

    /** @test */
    public function test_should_sanitize_a_string_type_param_with_html(): void
    {
        $data = [
            'param_1' => [
                'name' => 'param_1',
                'type' => 'string',
                'value' => '<p>lorem ipsum</p>'
            ]
        ];

        $sanitizer = new Sanitizer();
        $sanitizedData = $sanitizer($data);

        $this->assertEquals('lorem ipsum', $sanitizedData['param_1']);
    }

    /** @test */
    public function test_should_sanitize_a_boolean_type_param_with_html(): void
    {
        $data = [
            'param_1' => [
                'name' => 'param_1',
                'type' => 'boolean',
                'value' => 'yes'
            ]
        ];

        $sanitizer = new Sanitizer();
        $sanitizedData = $sanitizer($data);

        $this->assertEquals(true, $sanitizedData['param_1']);
    }

    /** @test */
    public function test_should_sanitize_an_array_of_strings_type_param(): void
    {
        $data = [
            'param_1' => [
                'name' => 'param_1',
                'type' => 'array of strings',
                'value' => array('<p>lorem</p>', '<h2>ipsum</h2>', '!dolor¡')
            ]
        ];

        $sanitizer = new Sanitizer();
        $sanitizedData = $sanitizer($data);

        $this->assertEquals(3, count($sanitizedData['param_1']));
        $this->assertEquals('ipsum', ($sanitizedData['param_1'][1]));
    }

    /** @test */
    public function test_should_sanitize_an_array_of_integers_type_param_with_html(): void
    {
        $data = [
            'param_1' => [
                'name' => 'param_1',
                'type' => 'array of integers',
                'value' => array('5a23p', '57', '564Y')
            ]
        ];

        $sanitizer = new Sanitizer();
        $sanitizedData = $sanitizer($data);

        $this->assertEquals(3, count($sanitizedData['param_1']));
        $this->assertEquals('523', ($sanitizedData['param_1'][0]));
    }

    /** @test */
    public function test_should_sanitize_an_url_type_param(): void
    {
        $data = [
            'param_1' => [
                'name' => 'param_1',
                'type' => 'url',
                'value' => 'https://www.examp��le.co�m'
            ]
        ];

        $sanitizer = new Sanitizer();
        $sanitizedData = $sanitizer($data);

        $this->assertEquals('https://www.example.com', $sanitizedData['param_1']);
    }

    /** @test */
    public function test_should_sanitize_an_email_type_param(): void
    {
        $data = [
            'param_1' => [
                'name' => 'param_1',
                'type' => 'email',
                'value' => 'john(.doe)@exa//mple.com'
            ]
        ];

        $sanitizer = new Sanitizer();
        $sanitizedData = $sanitizer($data);

        $this->assertEquals('john.doe@example.com', $sanitizedData['param_1']);
    }

    /** @test */
    public function test_should_sanitize_a_date_type_param(): void
    {
        $data = [
            'param_1' => [
                'name' => 'param_1',
                'type' => 'date',
                'value' => '2019-10-21'
            ]
        ];

        $sanitizer = new Sanitizer();
        $sanitizedData = $sanitizer($data);

        $this->assertEquals('2019-10-21', $sanitizedData['param_1']);
    }

    /** @test */
    public function test_should_fails_sanitizing_an_invalid_date_type_param(): void
    {
        $data = [
            'param_1' => [
                'name' => 'param_1',
                'type' => 'date',
                'value' => '10-2019-21'
            ]
        ];

        $this->expectException(InvalidArgumentException::class);

        $sanitizer = new Sanitizer();
        $sanitizedData = $sanitizer($data);

        $this->assertEquals('2019-10-21', $sanitizedData['param_1']);
    }

    /** @test */
    public function test_should_fail_sanitizing_a_non_valid_type_param(): void
    {
        $data = [
            'param_1' => [
                'name' => 'param_1',
                'type' => 'random',
                'value' => '5a-7+3p'
            ]
        ];

        $this->expectException(TypeParamNotAllowed::class);

        $sanitizer = new Sanitizer();
        $sanitizer($data);
    }
}