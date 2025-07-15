<?php

namespace App\Modules\Transaction\Models;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    //
    protected $table = 'trx_cash';
    protected $guarded = ['id'];

    protected static function booted()
    {
        // for later
        static::retrieved(function ($model) {

            $date = [
                'start' => request('filter.date_start', false),
                'end' => request('filter.date_end', false),
            ];

            if($date['start'] && $date['end'])
            {
                $debt = $model->transactions()->whereBetween('date', [$date['start'],$date['end']])->sum('debt');
                $credit = $model->transactions()->whereBetween('date', [$date['start'],$date['end']])->sum('credit');
            }
            else
            {
                $debt = $model->transactions()->sum('debt');
                $credit = $model->transactions()->sum('credit');
            }
            
            $model->debt = number_format($debt);
            $model->credit = number_format($credit);
            $model->balance = number_format($debt-$credit);
        });

        static::updating(function ($model) {
            unset($model->debt);
            unset($model->credit);
            unset($model->balance);
        });
        
        static::creating(function ($model) {
            unset($model->debt);
            unset($model->credit);
            unset($model->balance);
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

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'cash_id', 'id');
    }
}