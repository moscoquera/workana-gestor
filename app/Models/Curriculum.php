<?php

namespace App\Models;

use App\Events\CurriculumSave;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Curriculum extends Model
{

    use CrudTrait;
    use Notifiable;



    protected $table='curriculums';

    protected $fillable=['user_id',
        'birth_city_id','birth_dep_id',
        'resume','attachments'];

    protected $casts = ['attachments' => 'array'];

    protected $appends=['photo','document','sex','date_of_birth',
        'nationality_id','current_address','current_dep_id','current_city_id','current_country_id','phone',
        'mobile','profession_id',];


    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
    }

    public function user(){
        return $this->belongsTo('App\Models\PublicUser');
    }

    public function birthDepartment(){
        return $this->belongsTo('App\Models\Department','birth_dep_id');
    }

    public function birthCity(){
        return $this->belongsTo('App\Models\City','birth_city_id');
    }



    public function skills(){
        return $this->belongsToMany('App\Models\Skill')->using('App\Models\CurriculumSkill');
    }

    public function educations(){
        return $this->hasMany('App\Models\CurriculumEducation');
    }

    public function experiences(){
        return $this->hasMany('App\Models\Experience')->orderBy('start_date','desc');
    }

    public function languages(){
        return $this->belongsToMany('App\Models\Language')
            ->as('proficency')->using('App\Models\CurriculumLanguage')
            ->withTimestamps()->withPivot('writing','speaking');
    }

    public function personal_references(){
        return $this->hasMany('App\Models\Reference')->where('type','p');
    }

    public function familiar_references(){
        return $this->hasMany('App\Models\Reference')->where('type','f');
    }


    public function setPhotoAttribute($value)
    {
        $attribute_name = "photo";
        $disk = "public";
        $destination_path = "uploads/curriculum_photos";

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->user->photo);

            // set null in the database column
            $this->user->photo = null;
            $this->user->save();
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
            if ($this->user->photo){
                \Storage::disk($disk)->delete($this->user->photo);
            }
            $this->user->photo = $destination_path.'/'.$filename;
            $this->user->save();
        }
    }

    public function getPhotoAttribute(){
        return $this->user->photo;
    }


    public function getDocumentAttribute(){
        return $this->user->username;
    }

    public function setDocumentAttribute($value){
        $this->user->username=$value;
        $this->user->save();
    }

    public function getProfessionIdAttribute(){
        return $this->user->profession_id;
    }

    public function getSexAttribute(){
        return $this->user->sex;
    }

    public function getDateOfBirthAttribute(){
        return $this->user->date_of_birth;
    }

    public function getNationalityIdAttribute(){
        return $this->user->nationality_id;
    }

    public function getCurrentAddressAttribute(){
        return $this->user->current_address;
    }

    public function getCurrentDepIdAttribute(){
        return $this->user->current_dep_id;
    }

    public function getCurrentCityIdAttribute(){
        return $this->user->current_city_id;
    }

    public function getCurrentCountryIdAttribute(){
        return $this->user->current_country_id;
    }

    public function getPhoneAttribute(){
        return $this->user->phone;
    }

    public function getMobileAttribute(){
        return $this->user->mobile;
    }

    public function getMobile2Attribute(){
        return $this->user->mobile2;
    }

    public function setProfessionIdAttribute($value){
        $this->user->profession_id=$value;
        $this->user->save();
    }

    public function setSexAttribute($value){
        $this->user->sex=$value;
        $this->user->save();
    }

    public function setDateOfBirthAttribute($value){
        $this->user->date_of_birth=$value;
        $this->user->save();
    }

    public function setNationalityIdAttribute($value){
        $this->user->nationality_id=$value;
        $this->user->save();
    }

    public function setCurrentAddressAttribute($value){
        $this->user->current_address=$value;
        $this->user->save();
    }

    public function setCurrentDepIdAttribute($value){
        $this->user->current_dep_id=$value;
        $this->user->save();
    }

    public function setCurrentCityIdAttribute($value){
        $this->user->current_city_id=$value;
        $this->user->save();
    }

    public function setCurrentCountryIdAttribute($value){
        $this->user->current_country_id=$value;
        $this->user->save();
    }

    public function setPhoneAttribute($value){
        $this->user->phone=$value;
        $this->user->save();
    }

    public function setMobileAttribute($value){
        $this->user->mobile=$value;
        $this->user->save();
    }

    public function setMobile2Attribute($value){
        $this->user->mobile2=$value;
        $this->user->save();
    }

    public function profession(){
        return $this->belongsTo('App\Models\Profession');
    }

    public function getCurrentCityAttribute(){
        return $this->user->currentCity;
    }

    public function currentcompanies(){
        return $this->experiences()->currently()->get();
    }



}
