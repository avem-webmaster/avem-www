<?php

namespace Avem;

use Illuminate\Database\Eloquent\Model;

class PerformedActivity extends Model implements Transactionable
{
	public function activity()
	{
		return $this->belongsTo('Avem\Activity');
	}

	public function getTransactionConceptAttribute()
	{
		return $this->activity->name;
	}

	public function getTransactionPeriodAttribute()
	{
		return $this->witnesserPeriod;
	}

	public function getTransactionPointsAttribute()
	{
		return $this->activity->points;
	}

	public function transaction()
	{
		return $this->morphOne('Avem\Transaction');
	}

	public function user()
	{
		return $this->belongsTo('Avem\User');
	}

	public function witnesserPeriod()
	{
		return $this->belongsTo('Avem\MbMemberPeriod');
	}
}
