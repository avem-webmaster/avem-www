<?php

namespace Avem;

use Illuminate\Database\Eloquent\Model;

class WorkingGroup extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'ifmsa_name', 'ifmsa_acronym', 'color', 'description', 'index'
	];

	public function charges()
	{
		return $this->hasMany('Avem\Charge');
	}

	public function getColorAttribute()
	{
		$selfColor = $this->attributes['color'];
		if ($selfColor != null)
			return $selfColor;
		
		if ($this->parent_group_id !== null)
			return $this->parentGroup->color;

		return null;
	}

	public function subgroups()
	{
		return $this->hasMany('Avem\WorkingGroup', 'parent_group_id');
	}

	public function parentGroup()
	{
		return $this->belongsTo('Avem\WorkingGroup');
	}

	public function tags()
	{
		return $this->morphToMany('Avem\Tag', 'taggable');
	}
}
