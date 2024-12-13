<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    private $number_of_instances;
    private $monitoring_status;

    public function __construct($resource, $number_of_instances, $monitoring_status)
    {
        parent::__construct($resource);
        $this->number_of_instances = $number_of_instances;
        $this->monitoring_status = $monitoring_status;
    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'tasks' => $this->collection,
            'number_of_instances' => $this->number_of_instances,
            'monitoring_status' => $this->monitoring_status
        ];
    }
}
