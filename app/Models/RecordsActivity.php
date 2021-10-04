<?php

namespace App\Models;

use Illuminate\Support\Arr;
use JetBrains\PhpStorm\ArrayShape;

trait RecordsActivity
{
    public array $oldAttributes = [];

    /**
     *
     */
    public static function bootRecordsActivity()
    {
        foreach (self::getRecordableEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($model->activityDescription($event));
            });

            if ($event == 'updated') {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    protected function activityDescription($description): string
    {
        return "{$description}_".strtolower(class_basename($this));
    }

    /**
     * @return array
     */
    public static function getRecordableEvents(): array
    {
        return static::$recordableEvents ?? ['created', 'updated'];
    }

    /**
     * @param $type
     */
    public function recordActivity($type)
    {
        $this->activity()->create([
            'user_id' => ($this->project ?? $this)->owner->id,
            'description' => $type,
            'changes' => $this->activityChanges($type),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    /**
     * @return array|void
     */
    public function activityChanges($type)
    {
        if ($this->wasChanged()) {
            return [
                'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at')
            ];
        }
    }
}
