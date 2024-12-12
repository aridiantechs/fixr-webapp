<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function store_task($validated_data, $clean_keywords) : bool
    {
        $this->name = $validated_data['task_name'];
        $this->type = $validated_data['task_type'];
        $this->url = $validated_data['task_url'];
        $this->automation_type = trim($validated_data['automation_type']);

        if ($validated_data['automation_type'] === 'non_recurring') {
            $this->start_date_time = $validated_data['start_date_time'];
            $this->end_date_time = $validated_data['end_date_time'];

            $this->recurring_start_week_day = null;
            $this->recurring_end_week_day = null;
            $this->recurring_start_time = null;
            $this->recurring_end_time = null;


        } else {
            $this->recurring_start_week_day = $validated_data['recurring_start_week_day'];
            $this->recurring_end_week_day = $validated_data['recurring_end_week_day'];
            $this->recurring_start_time = $validated_data['recurring_start_time'];
            $this->recurring_end_time = $validated_data['recurring_end_time'];

            $this->start_date_time = null;
            $this->end_date_time = null;
        }

        // Process additional fields
        $this->is_enabled = $validated_data['automation_status'] === 'enabled' ? '1' : '0';
        $this->keywords = json_encode(array_unique($clean_keywords));

        $saved = $this->save();

        return $saved;
    }
}
