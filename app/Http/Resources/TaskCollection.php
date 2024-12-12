<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    private $number_of_instances;

    public function __construct($resource, $number_of_instances)
    {
        parent::__construct($resource);
        $this->number_of_instances = $number_of_instances;
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
        ];
    }
}
