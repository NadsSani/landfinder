<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
 
class landlisttableModel extends Model
{
    protected $table = 'landlisttable';
 
    protected $allowedFields = ['id', 'placename','img1','img2','img3','village','hbtaluk','googlemap','propertiesonland','otherspec','leagalissues','landtype','contactnum','address','price'];
}
