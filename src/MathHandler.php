<?php

namespace Russell\HNG;

use stdClass;

/**
 * A simple class to handle basic math operations from the request
 */
class MathHandler
{

    /**
     * The request data
     *
     * @var object
     */
    protected object $data;

    /**
     * An array of supported operations
     *
     * @var array
     */
    protected array $supported_operations = [
        'addition',
        'subtraction',
        'multiplication'
    ];

    /**
     * The constructor
     *
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->data = $data;
    }

    /**
     * Try to figure out the operation based on the string supplied
     *
     * @return void
     */
    protected function inferOperation(): void
    {
        if (stripos($this->data->operation_type, 'add') !== false) {
            $this->data->operation_type = 'addition';
        }

        if (stripos($this->data->operation_type, 'subtract') !== false) {
            $this->data->operation_type = 'subtraction';
        }

        if (stripos($this->data->operation_type, 'multipl') !== false) {
            $this->data->operation_type = 'multiplication';
        }
    }

    /**
     * Clean up the submitted data
     *
     * @return void
     */
    protected function sanitize(): void
    {
        $this->data->operation_type = strtolower(trim($this->data->operation_type));

        if (!in_array($this->data->operation_type, $this->supported_operations)) {
            $this->inferOperation();
        }

        $this->data->x = (int)$this->data->x;
        $this->data->y = (int)$this->data->y;
    }

    /**
     * Process the supplied data
     *
     * @return object
     */
    protected function run(): object
    {
        $this->sanitize();

        $response = new stdClass;
        $response->slackUsername = 'russell';
        $response->result = null;
        $response->operation_type = $this->data->operation_type;

        switch ($this->data->operation_type) {
            case 'addition':
                $response->result = $this->data->x + $this->data->y;
                break;
            case 'subtraction':
                $response->result = $this->data->x - $this->data->y;
                break;
            case 'multiplication':
                $response->result = $this->data->x * $this->data->y;
                break;
            default:
                $response->operation_type = null;
                break;
        }
        return $response;
    }

    /**
     * Get the result
     *
     * @return object The result
     */
    public function getResult()
    {
        return $this->run();
    }
}
