<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AutomationResource extends JsonResource
{
    private $number_of_instances;

    public function __construct($resource, $number_of_instances){
        parent::__construct($resource);
        $this->number_of_instances = $number_of_instances;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'automation_type' => $this->automation_type,
            $this->mergeWhen($this->automation_type === 'non_recurring', [
                'start_date_time' => $this->start_date_time,
                'end_date_time' => $this->end_date_time
            ]),
            $this->mergeWhen($this->automation_type === 'recurring', [
                'recurring_start_week_day' => $this->recurring_start_week_day,
                'recurring_end_week_day' => $this->recurring_end_week_day,
                'recurring_start_time' => $this->recurring_start_time,
                'recurring_end_time'=> $this->recurring_end_time
            ]),
            'number_of_instances' => isset($this->number_of_instances) ? $this->number_of_instances : '0',
            'status' => $this->is_enabled == '1' ? 'enabled' : 'disabled'
        ];
    }
}
