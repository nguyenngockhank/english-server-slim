<?php
use Illuminate\Database\Eloquent\Model;

class Word extends Model 
{
    protected $table = 'tbl_edict';
    protected $primaryKey  = 'idx';
    public $timestamps = false;
    
}