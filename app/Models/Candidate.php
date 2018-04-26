<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{


    use CrudTrait;
    protected $fillable=['first_name','last_name','document','department_id','city_id','profession_id','address','phone'
	    ,'phone_alt','photo','enter_date'];


    public function department(){
    	return $this->belongsTo(Department::class);
    }

    public function city(){
    	return $this->belongsTo(City::class);
    }

    public function profession(){
    	return $this->belongsTo(Profession::class);
    }

	public function setPhotoAttribute($value)
	{
		$attribute_name = "photo";
		$disk = "public";
		$destination_path = "uploads/candidates_photos";

		// if the image was erased
		if ($value==null) {
			// delete the image from disk
			\Storage::disk($disk)->delete($this->photo);

			// set null in the database column
			$this->photo = null;
			$this->save();
		}

		// if a base64 was sent, store it in the db
		if (starts_with($value, 'data:image'))
		{
			// 0. Make the image
			$image = \Image::make($value);
			// 1. Generate a filename.
			$filename = md5($value.time()).'.jpg';
			// 2. Store the image on disk.
			\Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
			// 3. Save the path to the database
			if ($this->photo){
				\Storage::disk($disk)->delete($this->photo);
			}
			$this->attributes['photo'] = $destination_path.'/'.$filename;
			//$this->save();
		}
	}

	public function getFullNameAttribute(){
    	return $this->first_name.' '.$this->last_name;
	}
}
