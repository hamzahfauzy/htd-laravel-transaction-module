<?php

namespace App\Modules\Transaction\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $table = 'trx_transactions';
    protected $guarded = ['id'];

    protected static function booted()
    {
        // for later
        static::retrieved(function ($model) {
            $model->debt_format = number_format($model->debt);
            $model->credit_format = number_format($model->credit);
            $model->date_format = \Carbon\Carbon::create($model->date)->format('d-m-Y');
        });
        
        static::updating(function ($model) {
            unset($model->debt_format);
            unset($model->credit_format);
            unset($model->date_format);
        });
        
        static::creating(function ($model) {
            unset($model->debt_format);
            unset($model->credit_format);
            unset($model->date_format);
        });
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('d-m-Y H:i:s');
    }

    public function cash()
    {
        return $this->belongsTo(Cash::class, 'cash_id', 'id');
    }
}